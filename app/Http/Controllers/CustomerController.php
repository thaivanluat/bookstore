<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class CustomerController extends Controller
{
    public function index() {
    	$data = DB::table('KHACHHANG')->orderBy('MaKhachHang', 'desc')->get();
    	return View::make("customer.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $customer = DB::table('KHACHHANG')->select('*')->where('MaKhachHang', $id)->first();
        $invoices = DB::table('HOADON')->select('*')->where('MaKhachHang', $id)->get();
        $receipts = DB::table('PHIEUTHU')->select('*')->where('MaKhachHang', $id)->get();
        return View::make("customer.detail")->with(['customer' => $customer, 'invoices' => $invoices, 'receipts' => $receipts]);
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $validatedData = $request->validate([
                'email' => 'email'
            ]);
            
            $queryResult = DB::table('KHACHHANG')
                            ->where('MaKhachHang', $input['id'])
                            ->update([
                                'HoTen' => $input['name'],
                                'DienThoai' => $input['phone'],
                                'DiaChi' => $input['address'],
                                'Email' => $input['email']
                                ]);

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

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('KHACHHANG')->where('MaKhachHang', '=', $input['id'])->delete();
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
        $insertId = $sequence->nextValue('S_MAKHACHHANG_ID');

        try {
            $validatedData = $request->validate([
                'email' => 'email'
            ]);

            $queryResult = DB::table('KHACHHANG')->insert([
                [
                    'MaKhachHang' => $insertId,
                    'HoTen' => $input['name'],
                    'DienThoai' => $input['phone'],
                    'DiaChi' => $input['address'],
                    'Email' => $input['email'],
                    'TongNo' => 0
                ]
            ]);
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
}
