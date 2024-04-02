<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\locTrait;
use App\Models\WishList;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use CustomHelper;
use App\Http\Requests\PlaceOrderRequest;
use App\Http\Requests\CheckoutRequest;

class CheckoutController extends Controller
{
    use locTrait;
    public function cart()
    {
        $body_class = 'it_serv_shopping_cart shopping-cart';
        return view('frontend.products.cart',compact('body_class'));
    }
  
    public function addToCart(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $qty = isset($request->quantity) ? $request->quantity : 1 ;
        
        $cart = session()->get('cart', []);
  
        if(isset($cart[$id])) {
            $cart[$id]['quantity']+=$qty;
        } else {
            $cart[$id] = [
                "name" => $product->title,
                "weight" => $product->weight,
                "quantity" => $qty,
                "price" => $product->price(),
                "amount" => $product->price() * $qty,
                "photo" => $product->photo,
                'free_shipping' => $product->free_shipping
            ];
        }
          
        session()->put('cart', $cart);
        //session()->flash('success', 'Cart updated successfully');
        if($request->ajax()) {
            return response()->json(['count'=> count(session()->get('cart')), 'success' => 'Product added to cart successfully!']);
        }else{
            return redirect()->route('checkout');
            //return redirect()->back()->with('success', 'Product added to cart successfully!');
        }        
    }
  
