<?php

namespace App\Http\Controllers;

use App\Models\ProductStock;
use App\Models\Attachment;
use App\Models\Product;
use Illuminate\Http\Request;
use Storage;
use Str;
use Image;

class StockController extends Controller
{

    public function index(Request $request)
    {
        $data = ['searchTerm' => $request->searchTerm];
        $productStocks = ProductStock::with('product', 'color', 'size');
        if ($request->searchTerm) {
            $productStocks = $productStocks->whereHas('product', function($q) use ($request) {
                $q->where('title', 'like', '%'.$request->searchTerm.'%');
            });
        }
        $productStocks = $productStocks->orderBy('product_id','desc')->orderBy('color_id')->orderBy('size_id')->paginate(50);
        return view('admin.products.variant.index', compact('productStocks', 'data'));
    }

    public function galleryStore(Request $request)
    {
        $this->validate($request, array(
            'product_id'=>'required',
            'color_id'=>'required',
            'image'=>'required|image|max:3072',
        ));

        $imgFile  = Image::make($request->image)->resize(500, 500, function ($constraint) {
            $constraint->aspectRatio();
        })->encode('jpg',80);
        $file_name = 'products/'.time() .'.jpg';
        Storage::disk('public')->put($file_name, $imgFile);
        $attachment = Attachment::create([
            'product_id'=>$request->product_id,
            'color_id'=>$request->color_id,
            'image'=>$file_name
        ]);

        return response()->json([
            'data'=>$attachment
        ]);
    }

    public function galleryDelete(Request $request)
    {
        $data = Attachment::find($request->id);
        Storage::delete('public/'.$data->image);
        $data->delete();
        return response()->json('success');
    }

    public function stockUpdate(Request $request)
    {
        $this->validate($request, array(
            'quantity'=>'numeric|required',
            'id'=>'required',
        ));

        $productStock = ProductStock::find($request->id);
        $productStock->quantity = $productStock->quantity + $request->quantity;
        $productStock->save();
        return response()->json([
            'success' => true,'quantity' => $productStock->quantity,'message' => 'Product stock added successfully.'
        ]);
    }

    public function edit(ProductStock $productStock)
    {
        return view('admin.products.variant.edit', compact('productStock'));
    }


    public function update(Request $request, ProductStock $productStock)
    {
        $productStock->price = $request->price;
        $productStock->reduced_price = $request->reduced_price;
        $productStock->quantity = $request->quantity;
        $productStock->save();

        session()->flash('success', "Updated.");
        return redirect()->back();
    }

    public function destroy(ProductStock $productStock)
    {
        $productStock->delete();
        session()->flash('success', "Removed.");
        return redirect()->back();
    }
}
