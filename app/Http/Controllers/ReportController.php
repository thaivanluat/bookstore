<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

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
}
