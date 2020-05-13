<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class InvoiceController extends Controller
{
    public function index() {
        $data = DB::table('HOADON')
                ->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'HOADON.MaKhachHang')
                ->select('HOADON.*', 'KHACHHANG.HoTen')
                ->orderBy('MaHoaDon', 'desc')->get();
        return View::make("invoice.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('HOADON')
            ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
            ->join('SACH', 'SACH.MaSach', '=', 'CHITIETHOADON.MaSach')
            ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
            ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
            ->join('CHITIETTACGIA', 'CHITIETTACGIA.MaDauSach', '=', 'DAUSACH.MaDauSach')
            ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'CHITIETTACGIA.MaTacGia')
            ->select('CHITIETHOADON.*', 'SACH.NhaXuatBan', 'SACH.NamXuatBan', 'DAUSACH.TenDauSach', 'DAUSACH.MaDauSach','THELOAI.*', 'TACGIA.TenTacGia', 'TACGIA.MaTacGia')
            ->where('HOADON.MaHoaDon', $id)
            ->orderBy('CHITIETHOADON.MaSach', 'desc')->get();

        $invoice = DB::table('HOADON')
                    ->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'HOADON.MaKhachHang')
                    ->select('*')
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
        return View::make("invoice.add")->with(['book' => $data]);
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

        $data = $input['data'];
        try {
            $queryResult = DB::transaction(function() use ($insertId, $data, $input,$insertReceiptId) {

                DB::insert('insert into HOADON (MaHoaDon, NgayLap, MaKhachHang, TongTien, SoTienTra) 
                values (?,sysdate , ?, ?, ?)', [$insertId, $input['customer_id'], 0, $input['amount']]);

                foreach ($data as $dt) {

                    // DB::insert('insert into BAOCAOTON (MaSach, NgayNhap, TonDau, TonCuoi, PhatSinh) 
                    // values (?,sysdate , ?, ?, ?)', [ $dt['id'], 0, 0, -$dt['quantity']]);

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
    
                DB::statement('call proc_update_price_CHITIETHOADON(?)',[$insertId]);
                DB::statement('call proc_update_total_HoaDon(?)',[$insertId]);

                DB::insert('insert into PHIEUTHU (MaPhieuThu, MaKhachHang, NgayLap, SoTienThu) 
                values (?,? , sysdate, ?)', [$insertReceiptId, $input['customer_id'], $input['amount']]);

                // DB::insert('insert into BAOCAOCONGNO (MaKhachhang, NgayNhap, NoDau, NoCuoi, PhatSinh) 
                // values (?, sysdate, ?, ?, ?)', [$input['customer_id'], 0, 0, $input['amount']]);
            });

        } catch (\Exception $e) {
            $queryResult = 0;
        }

        $response = [];
        $response['success'] = true;
        $response['id'] = $insertId;
    
        if($queryResult === 0) {
            $response['success'] = false;
        }

        return response()->json($response);
    }
}
