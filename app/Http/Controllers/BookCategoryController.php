<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;

class BookCategoryController extends Controller
{
    public function index() {
    	$data = DB::select('select * from THELOAI');
    	return View::make("bookcategory.index")->with(['data' => $data]);
    }
}
