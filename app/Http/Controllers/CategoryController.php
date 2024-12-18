<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function view($id)
    {
        // Retrieve the category and its products
        $category = Category::with('products')->findOrFail($id);
        $products = $category->products()->paginate(10);

        return view('category.view', compact('category','products'));
    }
}
