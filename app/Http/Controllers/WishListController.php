<?php

namespace App\Http\Controllers;
use Cart;

use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function addProductToWishlist(Request $request)
    {
        Cart::instance("wishlist")->add($request->id, $request->name, 1, $request->price)->associate('App\Models\Product');
        return response()->json(['status' => 200, 'message' => 'Success! Item successfully added to your wishlist.']);
    }
}

