<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\mixTrait;
use Carbon\Carbon;
use App\Models\Setting;
use App\Models\Product;
use App\Models\Order;
use Storage;
use Session;
use Auth;
//use PDF;

class AdminController extends Controller
{    
    use mixTrait;

    public function dashboard()
    {
        $dashboard = array();
        $order = Order::whereDate('created_at',date('Y-m-d'))->get(); //->where('status_id',2)
        $order_this_mounth = Order::whereMonth('created_at',date('Y-m'))->get();
        //dd(date('Y-m'));
        //$product_count = Product::where('status',1)->count();
        return view('admin.pages.dashboard',compact('dashboard','order','order_this_mounth'));
    }


 




    public function settings()
    {
       $settings = Setting::where('category','basic')->where('status',1)->orderBy('sl','ASC')->get();
        return view('admin.pages.settings',compact('settings'));
    }


    public function saveSetting(Request $request, $id)
    {
        $data = Setting::findOrFail($id);
        if(isset($request->image)){
            $request->validate([
                'value' => 'required|mimes:jpg,jpeg,png|max:2048',
            ]);
            Storage::delete('public/'.$data->value);
            $fileName = time().'.'.$request->value->extension();  
            $upload_path = public_path('upload/site_file');
            $request->value->move($upload_path, $fileName);
            $data->value = $fileName;
            $data->save();
        }else{
            $data->value = $request->value;
            $data->save();
        }
        
        \Artisan::call('config:cache');
        Session::flash('success','Setting Seved');
        return redirect()->back();
    }
}


