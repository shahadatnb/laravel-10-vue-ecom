<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Auth\LoginController as DefaultLoginController;

class CustomerLoginController extends DefaultLoginController
{
    protected $redirectTo = 'customer';
    public function __construct()
    {
        $this->middleware('guest:customer')->except('logout');
    }
    public function showLoginForm()
    {
        return view('auth.customer.login');
    }
    public function username()
    {
        $login = request()->input('username');
        //return filter_var( $login, FILTER_VALIDATE_EMAIL ) ? 'email' : 'reg_no';
        return 'username';
    }

    protected function credentials(Request $request)
    {        
        if (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
        return ['email' => $request->get('username'), 'password'=>$request->get('password')];
        }
        return ['username' => $request->get('username'), 'password'=>$request->get('password')];
        //return ['mobile' => $request->get('username'), 'password'=>$request->get('password')];
    }

    protected function guard()
    {
        return Auth::guard('customer');
    }
}
