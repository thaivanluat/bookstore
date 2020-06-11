<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Session;

class InventoryController extends Controller
{
    public function index() {
        $data = DB::table('PHIEUKIEMKHO')
            ->join('NGUOIDUNG', 'NGUOIDUNG.MaNguoiDung', '=', 'PHIEUKIEMKHO.NguoiTao')
            ->select('PHIEUKIEMKHO.MaPhieuKiem', 'PHIEUKIEMKHO.NgayTao', 'NGUOIDUNG.HoTen')
            ->orderBy('MaPhieuKiem', 'desc')->get();
        return View::make("inventory.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('PHIEUKIEMKHO')
            ->join('CHITIETPHIEUKIEMKHO', 'PHIEUKIEMKHO.MaPhieuKiem', '=', 'CHITIETPHIEUKIEMKHO.MaPhieuKiem')
            ->join('SACH', 'SACH.MaSach', '=', 'CHITIETPHIEUKIEMKHO.MaSach')
            ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
            ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
            ->join('CHITIETTACGIA', 'CHITIETTACGIA.MaDauSach', '=', 'DAUSACH.MaDauSach')
            ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'CHITIETTACGIA.MaTacGia')
            ->select('CHITIETPHIEUKIEMKHO.*', 'SACH.NhaXuatBan', 'SACH.NamXuatBan', 'DAUSACH.TenDauSach', 'DAUSACH.MaDauSach','THELOAI.*', 'TACGIA.TenTacGia', 'TACGIA.MaTacGia')
            ->where('PHIEUKIEMKHO.MaPhieuKiem', $id)
            ->orderBy('CHITIETPHIEUKIEMKHO.MaSach', 'desc')->get();

        $inventoryCheck= DB::table('PHIEUKIEMKHO')->where('MaPhieuKiem', $id)->first();
        return View::make("inventory.detail")->with(['data' => $data, 'inventoryCheck' => $inventoryCheck]);
    }

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('PHIEUKIEMKHO')->where('MaPhieuKiem', '=', $input['id'])->delete();
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
        return View::make("inventory.add")->with(['book' => $data]);
    }

    public function getBookEditionOptionList(Request $request) {
        $input = $request->all();

        $data = DB::table('SACH')
                ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
                ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
                ->join('CHITIETTACGIA', 'CHITIETTACGIA.MaDauSach', '=', 'DAUSACH.MaDauSach')
                ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'CHITIETTACGIA.MaTacGia')
                ->select('SACH.*', 'THELOAI.TenTheLoai', 'TACGIA.TenTacGia')
                ->where('SACH.MaDauSach', $input['id'])->orderBy('MaSach', 'desc')->get();
        return response()->json($data);
    }

    public function add(Request $request) {
        $input = $request->all();

        $sequence = DB::getSequence();
        $insertId = $sequence->nextValue('S_MAPHIEUKIEM_ID');

        $user = Session::get('user');
        $userId = $user->manguoidung;

        $data = $input['data'];
        try {
            $queryResult = DB::transaction(function() use ($insertId, $data, $userId) {

                DB::insert('insert into PHIEUKIEMKHO (MaPhieuKIem, NguoiTao,NgayTao) values (?,?,sysdate)', [$insertId, $userId]);

                foreach ($data as $dt) {

                    DB::table('CHITIETPHIEUKIEMKHO')->insert([
                        [
                            'MaPhieuKiem' => $insertId,
                            'MaSach' => $dt['id'],
                            'ThucTe' =>  $dt['quantity'],
                            'TonKho' =>  0,
                            'GiaTriLech' => 0
                        ]
                    ]);
                }
            });

        } catch (\Exception $e) {
            $queryResult = 0;
        }

        $response = [];
        $response['success'] = true;
        $response['id'] = $insertId;
    
        if($queryResult === 0) {
            $response['success'] = false;
            $response['message'] = '';
        }

        return response()->json($response);
    }
}
