<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Validator;

class InputReceiptController extends Controller
{
    public function index() {
        $data = DB::table('PHIEUNHAPSACH')->orderBy('MaPhieuNhapSach', 'desc')->get();
        return View::make("inputreceipt.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('PHIEUNHAPSACH')
            ->join('CHITIETPHIEUNHAPSACH', 'PHIEUNHAPSACH.MaPhieuNhapSach', '=', 'CHITIETPHIEUNHAPSACH.MaPhieuNhapSach')
            ->join('SACH', 'SACH.MaSach', '=', 'CHITIETPHIEUNHAPSACH.MaSach')
            ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
            ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
            ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'DAUSACH.MaTacGia')
            ->select('CHITIETPHIEUNHAPSACH.*', 'SACH.NhaXuatBan', 'SACH.NamXuatBan', 'DAUSACH.TenDauSach', 'DAUSACH.MaDauSach','THELOAI.*', 'TACGIA.TenTacGia', 'TACGIA.MaTacGia')
            ->where('PHIEUNHAPSACH.MaPhieuNhapSach', $id)
            ->orderBy('CHITIETPHIEUNHAPSACH.MaSach', 'desc')->get();

        $inputReceipt = DB::table('PHIEUNHAPSACH')->where('MaPhieuNhapSach', $id)->first();
        return View::make("inputreceipt.detail")->with(['data' => $data, 'inputReceipt' => $inputReceipt]);
    }

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('PHIEUNHAPSACH')->where('MaPhieuNhapSach', '=', $input['id'])->delete();
        }
        catch (\Exception $e) {
            $queryResult = 0;
        }

        $response = [];
        $response['success'] = false;

        if($queryResult == 1) {
            $response['success'] = true;
        }

        return response()->json($response);
    }

    public function addView() {
        $data = DB::table('DAUSACH')->orderBy('MaDauSach', 'desc')->get();
        return View::make("inputreceipt.add")->with(['book' => $data]);
    }

    public function getBookEditionOptionList(Request $request) {
        $input = $request->all();

        $data = DB::table('SACH')
                ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
                ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
                ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'DAUSACH.MaTacGia')
                ->select('SACH.*', 'THELOAI.TenTheLoai', 'TACGIA.TenTacGia')
                ->where('SACH.MaDauSach', $input['id'])->orderBy('MaSach', 'desc')->get();
        return response()->json($data);
    }

    public function add(Request $request) {
        $input = $request->all();

        $sequence = DB::getSequence();
        $insertId = $sequence->nextValue('S_MAPHIEUNHAPSACH_ID');

        $data = $input['data'];
        try {
            $queryResult = DB::transaction(function() use ($insertId, $data) {
                DB::insert('insert into PHIEUNHAPSACH (MaPhieuNhapSach, NgayLap,TongTien) values (?,sysdate , ?)', [$insertId, 0]);

                foreach ($data as $dt) {
                    DB::statement('call update_baocaoton(?, ?)',[$dt['id'], $dt['quantity']]);

                    DB::table('CHITIETPHIEUNHAPSACH')->insert([
                        [
                            'MaPhieuNhapSach' => $insertId,
                            'MaSach' => $dt['id'],
                            'SoLuong' =>  $dt['quantity'],
                            'DonGiaNhap' =>  0
                        ]
                    ]);
                }

                DB::statement('call proc_after_create_phieunhap(?)',[$insertId]);
            });

        } catch (\Exception $e) {
            $queryResult = 0;
            $errorCode = $e->getCode();
        }

        $response = [];
        $response['success'] = true;
        $response['id'] = $insertId;
    
        if($queryResult === 0) {
            $response['success'] = false;
            $response['message'] = '';

            if($errorCode == 20001) {
                $query = DB::table('THAMSO')->select('SoLuongNhapToiThieu')->first();
                $value = $query->soluongnhaptoithieu;
                $response['message'] = trans('inputreceipt.min_input_receipt_value_error', ['value' => $value]);
            }
            
            if($errorCode == 20002) {
                $query = DB::table('THAMSO')->select('SoLuongTonDeNhapToiDa')->first();
                $value = $query->soluongtondenhaptoida;
                $response['message'] = trans('inputreceipt.max_input_receipt_stock_value_error', ['value' => $value]);
            }
        }

        return response()->json($response);
    }
}