    public function cartUpdate(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            $cart[$request->id]["amount"] = $request->quantity * $cart[$request->id]["price"];
            session()->put('cart', $cart);

            $amount = array_reduce(session('cart'), function($carry, $item) {
                $carry += $item['amount'];
                return $carry;
            });

            return response()->json([
                'subtotal' => $amount,
            ]);
        }
    }
  
    public function remove(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            
            if(!empty(session('cart'))) {
                $amount = array_reduce(session('cart'), function($carry, $item) {
                    $carry += $item['amount'];
                    return $carry;
                });
            }else {
                $amount = 0;
            }
    
            return response()->json([
                'subtotal' => $amount,
            ]);
        }
    }

    public function shipingAmount(Request $request)
    {
        if(!empty($request->type)){
            return CustomHelper::shipingAmountAdmin($request->location_id);
        }
        $amount = CustomHelper::shipingAmount($request->location_id);
        session()->put('shipingAmount', $amount);
        return $amount;
    }


    public function checkout(CheckoutRequest $request)
    {
        $validated = $request->validated();
        $customer = auth()->user();
        $data = new Order;

        $data->name = $request->name;
        $data->address = $request->address;
        //$data->address2 = $request->address2;
        $data->state = $request->state;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->city = $request->city;
        //$data->state = $request->state;
        $data->country = $request->country;
        //$data->zip_code = $request->zip_code;            
        //$data->shipping_method = $request->shipping_method; //ShippingRole::find($request->shipping_method)->title;
        $data->sub_total = $request->totalPrice;
        $data->shipping_amount = 0; // $request->shipping_amount;
        $data->amount = $data->sub_total+$data->shipping_amount;
        $data->status_id = 1;
        //$data->payment_method = $request->payment_method;
        $data->customer_id = $customer->id;        
        $data->save();

        $customer->name = $request->name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;
        //$customer->address2 = $request->address2;
        //$customer->state = $request->state;
        $customer->city = $request->city;
        $customer->country = $request->country;
        //$customer->zip_code = $request->zip_code;
        $customer->save();

        foreach($request->products as $product){
            OrderItem::create(['order_id'=>$data->id,'product_id'=>$product['product_id'],'product_stock_id'=>$product['variant_id'],'qty_ordered'=>$product['quantity'],'price'=>$product['price'],'total'=>$product['price'] * $product['quantity']]);
            $productItem = Product::find($product['product_id']);
            $productItem->decrement('quantity',$product['quantity']); 
        }
        
        return response()->json([
            'success' => true, 'message' => 'Order placed successfully!', 'order' =>  $data,
        ]);

        /*
        $countries=$this->countryArray();
        $shipping_method = CustomHelper::shippingMmethod();
        $customer = auth('customer')->user();
        if($customer->country != ''){
            $states = $this->stateArray($customer->country);
        }else{
            $states = $this->stateArray(config('settings.defaultCountry','BD'));
        }
        
        return view('frontend.products.checkout',compact('countries','states','shipping_method'));
        */
    }

    public function checkoutPost(Request $request)
    {
        $this->validate($request, array(
            'amount'=>'required',
            'name'=>'required|max:50',
            'address'=>'required|max:255',
            'address2'=>'nullable|max:255',
            'state'=>'required|max:100',
            'payment_method'=>'required',
            'email'=>'required|email|max:100',
            'phone'=>'required|regex:/^([0-9\-\+\(\)]*)$/|max:15',
            ));


            if(count((array) session('cart')) == 0){
                return redirect()->back();
            }
            
            $customer = auth('customer')->user();
            $data = new Order;

            $sub_total = 0;
            foreach((array) session('cart') as $id => $details){
                $sub_total += $details['price'] * $details['quantity'];
            }

            $data->name = $request->name;
            $data->address = $request->address;
            $data->address2 = $request->address2;
            $data->state = $request->state;
            $data->email = $request->email;
            $data->phone = $request->phone;
            $data->city = $request->city;
            $data->state = $request->state;
            $data->country = $request->country;
            $data->zip_code = $request->zip_code;            
            //$data->shipping_method = $request->shipping_method; //ShippingRole::find($request->shipping_method)->title;
            $data->sub_total = $sub_total;
            $data->shipping_amount = $request->shipping_amount;//session()->get('shipingAmount');
            $data->amount = $sub_total+$request->shipping_amount; //session()->get('shipingAmount');//$request->amount;
            $data->status_id = 1;
            $data->payment_method = $request->payment_method;
            //if(auth('customer')->user()){
                $data->customer_id = $customer->id;
            //}            
            $data->save();

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

            foreach(session('cart') as $id => $details){
                OrderItem::create(['order_id'=>$data->id,'product_id'=>$id,'qty_ordered'=>$details['quantity'],'price'=>$details['price'],'total'=>$details['price'] * $details['quantity']]);
                $product = Product::find($id);
                $product->decrement('quantity',$details['quantity']); 
            }

            $assigned_user = CustomHelper::checkAssigned();
            if($assigned_user){
                $data->assigned_user = $assigned_user->id;
            }            
            $data->save();

            session()->forget('cart');

            if($request->payment_method == 'cash_on_delevery'){
                session()->put('order_id', $data->id);
                return redirect()->route('customer./');
            }elseif($request->payment_method == 'card'){
                return redirect()->route('pay.stripe',$data->id);
            }
            //return redirect()->route('pay.ssl',$data->id);

            
    }


    public function checkoutSuccess()
    {
        //session()->put('order_id', 10);
        if(session()->get('order_id')){
            $order = Order::findOrFail(session()->get('order_id'));
            $body_class = 'it_serv_shopping_cart shopping-cart';
            return view('frontend.products.thank_you',compact('body_class','order'));
        }
        return redirect()->route('/');
    }


    public function getStates(Request $request)
    {
        return response()->json($this->stateArray($request->country_code));
    }

    public function addToWishlist($id){
        $product = Product::findOrFail($id);
        $customer=auth('customer')->user();
        $wishlist = WishList::where('customer_id',$customer->id)->where('product_id',$product->id)->first();
        if(!$wishlist){
           WishList::create([
                'customer_id'=>$customer->id,
                'product_id'=>$product->id
            ]); 
        }
        
        return redirect()->route('wishlist');
    }

    public function placeOrderNonAuth(PlaceOrderRequest $request){//PlaceOrderRequest

            $validated = $request->validated();            

            $data = new Order;
            $data->name = $request->name;
            $data->address = $request->address;
            //$data->email = $request->email;
            $data->phone = $request->phone;
            $data->shipping_method = $request->shipping_method; //ShippingRole::find($request->shipping_method)->title;
            $data->sub_total = $request->totalPrice;
            $data->shipping_amount = $request->shippingCost;//session()->get('shipingAmount');
            $data->amount = $request->totalPrice+$request->shippingCost; //session()->get('shipingAmount');//$request->amount;
            $data->status_id = 1;          
            $data->save();
            //return $request->products[0]['price'];//cart[9]['product']['reduced_price'];
            foreach($request->products as $product){
                OrderItem::create(['order_id'=>$data->id,'product_id'=>$product['product_id'],'qty_ordered'=>$product['quantity'],'price'=>$product['price'],'total'=>$product['price'] * $product['quantity']]);
                $productItem = Product::find($product['product_id']);
                $productItem->decrement('quantity',$product['quantity']); 
            }
            
            return response()->json([
                'success' => true, 'message' => 'Order placed successfully!', 'order' =>  $data,
            ]);

    }
}
