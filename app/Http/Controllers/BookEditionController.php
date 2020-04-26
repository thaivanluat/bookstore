<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class BookEditionController extends Controller
{
    public function add(Request $request) {
        $input = $request->all();

        $sequence = DB::getSequence();
        $insertId = $sequence->nextValue('S_MASACH_ID');

        try {
            $queryResult = DB::table('SACH')->insert([
                [
                    'MaSach' => $insertId, 
                    'MaDauSach' => $input['book_id'],
                    'NhaXuatBan' => $input['publisher'],
                    'NamXuatBan' => $input['publishing_year'],
                    'SoLuongTon' => 0,
                    'DonGiaBan' => 0
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

    public function delete(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('SACH')->where('MaSach', '=', $input['id'])->delete();
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

    public function edit(Request $request) {
        $input = $request->all();

        try {
            $queryResult = DB::table('SACH')
                            ->where('MaSach', $input['id'])
                            ->update(['NhaXuatBan' => $input['publisher'], 'NamXuatBan' => $input['publishing_year']]);

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
