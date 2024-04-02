<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use App\Http\Traits\PostTrait;
use App\Models\Taxonomy;
use App\Models\Product;
use App\Models\ProCat;
use App\Models\Post;
use App\Models\Attachment;
use App\Models\MenuItem;
use App\Http\Resources\PostCollection;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\GalleryCollection;
use App\Http\Resources\CategoryCollection;
use App\Http\Resources\Category as CategoryResource;
use App\Facades\CustomHelperFacade as CustomHelper;

class FrontendController extends Controller
{
    use PostTrait;
	public function index()
    { 
        $products = Product::latest()->where('status',1)->paginate(8);
    	$homepage = Post::find(settingValue('homepage'));
    	$featureds = Product::latest()->where('status',1)->where('featured',1)->get()->take(8);
        /*
        $hot_deals =Product::latest()->whereHas('categories', function($q){
                $q->where('slug','hot-deal');
            })->take(16)->get();
*/
        $categories = ProCat::where('status',1)->get();

        return view('frontend.pages.index',compact('homepage','products','categories','featureds'));
    }

    public function shop(){
        $products = Product::latest()->where('status',1)->paginate(32);
        return view('frontend.products.shop',compact('products'));
    }

    public function search(Request $request){
        $search = $request->search;
        $products = Product::latest()->where('status',1)->where('title','like','%'.$search.'%')->paginate(18);
        return view("frontend.products.search",compact('products','search'));
    }

    public function singleProduct($product_slug){
        $product = $product_slug;
        $related_products = Product::inRandomOrder()->where('status',1)->get()->take(18);
        return view("frontend.products.single",compact('product','related_products'));
    }

    public function productCategory($slug){
        $cat = ProCat::where('slug',$slug)->first();
        if($cat){
            $products = Product::latest()->whereHas('categories', function($q) use($slug){
                $q->where('slug',$slug);
            })->paginate(36);
            return view("frontend.products.category",compact('cat','products'));
        }
        return $this->notFound();
    }
    
    public function page($slug){
        $page = Post::where('slug',$slug)->first();
        if($page){
            return View::first(["frontend.pages.single-{$page->post_type}", 'frontend.pages.single'],compact('page'));
        }

        return $this->notFound();
    }

    public function photogallery(){
        $datas = Taxonomy::where('post_type','photogallery')->orderBy('id','desc')->paginate(20);
        if($datas){
            return view('frontend.pages.photogallery',compact('datas'));
        }
    }

    public function blog(){
        $blogs = Post::where('post_type','post')->orderBy('id','desc')->paginate(20);
        if($blogs){
            return view('frontend.pages.blog',compact('blogs'));
        }
    }

   
    public function category($slug){
        $tax = Taxonomy::where('slug',$slug)->first();            
        if($tax){
            //$posts = Post::latest()->orderBy('id','desc')->orderBy('id','desc')->paginate(20);
            return View::first(["frontend.pages.category-{$tax->post_type}", 'frontend.pages.category'],compact('tax'));
        }
        return $this->notFound();
    }

    public function postType($postType){
        if($this->postTypeIs($postType)){
            $data = Post::where('post_type',$postType)->orderBy('id','desc')->paginate(20);
            if($data){
                return View::first(["frontend.pages.posttype-{$postType}", 'frontend.pages.posttype'],compact('data'));
            }
        }

        return $this->notFound();
    }

    public function menuApi(Request $request){
        $menu = MenuItem::whewHas('menu', function($q) use($request){
            $q->where('menu_id',$request->menu_id);
        })->with('subMenu')->withCount('subMenu')->where('parent_id',null)->orderBy('sl')->orderBy('sl','ASC')->get()->toArray();
        return response()->json($menu);
    }

    public function getConfig(){
        $config = CustomHelper::settings();
        return response()->json($config);
    }

    public function getWishlistedProduct(Request $request){
        $user = $request->user();
        $wishlists = $user->wishlist->pluck('product_id')->toArray();
        $products = Product::whereIn('id',$wishlists)->where('status',1)->get();
        return new ProductCollection($products);
    }

    public function latestProducts(Request $request){
        $products = Product::latest()->where('status',1);
        if($request->has('take')){
            $products = $products->take($request->take);
            if($request->has('skip')){
                $products = $products->skip($request->skip);
            }
        }else{
            //$products = $products->take(8);
        }

        if($request->has('search')){
            $products = $products->where('title','like','%'.$request->search.'%');
        }
        if($request->has('categories')){
            if($request->categories != ''){
                $myArray = explode(',', $request->categories);
                $products = $products->whereHas('categories', function($q) use($myArray){
                    $q->whereIn('category_id',$myArray);
                });
            }
        }
        if($request->has('colors')){
            if($request->colors != ''){
                $myArray = explode(',', $request->colors);
                $products = $products->whereHas('colors', function($q) use($myArray){
                    $q->whereIn('color_id',$myArray);
                });
            }
        }

        if($request->has('sizes')){
            if($request->sizes != ''){
                $myArray = explode(',', $request->sizes);
                $products = $products->whereHas('sizes', function($q) use($myArray){
                    $q->whereIn('size_id',$myArray);
                });
            }
        }

        if($request->has('featured')){
            $products = $products->where('featured',1);
        }

        $products = $products->paginate(24);
        //return response()->json($products);
        return new ProductCollection($products);
    }

    public function getProduct($slug){
        $product = Product::where('slug',$slug)->where('status',1)->with('galleries','colors','sizes','categories','variants')->first();
        if($product){
            //return response()->json($product);
            return new ProductResource($product);
        }else{
            return response()->json(['error'=>1]);
        }
    }

    public function getCategories(){
        $categories = ProCat::where('status',1)->whereNull('parent_id')->withCount('products')->get();
        return new CategoryCollection($categories);
        //return response()->json($categories);
    }
    
    public function notFound(){
        return view('frontend.pages.404');
    }

    public function getPosts(Request $request){

        $posts = Post::where('status',1)->with('postMeta');

        if($request->has('cat')){
            $posts->whereHas('taxonomy', function($q) use ($request){
                $q->where('slug', $request->cat);
            });
        }        
        
        $posts = $posts->where('post_type',$request->post_type);

        if($request->has('orderBy') && $request->has('orderType')){
            $posts = $posts->orderBy($request->orderBy,$request->orderType);
        }
        
        if($request->has('single')){
            $posts = $posts->first();
        }else{
            if($request->has('take')){
                $posts = $posts->take($request->take);
            }
            if($request->has('skip')){
                $posts = $posts->skip($request->skip);
            }
            $posts = $posts->get();
        }

        return new PostCollection($posts);

        //return response()->json($posts);
    }

    public function getProductVariantGallery($product_id,$color_id){
        $gallerys = Attachment::where('product_id',$product_id)->where('color_id',$color_id)->get();
        return new GalleryCollection($gallerys);
    }
}
