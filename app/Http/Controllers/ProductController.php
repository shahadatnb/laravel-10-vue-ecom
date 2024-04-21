<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProCat;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Size;
use App\Models\Color;
use App\Models\ProductStock;
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

        $product = new Product;
        $product->title = $request->title;
        $product->slug = $slug;
        $product->status = 0;
        $product->user_id = auth()->user()->id;
        $product->save();
        return redirect()->route('product.products.edit',$product->id);
    }

    public function show($id){}

    public function productInfo(Request $request){
        $product = Product::find($request->product_id);
        return \Response::make(['product'=>$product]);
    }

    public function productHide($id){
        $product = Product::find($id);
        if($product->status==0){
            $product->status = 1;
        }else{
            $product->status = 0;
        }
        
        $product->save();
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
        $sizes = Size::pluck('name','id');
        $colors = Color::pluck('name','id');
        $cats = ProCat::where('status',1)->pluck('title','id');
        $stocks = ProductStock::where('product_id',$id)->orderBy('color_id')->orderBy('size_id')->get();
        return view('admin.products.edit',compact('product','cats','sizes','colors','stocks'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, array(
            'title'=>'required|max:255',
            'sku'=>'nullable|max:80|unique:products,sku,'.$id,
            'product_type'=>'required',
            'colors'=>'required_if:product_type,==,variant',
            'sizes'=>'required_if:product_type,==,variant',
            'price'=>'numeric|required',
            'weight'=>'numeric|nullable',
            'categories'=>'required',
            'short_description'=>'nullable|max:500',
            'description'=>'required',
            'photo'=>'nullable|image:max:1024',
            ));

        $product = Product::find($id);
        $product->title = $request->title;
        $product->sku = $request->sku;
        $product->price = $request->price;
        $product->weight = $request->weight;
        $product->quantity = $request->quantity;
        $product->reduced_price = $request->reduced_price;
        $product->discount_percentage = $request->discount_percentage;
        $product->short_description = $request->short_description;
        if (!empty($request->description)){
            $description = $this->summernoteImage($request->description);
            $product->description=$description;
        }
        //$product->description = $request->description;
        $product->featured = $request->featured??0;
        $product->free_shipping = $request->free_shipping??0;
        $product->product_type = $request->product_type;
        $product->status = $request->status;
        $product->save();

        $product->categories()->sync($request->categories);
        if($product->product_type=='variant'){
            $product->sizes()->sync($request->sizes);
            $product->colors()->sync($request->colors);
            foreach($request->colors as $color){
                foreach($request->sizes as $size){
                  $stock =  ProductStock::firstOrCreate(['product_id'=>$product->id,'color_id'=>$color,'size_id'=>$size]);
                  if($stock->price == ''){
                    $stock->price = $request->price;
                    $stock->reduced_price = $request->reduced_price;
                    $stock->save();
                  }
                }
            }
        }else{
            $stock = ProductStock::firstOrCreate(['product_id'=>$product->id]);
            $stock->quantity = $request->quantity;
            $stock->price = $request->price;
            $stock->reduced_price = $request->reduced_price;
            $stock->save();
            $product->update(['variant_id'=> $stock->id]);
        }

        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/'.$product->photo);
            $imgFile  = Image::make($request->photo)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg',80);
            $file_name = 'products/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            //$filename = time().'.'.$image->extension();
            //$full_path = 'products/'.$filename;
            //$image->storeAs('public/products/', $filename);
            $product->update(['photo'=> $file_name]);
        }
        session()->flash('success','Product Successfully Save');
        return redirect()->back();
    }

    
    protected function summernoteImage($description){
        // $description = '<head><meta http-equiv=\"Content-Type\" 
        // content=\"text/html; charset=utf-8\">
        // </head><body>' . $description . '</body>';
        $dom = new \DomDocument();
        libxml_use_internal_errors(true);
        //$dom->loadHtml($description, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $dom->loadHtml(mb_convert_encoding($description, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        $images = $dom->getElementsByTagName('img');
        foreach($images as $k => $img){
            //dd(strpos($img->getAttribute('src'),'base64'));
            if(strpos($img->getAttribute('src'),'base64') != false) {
                $data = $img->getAttribute('src');
                list($type, $data) = explode(';', $data);
                list(, $data)      = explode(',', $data);
                $data = base64_decode($data);
                $filename = time().$k.'.png';
                Storage::put('public/post_file/'.$filename,$data);
                $img->removeAttribute('src');
                $img->setAttribute('src', asset('storage/post_file/'.$filename));
            }
        }
        return $description = $dom->saveHTML();
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

        $imgOriginal  = Image::make($request->image)->resize(1000, 1000, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg',100);
        $file_name = 'products/'.time() .'.jpg';
        $file_name_original = 'productsOriginal/'.time() .'.jpg';
        Storage::disk('public')->put($file_name, $imgFile);
        Storage::disk('public')->put($file_name_original, $imgOriginal);
        $attachment = Attachment::create([
            'product_id'=>$request->product_id,
            'image'=>$file_name,
            'imageOriginal'=>$file_name_original
        ]);

        return response()->json([
            'data'=>$attachment
        ]);
    }

    public function product_gallery_delete(Request $request){
        $product = Attachment::find($request->id);
        Storage::delete('public/'.$product->image);        
        Storage::delete('public/'.$product->imageOriginal);
        $product->delete();
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

        $category = new ProCat;
        $category->title = $request->title;
        $category->slug = $slug;
        $category->status = 1;
        $category->save();

        $image = $request->file('photo');
        if ($image) {
            $imgFile  = Image::make($request->photo)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg',80);
            $file_name = 'product_cat/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $category->update(['photo'=> $file_name]);
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

        $category = ProCat::find($id);
        $category->title = $request->title;
        $category->slug = $request->slug;
        $category->save();

        $image = $request->file('photo');
        if ($image) {
            Storage::delete('public/'.$category->photo);
            $imgFile  = Image::make($request->photo)->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
            })->encode('jpg',80);
            $file_name = 'product_cat/'.time() .'.jpg';
            Storage::disk('public')->put($file_name, $imgFile);
            $category->update(['photo'=> $file_name]);
        }

        session()->flash('success','Successfully Save');
        return redirect()->back();
    }

    public function catHide($id){
        $category = ProCat::find($id);
        if($category->status==0){
            $category->status = 1;
        }else{
            $category->status = 0;
        }
        
        $category->save();
        return redirect()->back();
    }
}
