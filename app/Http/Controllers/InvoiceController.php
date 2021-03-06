<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Session;

class InvoiceController extends Controller
{
    public function index() {
        $data = DB::table('HOADON')
                ->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'HOADON.MaKhachHang')
                ->join('NGUOIDUNG', 'NGUOIDUNG.MaNguoiDung', '=', 'HOADON.NguoiTao')
                ->select('HOADON.*', 'KHACHHANG.HoTen','NGUOIDUNG.HoTen as nguoitao')
                ->orderBy('MaHoaDon', 'desc')->get();
        return View::make("invoice.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('HOADON')
            ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
            ->join('SACH', 'SACH.MaSach', '=', 'CHITIETHOADON.MaSach')
            ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
            ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
            ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'DAUSACH.MaTacGia')
            ->select('CHITIETHOADON.*', 'SACH.NhaXuatBan', 'SACH.NamXuatBan', 'DAUSACH.TenDauSach', 'DAUSACH.MaDauSach','THELOAI.*', 'TACGIA.TenTacGia', 'TACGIA.MaTacGia')
            ->where('HOADON.MaHoaDon', $id)
            ->orderBy('CHITIETHOADON.MaSach', 'desc')->get();

        $invoice = DB::table('HOADON')
                    ->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'HOADON.MaKhachHang')
                    ->join('NGUOIDUNG', 'NGUOIDUNG.MaNguoiDung', '=', 'HOADON.NguoiTao')
                    ->select('HOADON.MaHoaDon','HOADON.TongTien','HOADON.SoTienTra','KHACHHANG.*','NGUOIDUNG.HoTen as nguoitao')
                    ->where('MaHoaDon', $id)->first();
        return View::make("invoice.detail")->with(['data' => $data, 'invoice' => $invoice]);
    }

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('HOADON')->where('MaHoaDon', '=', $input['id'])->delete();
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
        $discount = DB::table('THAMSO')->select('TiLeGiamGia')->first();
        return View::make("invoice.add")->with(['book' => $data, 'discount' => $discount]);
    }

    public function getBookEditionOptionList(Request $request) {
        $input = $request->all();

        $data = DB::table('SACH')->where('MaDauSach', $input['id'])->orderBy('MaSach', 'desc')->get();
        return response()->json($data);
    }

    public function searchCustomer(Request $request) {
        $input = $request->all();
        $information = '%'.$input['q'].'%';

        $data = DB::table('KHACHHANG')
                    ->where('MaKhachHang', 'like', $information)
                    ->orWhere('HoTen', 'like', $information)
                    ->orwhere('DienThoai', 'like', $information)
                    ->orwhere('Email', 'like', $information)
                    ->select('*')
                    ->orderBy('MaKhachHang', 'desc')
                    ->get();

        return response()->json($data);
    }

    public function add(Request $request) {
        $input = $request->all();

        $sequence = DB::getSequence();
        $insertId = $sequence->nextValue('S_MAHOADON_ID');
        $insertReceiptId = $sequence->nextValue('S_MAPHIEUTHU_ID');

        $user = Session::get('user');
        $userId = $user->manguoidung;

        $data = $input['data'];
        try {
            $queryResult = DB::transaction(function() use ($insertId, $data, $input,$insertReceiptId, $userId) {
                
                DB::insert('insert into HOADON (MaHoaDon, NgayLap, MaKhachHang, TongTien, SoTienTra, NguoiTao) 
                values (?,sysdate , ?, ?, ?,?)', [$insertId, $input['customer_id'], 0, $input['amount'], $userId]);

                foreach ($data as $dt) {

                    DB::statement('call update_baocaoton(?, ?)',[$dt['id'], -$dt['quantity']]);

                    DB::table('CHITIETHOADON')->insert([
                        [
                            'MaHoaDon' => $insertId,
                            'MaSach' => $dt['id'],
                            'SoLuong' =>  $dt['quantity'],
                            'DonGia' =>  0,
                            'ThanhTien' => 0
                        ]
                    ]);
                }
    
                DB::statement('call proc_after_create_hoadon(?, ?)',[$input['customer_id'], $insertId]);

                DB::insert('insert into PHIEUTHU (MaPhieuThu, MaKhachHang, NgayLap, SoTienThu) 
                values (?,? , sysdate, ?)', [$insertReceiptId, $input['customer_id'], $input['amount']]);

                DB::statement('call update_baocaocongno(?, ?)',[$input['customer_id'], $insertId]);

                DB::statement('call capnhat_trangthai(?)',[$input['customer_id']]);    
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

            if($errorCode == 20003) {
                $query = DB::table('THAMSO')->select('TongNoToiDa')->first();
                $value = $query->tongnotoida;
                $response['message'] = trans('invoice.max_debt_value_error', ['value' => $value]);
            }
            
            if($errorCode == 20004) {
                $query = DB::table('THAMSO')->select('LuongTonSauKhiBanToiThieu')->first();
                $value = $query->luongtonsaukhibantoithieu;
                $response['message'] = trans('invoice.min_stock_after_sold_value_error', ['value' => $value]);
            }
        }

        return response()->json($response);
    }
}
