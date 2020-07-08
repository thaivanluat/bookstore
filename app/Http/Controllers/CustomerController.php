<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use PDF;
use Session;

class CustomerController extends Controller
{
    public function index() {
    	$data = DB::table('KHACHHANG')->orderBy('MaKhachHang', 'desc')->get();
    	return View::make("customer.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $customer = DB::table('KHACHHANG')->select('*')->where('MaKhachHang', $id)->first();
        $invoices = DB::table('HOADON')->select('*')->where('MaKhachHang', $id)->orderBy('NgayLap', 'desc')->get();
        $receipts = DB::table('PHIEUTHU')->select('*')->where('MaKhachHang', $id)->orderBy('NgayLap', 'desc')->get();
        return View::make("customer.detail")->with(['customer' => $customer, 'invoices' => $invoices, 'receipts' => $receipts]);
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $validatedData = $request->validate([
                'email' => 'email'
            ]);
            DB::beginTransaction();
            DB::statement('set transaction isolation level serializable');
            $queryResult = DB::table('KHACHHANG')
                            ->where('MaKhachHang', $input['id'])
                            ->update([
                                'HoTen' => $input['name'],
                                'DienThoai' => $input['phone'],
                                'DiaChi' => $input['address'],
                                'Email' => $input['email'],
                                'SinhNhat' => $input['birthday']
                                ]);
                                DB::commit();
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
                    'SinhNhat' =>$input['birthday'],
                    'Email' => $input['email'],
                    'TrangThai' => 'normal',
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

    public function birthday() {
        return View::make("customer.birthday");
    }

    public function birthdaySearch(Request $request) {
        $input = $request->all();

        $month = $input['month'];
        $type = $input['type'];

        $data = DB::table('KHACHHANG')
                ->whereMonth('SinhNhat', $month)
                ->where('TrangThai', $type)			
                ->orderBy('KHACHHANG.MaKhachHang', 'asc')->get();
        
        $type = ($type == 'vip') ? trans('customer.vip_customer') : trans('customer.normal_customer');

        if(!empty($input['print'])) {
            if(Session::has('query_customer')) {
                $pdf = PDF::loadView('customer.birthday_print', ['data'=> Session::get('query_customer'), 'month' => $month, 'type' => $type]);
            }
            else {
                $pdf = PDF::loadView('customer.birthday_print', ['data'=> $data, 'month' => $month, 'type' => $type]);
            }

            // $pdf = PDF::loadView('customer.birthday_print', ['data'=> $data, 'month' => $month, 'type' => $type]);

            $pdf->setPaper('a4', 'landscape');

            Session::put('query_customer', $data);
            return $pdf->download('customer_list.pdf');
            // return view::make('customer.birthday_print')->with(['data'=> $data, 'month' => $month, 'type' => $type]);
        }
        else {
            Session::put('query_customer', $data);
            return redirect()->back()->with(['data'=> $data, 'month' => $month, 'type' => $type])->withInput();
        }        
    }
}
