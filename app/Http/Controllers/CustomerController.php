<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\WishList;
use App\Models\Product;
use App\Http\Traits\locTrait;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Auth\CustomerRegisterRequest;
use App\Http\Requests\Auth\CustomerLoginRequest;

class CustomerController extends Controller
{  use locTrait;

    public function index(){
        $customers = Customer::latest()->paginate(100);
        return view('admin.customer.index',compact('customers'));
    }

    public function show(Customer $customer){
        return view('admin.customer.show',compact('customer'));
    }

    public function orders(){
        $orders = Order::where('customer_id',auth('customer')->user()->id)->latest()->paginate(20);
        return view('frontend.account.index',compact('orders'));
    }
        
    public function wishlist(){
        $wishlist = WishList::where('customer_id',auth('customer')->user()->id)->pluck('product_id')->toArray();
        $products = Product::whereIn('id', $wishlist)->paginate(32);
        return view('frontend.products.shop',compact('products'));
    }

    public function profile(){
        $customer = auth('customer')->user();
        return view('frontend.account.profile',compact('customer'));
    }

    public function editProfile(){
        $customer = auth('customer')->user();
        $countries=$this->countryArray();
        if($customer->country != ''){
            $states = $this->stateArray($customer->country);
        }else{
            $states = $this->stateArray(config('settings.defaultCountry','BD'));
        }
        return view('frontend.account.profile-edit',compact('customer','countries','states'));
    }

    public function updateProfile(Request $request){
        $this->validate($request, [
            'name'=>'required|max:50',
            'address'=>'required|max:255',
            'address2'=>'nullable|max:255',
            'state'=>'required|max:100',
            'country'=>'required|max:100',
            'email'=>'required|email|max:100',
            'phone'=>'required|regex:/^([0-9\-\+\(\)]*)$/|max:15',
        ]);

        $customer = auth('customer')->user();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->address2 = $request->address2;
        $customer->state = $request->state;
        $customer->city = $request->city;
        $customer->country = $request->country;
        $customer->zip_code = $request->zip_code;
        $customer->save();

        session()->flash('success','Profile Updated Successfully');
        return redirect()->back();
    }

    public function changePassword(){
        $this->validate(request(), [
            'old_password' => 'required',
            'password' => 'required|confirmed|min:6|max:16',
        ]);

        $customer = auth('customer')->user();
        if(Hash::check(request('old_password'), $customer->password)){
            $customer->password = bcrypt(request('password'));
            $customer->save();
            session()->flash('success','Password Changed Successfully');
            return redirect()->back();
        }else{
            session()->flash('error','Old Password Does Not Match');
            return redirect()->back();
        }
    }

    public function destroy(Customer $customer){
        if($customer->orders->count() > 0){
            session()->flash('warning','Customer Can Not Be Deleted Because It Has Orders');
            return redirect()->back();
        }
        $customer->delete();
        session()->flash('success','Customer Deleted Successfully');
        return redirect()->back();
    }

    public function registerApi(CustomerRegisterRequest $request){
        $validated = $request->validated();

        $customer = Customer::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if($customer){
            return response(['error' => 0],  200);
        }else{
            return response(['error' => 1],  200);
        }
    }

    public function login(CustomerLoginRequest $request) {
        $validated = $request->validated();
        $customer = Customer::where('email', $request->email)->first();
        if (! $customer || ! Hash::check($request->password, $customer->password)) {
            return response(['error' => 1, 'message' => 'invalid credentials'], 401);
        }
        $customer->tokens()->delete();

        //$roles = $customer->roles->pluck('slug')->all();

        $plainTextToken = $customer->createToken('authToken')->plainTextToken;

        return response(['error' => 0, 'token' => $plainTextToken, 'user'=>$customer],  200);
    }

    public function updateProfileApi(Request $request){
        $customer = $request->user();
        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->date_of_birth = $request->date_of_birth;
        $customer->save();        
        return response(['error' => 0, 'user'=>$customer],  200);
    }

    public function getProfile(Request $request){
        $customer = $request->user();
        return response(['error' => 0, 'user'=>$customer],  200);        
    }
}
