<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Input;

class ReportController extends Controller
{
    public function index($type) {
    	if($type == 'debt') {
    		return View::make("report.debt");
    	}
    	else if ($type == 'inventory') {
    		return View::make("report.inventory");
    	}
	}
	
	public function createInventoryReport(Request $request) {
		$input = $request->all();

		$year = substr($input['date'], 0,4);
		$month = substr($input['date'], -2);	


		$data = DB::table('BAOCAOTON')
				->join('SACH', 'SACH.MaSach', '=', 'BAOCAOTON.MaSach')
				->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
				->where([
					['thang', '=', $month],
					['nam', '=', $year],
				])			
                ->orderBy('BAOCAOTON.MaSach', 'asc')->get();

		return redirect()->back()->with(['data'=> $data, 'month' => $month, 'year' => $year])->withInput();
	}

	public function createDebtReport(Request $request) {
		$input = $request->all();

		$year = substr($input['date'], 0,4);
		$month = substr($input['date'], -2);	


		$data = DB::table('BAOCAOCONGNO')
				->join('KHACHHANG', 'KHACHHANG.MaKhachHang', '=', 'BAOCAOCONGNO.MaKhachHang')
				->where([
					['thang', '=', $month],
					['nam', '=', $year],
				])			
                ->orderBy('KHACHHANG.MaKhachHang', 'asc')->get();

				return redirect()->back()->with(['data'=> $data, 'month' => $month, 'year' => $year])->withInput();
	}
}
