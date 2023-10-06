<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProCat;
use App\Models\Order;
use App\Models\OrderItem;
use Storage;
use Str;
use Image;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::orderBy('id','desc')->paginate(25);
        return view('admin.products.index')->withProducts($products);
    }


    public function create()
    {
        $cats = ProCat::all();
        return view('admin.products.create',compact('cats'));
    }

    private function productSlug($slug){
        $slug = Str::slug($slug, '-');
        $count = Product::where('slug','like',$slug.'%')->count();
        $suffix = $count ? $count+1 : '';
        $slug .= $suffix;
        return $slug;
    }

    public function store(Request $request)
    {
        $this->validate($request, array(
            'title'=>'required|max:255',
            //'cat_id'=>'required'
            ));

        $slug = $this->productSlug($request->title);

        $data = new Product;
        $data->title = $request->title;
        $data->slug = $slug;
        $data->status = 0;
        $data->user_id = auth()->user()->id;
        $data->save();
        return redirect()->route('product.products.edit',$data->id);
    }

    public function show($id){}

    public function productInfo(Request $request){
        $product = Product::find($request->product_id);
        return \Response::make(['product'=>$product]);
    }

    public function productHide($id){
        $data = Product::find($id);
        if($data->status==0){
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        
        $data->save();
        return redirect()->back();
    }

    public function productDelevery()
    {
        $orders = Order::latest()->paginate(20);
        return view('admin.products.productDelevery')->withOrders($orders);
    }

    public function productDeleveryConfirm($id)
    {
        $order = Order::findOrFail($id);
            $order->confirm = 1;
            $order->save();

        return redirect()->route('productDelevery');
    }


    public function edit($id)
    {
        $product = Product::find($id);
        $cat = ProCat::all();
        $cats=array();
        foreach ($cat as $value) {
            $cats[$value->id] = $value->title;
        }
        return view('admin.products.edit',compact('product','cats'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'title'=>'required|max:255',
            'price'=>'numeric|required',
            'weight'=>'numeric|nullable',
            'categories'=>'required',
            'short_description'=>'nullable|max:500',
            'description'=>'required',
            'photo'=>'nullable|image:max:1024',
            ));

        $data = Product::find($id);
        $data->title = $request->title;
        $data->price = $request->price;
        $data->weight = $request->weight;
        $data->quantity = $request->quantity;
        $data->reduced_price = $request->reduced_price;
        $data->discount_percentage = $request->discount_percentage;
        $data->short_description = $request->short_description;
        $data->description = $request->description;
        $data->featured = $request->featured??0;
        $data->free_shipping = $request->free_shipping??0;
        $data->status = $request->status;
        $data->save();

        $data->categories()->sync($request->categories);

        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/'.$data->photo);
            $imgFile  = Image::make($request->photo)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg',80);
            $file_name = 'products/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);            
            //$filename = time().'.'.$image->extension();
            //$full_path = 'products/'.$filename;
            //$image->storeAs('public/products/', $filename);
            $data->update(['photo'=> $file_name]);
        }
        session()->flash('success','Product Successfully Save');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $item=Product::find($id);
        
        if($item){            
            $order = OrderItem::where('product_id',$id)->count();
            if($order>0){
                session()->flash('warning','Already Sales.');                    
            }else{
                // $old_image_path = public_path().'/upload/product/'.$item->photo;
                // if(file_exists($old_image_path)) {
                //   @unlink($old_image_path);
                Storage::delete('public/products/'.$item->photo);
                $item->delete();
                session()->flash('success','Removed'); 
            }         
            
        }else{
            session()->flash('warning','Not Found');
            }

        return redirect()->back();
    }

    public function product_gallery_store(Request $request){

        $this->validate($request, array(
            'image'=>'required|image|max:3072',
        ));

        $imgFile  = Image::make($request->image)->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg',80);
        $file_name = 'products/'.time() .'.jpg';
        Storage::disk('public')->put($file_name, $imgFile);
        $attachment = Attachment::create([
            'product_id'=>$request->product_id,
            'image'=>$file_name
        ]);

        return response()->json([
            'data'=>$attachment
        ]);
    }

    public function product_gallery_delete(Request $request){
        $data = Attachment::find($request->id);
        Storage::delete('public/'.$data->image);
        $data->delete();
        return response()->json('success');
    }
    
    public function productsCat(){
        $cats = ProCat::where('status',1)->get();
        return view('admin.products.category',compact('cats'));
    }

    private function catSlug($slug){
        $slug = Str::slug($slug, '-');
        $count = ProCat::where('slug','like',$slug.'%')->count();
        $suffix = $count ? $count+1 : '';
        $slug .= $suffix;
        return $slug;
    }
    
    public function catCreate(Request $request)
    {
        $this->validate($request, array(
            'title'=>'required|max:255',
            'photo'=>'nullable|image:max:1024',
            ));

        $slug = $this->productSlug($request->title);

        $data = new ProCat;
        $data->title = $request->title;
        $data->slug = $slug;
        $data->status = 1;
        $data->save();

        $image = $request->file('photo');
        if ($image) {
            $full_path = '';
            $filename = $data->id.'.'.$image->extension();
            $full_path = 'productCat/'.$filename;
            $image->storeAs('public/productCat/', $filename);
            $data->update(['photo'=> $full_path]);
        }

        session()->flash('success','Successfully Save');
        return redirect()->back();
    }

    public function catEdit($id)
    {
        $product = ProCat::find($id);
        return view('admin.products.catEdit',compact('product'));
    }

    public function catEditPost(Request $request, $id)
    {
        $this->validate($request, array(
            'title'=>'required|max:255|unique:pro_cats,title,'.$id,
            'slug'=>'required|max:100|unique:pro_cats,slug,'.$id,
            'photo'=>'nullable|image:max:1024',
            ));

        $data = ProCat::find($id);
        $data->title = $request->title;
        $data->save();

        $image = $request->file('photo');
        if ($image) {
            $full_path = '';
            $filename = $data->id.'.'.$image->extension();
            $full_path = 'productCat/'.$filename;
            $image->storeAs('public/productCat/', $filename);
            $data->update(['photo'=> $full_path]);
        }

        session()->flash('success','Successfully Save');
        return redirect()->back();
    }

    public function catHide($id){
        $data = ProCat::find($id);
        if($data->status==0){
            $data->status = 1;
        }else{
            $data->status = 0;
        }
        
        $data->save();
        return redirect()->back();
    }
}
