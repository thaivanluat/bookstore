<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class HomeController extends Controller
{
    public function index() {
        // return View::make("home.index");
        
        // $data = DB::table('TACGIA')->orderBy('MaTacGia', 'desc')->get();
        // $yearRevenue = 
        // $monthRevenue = DB::table('TACGIA')->orderBy('MaTacGia', 'desc')->get();

        $query = DB::table('HOADON')
                        ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
                        ->selectRaw('sum(sotientra) as doanhthu')
                        ->whereRaw('EXTRACT(YEAR FROM ngaylap) = EXTRACT(YEAR FROM sysdate)')
                        ->get();
                        
        $annualRevenue = $query[0]->doanhthu ? $query[0]->doanhthu : 0;

        $query = DB::table('HOADON')
                        ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
                        ->selectRaw('sum(sotientra) as doanhthu')
                        ->whereRaw('EXTRACT(MONTH FROM ngaylap) =  EXTRACT(MONTH FROM sysdate)')
                        ->get();

        $monthlyRevenue = $query[0]->doanhthu ? $query[0]->doanhthu : 0;

        $query = DB::table('HOADON')
                        ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
                        ->selectRaw('sum(soluong) as soluong')
                        ->whereRaw('EXTRACT(MONTH FROM ngaylap) = EXTRACT(month FROM sysdate)')
                        ->get();
        
        $bookSoldQuantity = $query[0]->soluong ? $query[0]->soluong : 0;

        $query = DB::table('KHACHHANG')
                        ->selectRaw('count(makhachhang) as soluong')
                        ->get();

        $customerCount = $query[0]->soluong ? $query[0]->soluong : 0;   
        
        $monthRevenueArray = [0,0,0,0,0,0,0,0,0,0,0,0];

        $query = DB::table('HOADON')
                        ->selectRaw('EXTRACT(MONTH FROM ngaylap) as thang,
                                    SUM(sotientra) AS doanhthu')
                        ->whereRaw('EXTRACT(YEAR FROM ngaylap) = EXTRACT(year FROM sysdate)')
                        ->groupByRaw('EXTRACT(MONTH FROM ngaylap)')
                        ->orderBy('thang')
                        ->get();
        

        foreach($query as $item) {
             $monthRevenueArray[$item->thang-1] = $item->doanhthu;
        }
   
        $categoryofRevenue = [];

        $totalBookSold = DB::table('HOADON')
                    ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
                    ->selectRaw('sum(soluong) as soluong')
                    ->first()->soluong;
        

        $query = DB::table('HOADON')
                        ->join('CHITIETHOADON', 'HOADON.MaHoaDon', '=', 'CHITIETHOADON.MaHoaDon')
                        ->join('SACH', 'CHITIETHOADON.MaSach', '=', 'SACH.MaSach')
                        ->join('DAUSACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
                        ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
                        ->selectRaw('tentheloai,sum(soluong) as doanhthu')
                        ->groupByRaw('tentheloai')
                        ->orderBy('tentheloai', 'asc')
                        ->get();

        $i = 5;
        $temp = 0;
        foreach($query as $item) {
            if($i > 0) {
                $dt = $item->doanhthu;
                $percent = ($dt/$totalBookSold)*100;
                $categoryofRevenue[] = round($percent,0);
                $i--;
                $temp += $percent;
            }
            else {
                $categoryofRevenue[] = round(100 - $temp,0);
                break;
            }
        }      
        
        $debtCustomer = DB::table('KHACHHANG')
                        ->select('*')
                        ->whereRaw('hanno between sysdate - 7 and sysdate +7')
                        ->get();

        return View::make("home.index")->with([ 'annualRevenue' => $annualRevenue,
                                                'monthlyRevenue' => $monthlyRevenue,
                                                'bookSoldQuantity' => $bookSoldQuantity,
                                                'customerCount' => $customerCount,
                                                'monthRevenueArray' => $monthRevenueArray,
                                                'categoryofRevenue' => $categoryofRevenue,
                                                'debtCustomer' => $debtCustomer]);
    }
}
