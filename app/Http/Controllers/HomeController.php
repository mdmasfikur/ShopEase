<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class HomeController extends Controller
{
    // // Method to display the homepage with products
    public function index()
    {
        $categories = Category::all();
        $featuredProducts = Product::where('is_featured', 1)->paginate(3);
        $recentProducts = Product::latest()->take(6)->get();
        $hotProducts = Product::where('is_hot', true)->paginate(6);
        $popularProducts = Product::orderBy('views', 'desc')->paginate(6);

        return view('home', compact('categories', 'featuredProducts', 'recentProducts', 'hotProducts', 'popularProducts'));
    }

    public function shop()
    {
        $products = Product::paginate(10);

        return view('shop', compact('products'));
    }
    public function payment()
    {
        $total = 0;

        return view('payment.index', compact('total'));
    }
}
