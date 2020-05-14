<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class ReceiptController extends Controller
{
    public function index() {
    	$data = DB::table('PHIEUTHU')
                ->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'PHIEUTHU.MaKhachHang')
                ->select('PHIEUTHU.*', 'KHACHHANG.HoTen')
                ->orderBy('MaPhieuThu', 'desc')->get();
        return View::make("receipt.index")->with(['data' => $data]);
    }

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('PHIEUTHU')->where('MaPhieuThu', '=', $input['id'])->delete();
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

    public function add(Request $request) {
        $input = $request->all();

        $sequence = DB::getSequence();
        $insertId = $sequence->nextValue('S_MAPHIEUTHU_ID');

        try {
            $validatedData = $request->validate([
                'value' => 'required|min:0|integer|not_in:0'
            ]);

            $queryResult = DB::transaction(function() use ($insertId, $input) {
                DB::insert('insert into PHIEUTHU 
                (MaPhieuThu, MaKhachHang, NgayLap, SoTienThu) 
                values (?, ?,sysdate , ?)', [$insertId, $input['customer_id'], $input['value']]);

                DB::statement('call update_baocaocongno_when_create_phieuthu(?, ?)',[$input['customer_id'], $input['value']]);
            });
        }
        catch (\Exception $e) {
            $queryResult = 0;
        }

        $response = [];
        $response['success'] = true;

        if($queryResult === 0) {
            $response['success'] = false;
        }

        return response()->json($response);
    }
}
