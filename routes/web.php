<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TaxonomyController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\MenuController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/ac_config', function()
{
    \Artisan::call('view:clear');
    \Artisan::call('config:cache');
    return 'OK';
});

Route::get('/', function () {
    return view('welcome');
})->name('/');

Route::group(['middleware'=>'auth'], function(){ 
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');   
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::get('/editProfile', [ProfileController::class, 'editProfile'])->name('editProfile');
    Route::post('/updateProfile', [ProfileController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/changePass', [ProfileController::class, 'changePass'])->name('changePass');
    Route::post('/changePass', [ProfileController::class, 'chengePassword'])->name('changePass');
    Route::put('/changePhoto', [ProfileController::class, 'changePhoto'])->name('changePhoto');

});

Route::group(['middleware' => ['auth','roles'],'roles'=>['Manager','Admin','SuperAdmin','Salesman']], function(){
    Route::get('/invoice', [OrderController::class, 'invoice'])->name('invoice');   
    Route::post('/qtyUpdate', [OrderController::class, 'qtyUpdate'])->name('order.qty.update');   
    Route::get('/itemRemove/{id}', [OrderController::class, 'itemRemove'])->name('order.itemRemove');   
    Route::post('/itemAdd', [OrderController::class, 'itemAdd'])->name('order.itemAdd');
    Route::get('/productInfo', [ProductController::class, 'productInfo'])->name('productInfo');
    Route::resource('order', OrderController::class);

    Route::resource('customers',CustomerController::class);
    //Route::get('/admin/productDelevery', 'ProductController@productDelevery')->name('productDelevery');
    //Route::get('/admin/productDeleveryConfirm/{id}', 'ProductController@productDeleveryConfirm')->name('productDeleveryConfirm');
});


Route::prefix('/product')->as('product.')->group(function() {
	Route::group(['middleware' => ['auth','roles'],'roles'=>['Manager','Admin','SuperAdmin']], function(){
		Route::resource('orderStatus', OrderStatusController::class);
		Route::resource('products', ProductController::class);
		Route::post('/gallery.store', [ProductController::class, 'product_gallery_store'])->name('gallery.store');
		Route::post('/gallery.delete', [ProductController::class, 'product_gallery_delete'])->name('gallery.delete');
		Route::get('/productHide/{id}', [ProductController::class, 'productHide'])->name('productHide');
        
		Route::get('/productsCat', [ProductController::class, 'productsCat'])->name('productsCat');
		Route::post('/catCreate', [ProductController::class, 'catCreate'])->name('catCreate');
		Route::get('/catHide/{id}', [ProductController::class, 'catHide'])->name('catHide');
		Route::get('/catEdit/{id}', [ProductController::class, 'catEdit'])->name('cat.edit');
		Route::post('/catEdit/{id}', [ProductController::class, 'catEditPost'])->name('cat.edit');

		//Route::get('/admin/productDelevery', 'ProductController@productDelevery')->name('productDelevery');
		//Route::get('/admin/productDeleveryConfirm/{id}', 'ProductController@productDeleveryConfirm')->name('productDeleveryConfirm');
	});
});



Route::group(['middleware'=> ['auth','roles'],'roles'=>['Admin','SuperAdmin']], function(){
    
    Route::get('ac_config', function()
    {
        $exitCode = Artisan::call('config:cache');
        return 'OK';
    });
    
		Route::resource('shippingRole',ShippingRoleController::class);

    // User Role ###################
    Route::post('admin-assign', [ RoleController::class, 'postAssignRole'])->name('admin-assign');
    Route::get('userRole', [ RoleController::class, 'getAdminPage'])->name('userRole');
    Route::get('fourceLogin/{id}', [ ProfileController::class, 'fourceLogin'])->name('fourceLogin');

    Route::resource('roles', ProfileController::class);

    // Setting  #####################
	Route::post('/chengePasswordFource', [ProfileController::class,'chengePasswordFource'])->name('chengePasswordFource');

    Route::get('/basic-settings', [AdminController::class,'settings'])->name('settings');
    Route::put('/saveSetting/{id}', [AdminController::class,'saveSetting'])->name('saveSetting');
    
    Route::resource('menus',MenuController::class);
    Route::post('/menuItemStore', [MenuController::class, 'menuItemStore'])->name('menuItem.store');
    Route::post('/menuItemUpdate/{id}', [MenuController::class, 'menuItemUpdate'])->name('menuItem.update');
    Route::get('/menuItemEdit/{id}', [MenuController::class,'menuItemEdit'])->name('menuItem.edit');
    Route::get('/menuItemDelete/{id}', [MenuController::class,'menuItemDelete'])->name('menuItem.delete');

    Route::resource('posts',PostController::class);
    Route::get('PostDelete/{id}',[PostController::class,'PostDelete'])->name('PostDelete');
    Route::get('postOrder',[PostController::class,'postOrder'])->name('postOrder');

    Route::resource('taxonomy',TaxonomyController::class);
	Route::get('taxonomy/hide{id}',[TaxonomyController::class,'hide'])->name('taxonomy.hide');
    Route::get('/ac_config_store', function()
    {
        \Artisan::call('storage:link');
        return 'OK';
    });
});


// SSLCOMMERZ Start
Route::get('/example1', [SslCommerzPaymentController::class, 'exampleEasyCheckout']);
Route::get('/example2', [SslCommerzPaymentController::class, 'exampleHostedCheckout']);

//Route::post('/pay', [SslCommerzPaymentController::class, 'index']);
Route::get('/pay/{id}', [SslCommerzPaymentController::class, 'index'])->name('pay.ssl');
Route::post('/pay-via-ajax', [SslCommerzPaymentController::class, 'payViaAjax']);

Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);

Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END

/*
Route::namespace('Auth')->group(function() {
    Route::get('login', 'CustomerLoginController@showLoginForm')->name('customer.login');
    Route::post('login', 'CustomerLoginController@login')->name('customer.login');
    Route::get('register', 'CustomerRegisterController@showRegisterForm')->name('customer.register');
    Route::post('register', 'CustomerRegisterController@register')->name('customer.register');
    Route::post('logout', 'LoginController@logout')->name('logout');

    //Customer Password Reset routes 
    Route::post('/password/email','CustomerForgotPasswordController@sendResetLinkEmail')->name('customer.password.email');
    Route::post('/password/reset', 'CustomerResetPasswordController@reset')->name('customer.password.update');
    Route::get('/password/reset', 'CustomerForgotPasswordController@showLinkRequestForm')->name('customer.password.request');                                     
    Route::get('/password/reset/{token}', 'CustomerResetPasswordController@showResetForm')->name('customer.password.reset');
});
*/
/*
Route::get('/', 'FrontendController@index')->name('/');
Route::get('/search', 'FrontendController@search')->name('search');

Route::get('cart', [CheckoutController::class, 'cart'])->name('cart');
Route::get('add-to-cart/{id}', [CheckoutController::class, 'addToCart'])->name('add.to.cart');
Route::patch('update-cart', [CheckoutController::class, 'cartUpdate'])->name('update.cart');
Route::delete('remove-from-cart', [CheckoutController::class, 'remove'])->name('remove.from.cart');
Route::get('shipingAmount', [CheckoutController::class, 'shipingAmount'])->name('shipingAmount');

Route::get('/home', function(){ return redirect()->route('dashboard'); });

Route::get('/blog', 'FrontendController@blog')->name('blog');
Route::get('/shop', 'FrontendController@shop')->name('shop');
Route::get('/page/{slug}', 'FrontendController@page')->name('page');
Route::get('/post/{slug}', 'FrontendController@page')->name('page');
Route::get('/404', 'FrontendController@index')->name('404');\
Route::get('/p/{posttype}', 'FrontendController@postType')->name('postType');
Route::get('/photogallery', 'FrontendController@photogallery')->name('photogallery');
//Route::get('/category/{slug}', 'FrontendController@category')->name('category');
Route::get('/category/{slug}', 'FrontendController@productCategory')->name('product.category');
Route::get('/product/{product_slug}', 'FrontendController@singleProduct')->name('product');

Route::group(['middleware' => ['auth:customer']], function () {
    Route::get('checkout', [CheckoutController::class, 'checkout'])->name('checkout');
    Route::post('checkoutPost', [CheckoutController::class, 'checkoutPost'])->name('checkoutPost');
    Route::post('orderCancel', [OrderController::class, 'orderCancel'])->name('orderCancel');
    Route::get('checkoutSuccess', [CheckoutController::class, 'checkoutSuccess'])->name('checkoutSuccess');
    Route::get('location/getStates', [CheckoutController::class, 'getStates'])->name('getStates');

    Route::get('/stripe/pay/{id}', [StripePaymentController::class, 'stripe'])->name('pay.stripe');
    Route::post('stripe', [StripePaymentController::class, 'stripePost'])->name('stripe.post');

    Route::get('profile', [CustomerController::class, 'profile'])->name('customer.profile');
    Route::get('editProfile', [CustomerController::class, 'editProfile'])->name('customer.editProfile');
    Route::post('updateProfile', [CustomerController::class, 'updateProfile'])->name('customer.updateProfile');
    Route::post('changePassword', [CustomerController::class, 'changePassword'])->name('customer.changePassword');
    
    Route::get('wishlist', [CustomerController::class, 'wishlist'])->name('wishlist');
    Route::get('add-to-wishlist/{id}', [CheckoutController::class, 'addToWishlist'])->name('add.to.wishlist');
    Route::delete('remove-from-wishlist', [CheckoutController::class, 'removeWishlist'])->name('remove.from.wishlist');
});
*/

require __DIR__.'/auth.php';
