<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class AuthorController extends Controller
{
    public function index() {
    	$data = DB::table('TACGIA')->orderBy('MaTacGia', 'desc')->get();
    	return View::make("author.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('DAUSACH')
                ->join('THELOAI', 'DAUSACH.MaTheLoai', '=', 'THELOAI.MaTheLoai')
                ->join('TACGIA', 'DAUSACH.MaTacGia', '=', 'TACGIA.MaTacGia')
                ->select('DAUSACH.MaDauSach','DAUSACH.TenDauSach', 'THELOAI.*')
                ->where('DAUSACH.MaTacGia', $id)
                ->orderBy('DAUSACH.MaDauSach', 'desc')->get();
        
        $authorName = DB::table('TACGIA')->where('MaTacGia', $id)->value('TenTacGia');
    	return View::make("author.detail")->with(['data' => $data, 'name' => $authorName]);
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('TACGIA')
                            ->where('MaTacGia', $input['id'])
                            ->update(['TenTacGia' => $input['name'], 'NamSinh' => $input['year']]);

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
            $queryResult = DB::table('TACGIA')->where('MaTacGia', '=', $input['id'])->delete();
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
        $insertId = $sequence->nextValue('S_MATACGIA_ID');

        try {
            $queryResult = DB::table('TACGIA')->insert([
                [
                    'MaTacGia' => $insertId, 
                    'TenTacGia' => $input['name'],
                    'NamSinh' => $input['year']
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
