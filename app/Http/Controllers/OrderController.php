<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Traits\locTrait;
use App\Models\ShippingRole;
use App\Models\Customer;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\Mail;
use App\Mail\CustomerRegister;
use Session;
use CustomHelper;
use Auth;

class OrderController extends Controller
{
    use locTrait;

    public function index(Request $request)
    {
        $data['startDate']= '';//date("Y-m-d");
        $data['endDate']= '';//date("Y-m-d");
        $data['paginate']= 100;
        $user=auth()->user();

        $allOrder = Order::all();

        if($user->hasAnyRole(['Manager','Admin','SuperAdmin'])){
            $orders = Order::latest();
        }else{
            $orders = Order::where('assigned_user',$user->id)->latest();
        }
        
        if(!empty($request->paginate)){
            $data['paginate']= $request->paginate;
        }
        if(!empty($request->startDate) && !empty($request->endDate)){
            $orders = $orders->whereBetween('created_at',[$request->startDate.' 00:00:00',$request->endDate.' 23:59:59']);
            $data['startDate'] = $request->startDate;
            $data['endDate'] = $request->endDate;
        }

        if(!empty($request->is_return)){
            $orders = $orders->where('is_returned',1)->where('status_id','!=',9);
        }

        if(!empty($request->assigned_user)){
            $orders = $orders->where('assigned_user',$request->assigned_user);
            $data['assigned_user']= $request->assigned_user;
        }

        if(!empty($request->status)){
            $orders = $orders->where('status_id',$request->status);
            $data['status']= $request->status;
        }

        if(!empty($request->shipping_method)){
            $orders = $orders->where('shipping_method',$request->shipping_method);
            $data['shipping_method']= $request->shipping_method;
        }

        if(!empty($request->id)){
            $orders = $orders->where('id',$request->id);
            $data['id']= $request->id;
        }

        $orders = $orders->paginate($data['paginate']);

        $users = User::pluck('name','id')->toArray();
        $shipping_methods = ShippingRole::pluck('title','id')->toArray();
        //$is_returned_count = Order::where('is_returned',1)->where('status_id','!=',9)->count();
        
        return view('admin.order.index',compact('orders','data','users','shipping_methods','allOrder'));
    }

    
    public function create()
    {
        //$shipping_methods = ShippingRole::pluck('title','id')->toArray();
        $countries=$this->countryArray();
        $states = $this->stateArray(config('settings.defaultCountry','BD'));
        $products = Product::where('status',1)->pluck('title','id')->toArray();
        return view('admin.order.edit', compact('products','countries','states'));
    }

    public function store(Request $request, Order $order)
    {
        $this->validate($request, array(
            'name'=>'required|string',
            'phone'=>'required',
            'address'=>'required',
            'sub_total'=>'nullable|numeric',
            'discount_amount'=>'numeric|nullable',
            'shipping_amount'=>'numeric|nullable',
            'state'=>'required',
        ));

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->sub_total = $request->sub_total;
        $order->discount_amount = $request->discount_amount;
        $order->country = $request->country;
        $order->state = $request->state;
        $order->shipping_amount = $request->shipping_amount;
        $order->amount = $request->amount;
        $order->status_id = $request->status_id;
        $order->note = $request->note;
        $order->assigned_user = auth()->user()->id;
        $order->save();

        session()->flash('success','Successfully Update');
        return redirect()->route('order.edit',$order->id);
    }

    public function invoice(Request $request)
    {
        $this->validate($request, array(
            'order'=>'required',
        ));

        $orders=Order::whereIn('id',$request->order)->get();
        //dd($orders); exit;
        if(!empty($request->status)){
            if($orders){
                if($request->status == 'invoice'){
                    Order::whereIn('id',$request->order)->update(['status_id'=>5]);
                    return view('admin.order.invoices', compact('orders'));
                }elseif($request->status == 'pDelete'){
                    if(auth()->user()->hasAnyRole(['Admin','SuperAdmin'])){
                        $orders = Order::whereIn('id',$request->order)->whereHas('status',function($q){
                            $q->where('name','Delete');
                        })->get();
                        foreach($orders as $order){
                            $order->delete(); 
                        }
                    }
                }else{
                    //$orders->update(['status',$request->status]);
                    Order::whereIn('id',$request->order)->update(['status_id'=>$request->status,'updated_by'=>auth()->user()->id]);
                }
            }
        }elseif(!empty($request->assigned_user)){
            Order::whereIn('id',$request->order)->update(['assigned_user'=>$request->assigned_user]);
        }
        
        return redirect()->back();
    }

