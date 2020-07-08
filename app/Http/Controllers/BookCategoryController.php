<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class BookCategoryController extends Controller
{
    public function index() {
    	$data = DB::table('THELOAI')->orderBy('MaTheLoai', 'desc')->get();
    	return View::make("bookcategory.index")->with(['data' => $data]);
    }

    public function detail($id) {
        $data = DB::table('DAUSACH')
                ->join('TACGIA', 'TACGIA.MaTacGia', '=', 'DAUSACH.MaTacGia')
                ->select('DAUSACH.*', 'TACGIA.*')
                ->where('DAUSACH.MaTheLoai', $id)
                ->orderBy('DAUSACH.MaDauSach', 'desc')->get();
        
        $categoryName = DB::table('THELOAI')->where('MaTheLoai', $id)->value('TenTheLoai');
    	return View::make("bookcategory.detail")->with(['data' => $data, 'name' => $categoryName]);
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('THELOAI')
                            ->where('MaTheLoai', $input['id'])
                            ->update(['TenTheLoai' => $input['name']]);

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
            $queryResult = DB::table('THELOAI')->where('MaTheLoai', '=', $input['id'])->delete();
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
        $insertId = $sequence->nextValue('S_MATHELOAI_ID');

        try {
            $queryResult = DB::table('THELOAI')->insert([
                [
                    'MaTheLoai' => $insertId, 
                    'TenTheLoai' => $input['name']
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
