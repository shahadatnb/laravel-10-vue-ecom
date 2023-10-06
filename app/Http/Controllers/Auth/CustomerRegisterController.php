<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Customer;

class CustomerRegisterController extends Controller
{
    public function showRegisterForm(){
        return view('auth.customer.register');
    }

    
    public function register(Request $request){
        $this->validate($request, array(
            'name'=>'required|max:50|regex:/^[\pL\s\-]+$/u',
            //'last_name'=>'required|max:191',
            //'username'=>'required|unique:customers',
            'email'=>'required|email|unique:customers',
            'phone'=>'required|regex:/^([0-9\-\+\(\)]*)$/|max:15',
            'password'=>'required|string|min:6|confirmed',
            'g-recaptcha-response' => 'required|captcha'
            ));

        $customer = new Customer;
        $customer->name = $request->name;
        //$customer->last_name = $request->last_name;
        $customer->username = $request->phone;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->password = Hash::make($request->password);
        $customer->save();

        //dd($customer);

        if (Auth::guard('customer')->attempt(['email'=>$request->email,'password'=>$request->password])) {
            // Authentication passed...
            return redirect()->route('customer./');
        }

        return redirect()->back();
    }
}
