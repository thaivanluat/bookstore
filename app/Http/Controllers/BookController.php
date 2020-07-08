<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class BookController extends Controller
{
    public function index() {
        $data = DB::table('DAUSACH')
                ->join('THELOAI', 'DAUSACH.MaTheLoai', '=', 'THELOAI.MaTheLoai')
                ->join('TACGIA', 'DAUSACH.MaTacGia', '=', 'TACGIA.MaTacGia')
                ->select('DAUSACH.*', 'TACGIA.*', 'THELOAI.*')
                ->orderBy('DAUSACH.MaDauSach', 'desc')->get();
        
        $authorOption = DB::table('TACGIA')->get();
        $categoryOption = DB::table('THELOAI')->get();

    	return View::make("book.index")->with(['data' => $data, 'category' => $categoryOption, 'author' => $authorOption]);
    }

    public function detail($id) {
        $data = DB::table('DAUSACH')
                ->join('SACH', 'DAUSACH.MaDauSach', '=', 'SACH.MaDauSach')
                ->join('THELOAI', 'THELOAI.MaTheLoai', '=', 'DAUSACH.MaTheLoai')
                ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'DAUSACH.MaTacGia')
                ->select('SACH.*', 'TACGIA.TenTacGia', 'THELOAI.TenTheLoai')
                ->where('DAUSACH.MaDauSach', $id)
                ->orderBy('SACH.MaSach', 'desc')->get();
        
        $bookName = DB::table('DAUSACH')->where('MaDauSach', $id)->value('TenDauSach');
    	return View::make("book.detail")->with(['data' => $data, 'name' => $bookName]);
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('DAUSACH')
                            ->where('MaDauSach', $input['id'])
                            ->update(['TenDauSach' => $input['name'], 
                                        'MaTheLoai' => $input['category'],
                                        'MaTacGia' => $input['author']]);
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
            $queryResult = DB::table('DAUSACH')->where('MaDauSach', '=', $input['id'])->delete();
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
        $insertId = $sequence->nextValue('S_MADAUSACH_ID');

        try {
            $queryResult = DB::table('DAUSACH')->insert([
                [
                    'MaDauSach' => $insertId, 
                    'TenDauSach' => $input['name'],
                    'MaTheLoai' => $input['category'],
                    'MaTacGia' => $input['author']
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
