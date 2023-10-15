<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\CustomerController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('users', UserController::class)->except(['edit', 'create', 'store', 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin']);
Route::post('users', [UserController::class, 'store']);
Route::put('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::post('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::patch('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::get('me', [UserController::class, 'me'])->middleware('auth:sanctum');
Route::post('login', [CustomerController::class, 'login']);

Route::get( '/posts', [FrontendController::class, 'getPosts'] );
Route::get( '/menu', [FrontendController::class, 'menuApi'] );
Route::get( '/config', [FrontendController::class, 'getConfig'] );

Route::post(
    '/orders',
    [OrderController::class, 'createOrder']
)->middleware('auth:sanctum');

Route::get(
    '/orders',
    [OrderController::class, 'getUserOrders']
)->middleware('auth:sanctum');

Route::get(
    '/orders/{id}',
    [OrderController::class, 'getOrderDetails']
)->middleware('auth:sanctum');

Route::post(
    '/wishlist',
    [WishlistController::class, 'addToWishList']
)->middleware('auth:sanctum');

Route::get(
    '/wishlist',
    [WishlistController::class, 'getWishList']
)->middleware('auth:sanctum');

Route::delete(
    '/wishlist/{product_id}',
    [WishlistController::class, 'removeFromWishList']
)->middleware('auth:sanctum');


Route::get('/latest-products', [FrontendController::class, 'latestProducts']);
Route::get('/single-product/{slug}', [FrontendController::class, 'getProduct']);

Route::get('/categories', [FrontendController::class, 'getCategories']);
