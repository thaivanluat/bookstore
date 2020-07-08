<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Input;
use PDF;
use Session;
use URL;
use PHPJasper\PHPJasper;

class ReportController extends Controller
{
    public function index($type) {
    	if($type == 'debt') {
    		return View::make("report.debt");
    	}
    	else if ($type == 'inventory') {
    		return View::make("report.inventory");
		}
		
		switch ($type) {
			case 'debt':
				return View::make("report.debt");
				break;
			case 'inventory':
				return View::make("report.inventory");
				break;
			case 'customer':
				return View::make("report.customer");
				break;
			case 'staff':
				return View::make("report.staff");
				break;
		}
	}

	public function createStaffReport(Request $request) {
		$rootfolder =  $_SERVER['DOCUMENT_ROOT'];
		$input = $rootfolder.'/bookstore/vendor/geekcom/phpjasper/examples/report.jasper';  
		$output = $rootfolder.'/bookstore/vendor/geekcom/phpjasper/examples';    
		$options = [
			'format' => ['pdf'],
			'locale' => 'en',
			'params' => [],
			'db_connection' => [
				'driver' => 'oracle', //mysql, ....
				'username' => 'project',
				'password' => '123456',
				'host' => 'localhost',
				'database' => 'root',
				'port' => '1521'
			]
		];
		
		$jasper = new PHPJasper;
		
		$command = $jasper->process(
				$input,
				$output,
				$options
		)->execute();
		echo $command;
		die();
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

		if(!empty($input['print'])) {

			if(Session::has('query')) {
				$pdf = PDF::loadView('report.inventory_print', ['data'=> Session::get('query'), 'month' => $month, 'year' => $year]);
			}
			else {
				$pdf = PDF::loadView('report.inventory_print', ['data'=> $data, 'month' => $month, 'year' => $year]);
			}

			// $pdf = PDF::loadView('report.inventory_print', ['data'=> $data, 'month' => $month, 'year' => $year]);

			$pdf->setPaper('a4', 'landscape');

			Session::put('query', $data);

			return $pdf->download('report.pdf');
			// return view::make('report.inventory_print')->with(['data'=> $data, 'month' => $month, 'year' => $year]);
		}
		else {
			Session::put('query', $data);
			return redirect()->back()->with(['data'=> $data, 'month' => $month, 'year' => $year])->withInput();
		}
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
		
		if(!empty($input['print'])) {
			$pdf = PDF::loadView('report.debt_print', ['data'=> $data, 'month' => $month, 'year' => $year]);
			$pdf->setPaper('a4', 'landscape');
			return $pdf->download('report.pdf');
		}
		else {
			return redirect()->back()->with(['data'=> $data, 'month' => $month, 'year' => $year])->withInput();
		}
	}
}
