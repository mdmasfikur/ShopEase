<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlist = auth()->user()->wishlist()->with('product')->get();
        return view('wishlist.index', compact('wishlist'));
    }

    public function add(Product $product)
    {
        $wishlist = Wishlist::firstOrCreate([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
        ]);

        return redirect()->route('wishlist.index')->with('success', 'Product added to wishlist.');
    }

    public function remove(Product $product)
    {
        Wishlist::where('user_id', auth()->id())
                ->where('product_id', $product->id)
                ->delete();

        return redirect()->route('wishlist.index')->with('success', 'Product removed from wishlist.');
    }
}
