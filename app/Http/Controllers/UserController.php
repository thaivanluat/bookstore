<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cookie;
use DB;
use Input;
use Session;

class UserController extends Controller
{
    public function getLogin(Request $request) {
        // Redirect the user into the dashboard right away if he already logged in
        if(Session::get('user')) {
            return redirect('/');
        }
        else {
            $data = array(
                'username' => '',
                'password' => '',
                'result' => ''
            );
            
            // Show remembered username and password
            if($request->cookie('remembered_user')) {
                $rememberedUser = unserialize($request->cookie('remembered_user')); 
                $data['username'] = $rememberedUser['username'];
                $data['password'] = $rememberedUser['password'];
            }

            return View::make("user.login")->with($data);
        }        
    }

    public function postLogin(Request $request) {
        $this->validate(
            $request, 
            ['username' => 'required',
            'password' => 'required'],
            ['username.required' => trans('user.required_username'),
            'password.required' => trans('user.required_password')]
        );

        $user = DB::table('NGUOIDUNG')
            ->where('tendangnhap',$request->input('username'))
            ->where('matkhau',md5($request->input('password')))
            ->first();
        
        if($user) {
            Session::put('user', $user);

            $remember = $request->input('remember_me');

            if(!empty($remember)) {
                // Save username and password into cookie
                $cookie = Cookie::forever('remembered_user',serialize(['username'=>$request->input('username'), 'password'=>$request->input('password')])); 
            }
            // Remove the remember cookie if user does not tick on the remember checkbox
            else {
                $cookie = Cookie::forget('remembered_user');
            }

            return redirect('/')->withCookie($cookie);
        }
        else {
            return redirect()->back()->with('message', trans('user.wrong_username_or_password'));
        }
    }

    public function logout() {
        Session::forget('user');
        return redirect('/user/login');
    }

    public function index() {
        $data = DB::table('NGUOIDUNG')
                ->where('manguoidung', '<>', 1)
                ->orderBy('manguoidung', 'desc')
                ->get();
    	return View::make("user.index")->with(['data' => $data]);
    }

    public function profile() {
        $user = Session::get('user');
        return View::make("user.profile")->with(['user' =>  $user]);

    }

    public function editProfile(Request $request) {
        $this->validate(
            $request, 
            ['name' => 'required',
            'birthday' => 'required',
            'phone' => 'required',
            'email' => 'required'],
            ['name.required' => trans('user.required_name'),
            'birthday.required' => trans('user.required_birthday'),
            'phone.required' => trans('user.required_phone'),
            'email.required' => trans('user.required_email')]
        );

        $user = Session::get('user');
        $userId = $user->manguoidung;

        try {
            $queryResult = DB::table('NGUOIDUNG')
                            ->where('MaNguoiDung', $user->manguoidung)
                            ->update([
                                'HoTen' => $request->input('name'),
                                'NgaySinh' => $request->input('birthday'),
                                'Dienthoai' => $request->input('phone'),
                                'Email' => $request->input('email')
                                ]);

        }
        catch (\Exception $e) {
            $queryResult = 0;
        }

        if($queryResult == 1) {
            $user = DB::table('NGUOIDUNG')->where('manguoidung',$userId)->first();
            Session::put('user', $user);
            return redirect()->back()->with('success-message', trans('user.edit_profile_successfully'));
        }
        else {
            return redirect()->back()->with('error-message', trans('user.error_occurred'));
        }
    }

    public function changePassword() {
        return View::make("user.change_password");
    }

    public function postChangePassword(Request $request) {
        $this->validate(
            $request, 
            ['password' => 'required',
            're-password' => 'required|same:password'],
            ['password.required' => trans('user.required_password'),
            're-password.required' => trans('user.required_re-password'),
            're-password.same' => trans('user.passwords_not_same')]
        );

        $user = Session::get('user');
        $userId = $user->manguoidung;

        try {
            $queryResult = DB::table('NGUOIDUNG')
                            ->where('MaNguoiDung', $user->manguoidung)
                            ->update([
                                'MatKhau' => md5($request->input('password'))
                                ]);

        }
        catch (\Exception $e) {
            $queryResult = 0;
        }

        if($queryResult == 1) {
            return redirect()->back()->with('success-message', trans('user.change_password_successfully'));
        }
        else {
            return redirect()->back()->with('error-message', trans('user.error_occurred'));
        }
    }

    public function edit(Request $request) {
        $input = $request->all();

        try {            
            $queryResult = DB::table('NGUOIDUNG')
                            ->where('MaNguoiDung', $input['id'])
                            ->update([
                                'ChucVu' => $input['type']
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
            $queryResult = DB::table('NGUOIDUNG')->where('MaNguoiDung', '=', $input['id'])->delete();
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
        $insertId = $sequence->nextValue('S_MANGUOIDUNG_ID');

        try {
            $validatedData = $request->validate([
                'email' => 'email'
            ]);

            $queryResult = DB::table('NGUOIDUNG')->insert([
                [
                    'MaNguoiDung' => $insertId,
                    'TenDangNhap' => $input['username'],
                    'HoTen' => $input['name'],
                    'DienThoai' => $input['phone'],
                    'NgaySinh' => $input['birthday'],
                    'MatKhau' => md5(1),
                    'NgayTao' => date('Y-m-d H:i:s'),
                    'Email' => $input['email'],
                    'ChucVu' => $input['type']
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
