<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    
    // Method to display individual product details
    public function view($id)
    {
        $product = Product::findOrFail($id); // Fetch the product by ID
        $product->increment('views');
        return view('product.view', compact('product'));
    }

    public function latest()
    {
        $products = Product::latest()->paginate(10);
        return view('product.latest', compact('products'));
    }

    public function popular()
    {
        $products = Product::latest()->paginate(10);
        return view('product.popular', compact('products'));
    }
    public function hot()
    {
        $products = Product::latest()->paginate(10);
        return view('product.hot', compact('products'));
    }
}
