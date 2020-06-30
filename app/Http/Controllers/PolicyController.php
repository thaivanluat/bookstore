<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use DB;
use Session;

class PolicyController extends Controller
{
    public function index() {
        $data = DB::table('THAMSO')->first();
    	return View::make("policy.index")->with(['data' => $data]);
    }

    public function edit(Request $request) {
        $this->validate(
            $request, 
            ['min_input_value' => 'required|min:0|integer',
            'max_stock_before_input_value' => 'required|min:0|integer',
            'max_debt_value' => 'required|min:0|integer',
            'min_stock_after_sold_value' => 'required|min:0|integer',
            'ratio_of_selling_price' => 'required|min:0|integer|not_in:0',
            'total_value_to_become_vip' => 'required|min:0|integer|not_in:0',
            'ratio_of_discount_price' => 'required|min:0|max:100|integer',
            'expired_debt_days' => 'required|min:0|integer',
            'book_give_away_id' => 'required|min:0|integer|not_in:0'
            ],
            ['required' => trans('policy.required_information'),
            'min' => trans('policy.min_greater_than_zero'),
            'integer' => trans('policy.value_is_integer'),
            'not_in' => trans('policy.ratio_is_not_zero'),
            'max' => trans('policy.discount_ratio_is_not_hundred'),]
        );

        $isAllowed = is_null($request->input('allow_exceed_debt')) ? 0 : 1;

        try {
            $queryResult = DB::table('THAMSO')
                            ->update([
                                'SoLuongNhapToiThieu' => $request->input('min_input_value'),
                                'SoLuongTonDeNhapToiDa' => $request->input('max_stock_before_input_value'),
                                'TongNoToiDa' => $request->input('max_debt_value'),
                                'LuongTonSauKhiBanToiThieu' => $request->input('min_stock_after_sold_value'),
                                'TiLeTinhDonGiaBan' => $request->input('ratio_of_selling_price'),
                                'ChoPhepVuotTongNo' => $isAllowed,
                                'muc_tien_capnhat_vip' => $request->input('total_value_to_become_vip'),
                                'TiLeGiamGia' => $request->input('ratio_of_discount_price'),
                                'HanNo' => $request->input('expired_debt_days'),
                                'MaSachTang' => $request->input('book_give_away_id')
                                ]);

        }
        catch (\Exception $e) {
            $queryResult = 0;
        }

        if($queryResult == 1) {
            return redirect()->back()->with('success-message', trans('policy.edit_policy_successfully'));
        }
        else {
            return redirect()->back()->with('error-message', trans('policy.error_occurred'));
        }
    }
}
