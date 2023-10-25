<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;

class WishlistController extends Controller
{

    function addToWishList(Request $request)
    {
        $user = $request->user();
        $productId = $request->product_id;
        $wishlist = WishList::where('customer_id', $user->id)
            ->where('product_id', $productId)
            ->first();

        if (!$wishlist) {
            $wishlist = new WishList();
            $wishlist->customer_id = $user->id;
            $wishlist->product_id = $productId;
            $wishlist->save();
        }
        return response()->json([
            'message' => 'Product added to wishlist'
        ]);
    }

    function removeFromWishList(Request $request, $productId)
    {
        $user = $request->user();
        WishList::where('customer_id', $user->id)
            ->where('product_id', $productId)
            ->delete();
        return response()->json([
            'message' => 'Product removed from wishlist'
        ]);
    }

    function getWishList(Request $request)
    {
        $user = $request->user();
        $wishlist = $user->wishlist()->pluck('product_id')->toArray();
        return response()->json([
            'wishlist' => $wishlist
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }
}
