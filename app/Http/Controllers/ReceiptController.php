<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

class ReceiptController extends Controller
{
    public function index() {
    	return View::make("receipt.index");
    }
}
