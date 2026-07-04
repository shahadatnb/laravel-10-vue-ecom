<?php

namespace App\Http\Controllers;

use App\Models\Attachment;
use Illuminate\Http\Request;
use App\Models\ProCat;
use Storage;
use Str;

class CategoryController extends Controller
{
    
    public function index(){
        $cats = ProCat::all();
        return view('admin.category.index',compact('cats'));
    }

    private function catSlug($slug){
        $slug = Str::slug($slug, '-');
        $count = ProCat::where('slug','like',$slug.'%')->count();
        $suffix = $count ? $count+1 : '';
        $slug .= $suffix;
        return $slug;
    }
    
    public function store(Request $request)
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

    public function edit($id)
    {
        $product = ProCat::find($id);
        return view('admin.category.edit',compact('product'));
    }

    public function update(Request $request, $id)
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

    public function destroy($id)
    {
        $item=ProCat::find($id);
        if($item->products->count() > 0){
            session()->flash('warning','Already Product.');
            return redirect()->back();
        }
        if($item){
            Storage::delete('public/'.$item->photo);
            $item->delete();
            session()->flash('success','Removed'); 
        }else{
            session()->flash('warning','Not Found');
        }
        return redirect()->back();
    }
}