    public function show(Order $order)
    {
        return view('admin.order.show', compact('order'));
    }

    public function edit(Order $order)
    {
        //$shipping_methods = ShippingRole::pluck('title','id')->toArray();
        $countries=$this->countryArray();
        $states = $this->stateArray(config('settings.defaultCountry','BD'));
        $products = Product::where('status',1)->pluck('title','id')->toArray();
        return view('admin.order.edit', compact('order','products','states','countries'));
    }

    public function itemAdd(Request $request){        
        $product = Product::find($request->product_id);
        $item = new OrderItem;
        $item->order_id = $request->order_id;
        $item->product_id = $product->id;
        $item->product_id = $product->id;
        $item->qty_ordered = $request->qty;
        $item->price = ($product->reduced_price > 0)?$product->reduced_price:$product->price;
        $item->total = $request->qty*$item->price;
        $item->save();

        $order = Order::find($item->order_id);
        $shipping_amount = CustomHelper::shipingAmountAdmin($order->state);
        $order->sub_total = $order->items->sum('total');
        $order->shipping_amount = $shipping_amount;
        $order->amount = $order->items->sum('total') + $shipping_amount;
        $order->save();
        return \Response::make(['product'=>$product]);
    }
      
    public function itemRemove($id)
    {
        $item = OrderItem::find($id);
        $order_id = $item->order_id;
        $item->delete();
        $order = Order::find($order_id);
        $shipping_amount = CustomHelper::shipingAmountAdmin($order->state);
        //dd($shipping_amount); exit;
        $order->shipping_amount = $shipping_amount;
        $order->sub_total = $order->items->sum('total');
        $order->amount = $order->items->sum('total') + $shipping_amount;
        $order->save();
        session()->flash('success','Successfully remove');
        return redirect()->back();
    }

    public function update(Request $request, Order $order)
    {
        $this->validate($request, array(
            'name'=>'required|string',
            'phone'=>'required',
            'address'=>'required',
            'sub_total'=>'required|numeric',
            'discount_amount'=>'numeric|nullable',
            'shipping_amount'=>'numeric|nullable',
        ));

        $order->name = $request->name;
        $order->phone = $request->phone;
        $order->address = $request->address;
        $order->sub_total = $request->sub_total;
        $order->discount_amount = $request->discount_amount;
        $order->country = $request->country;
        $order->state = $request->state;
        $order->shipping_amount = $request->shipping_amount;
        $order->amount = $request->amount;
        $order->status_id = $request->status_id;
        $order->note = $request->note;
        $order->updated_by = auth()->user()->id;
        $order->save();

        session()->flash('success','Successfully Update');
        return redirect()->route('order.index');
    }

    public function qtyUpdate(Request $request)
    { //return $request->all();
        $item = OrderItem::find($request->id);
        $item->qty_ordered = $request->quantity;
        $item->total = $request->quantity * $item->price;
        $item->save();
        $order = Order::find($item->order_id);

        return \Response::make(['subtotal'=>$order->items->sum('total'),'item_total'=>$item->total]);
    }

    public function orderConfirm($id)
    {
        $order = Order::findOrFail($id);
            $order->confirm = 1;
            $order->save();

        return redirect()->route('orderList');
    }

    public function returnRequested(){
        
    }

    public function orderCancel(Request $request){
        $this->validate($request, array(
            'order_id'=>'required',
            'returned_note'=>'required|string',
        ));

        $order = Order::findOrFail($request->order_id);
        $order->is_returned = 1;
        $order->returned_date = date('Y-m-d H:i:s');
        $order->returned_note = $request->returned_note;
        $order->save();

        session()->flash('success','Successfully return');
        return redirect()->back();
    }
    
    function getUserOrders(){
        $user = auth()->user();
        $orders = $user->orders()->with('items')->get();
        $orders->map(function($order){
            $order->items->map(function($product){
                unset($product->description);
                unset($product->category);
                unset($product->image);
                unset($product->rating);
                unset($product->rating_count);
                // unset($product->created_at);
                // unset($product->updated_at);
                //unset($product->pivot->order_id);
                //unset($product->pivot->product_id);
                return $product;
            });
        });
        return $orders;
    }

    function getOrderDetails($id, Request $request){
        $order = Order::findOrFail($id);
        $order->items->map(function($product){
            unset($product->description);
            unset($product->category);
            unset($product->image);
            unset($product->rating);
            unset($product->rating_count);
            // unset($product->created_at);
            // unset($product->updated_at);
            unset($product->pivot->order_id);
            unset($product->pivot->product_id);
            return $product;
        });
        return $order;
    }

}
