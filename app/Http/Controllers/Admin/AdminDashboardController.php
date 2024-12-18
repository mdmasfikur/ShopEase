<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Fetch all Stats

        $totalUsers = User::count();
        $totalSales = Product::sum('sales');
        $totalViews = Product::sum('views');

        // Example sales data (replace with actual database queries)
        $dailySales = [
            'labels' => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            'values' => [120, 150, 180, 250, 300, 200, 100],
        ];
        $monthlySales = [
            'labels' => ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            'values' => [500, 600, 750, 800, 900, 950, 1000, 1100, 1050, 1200, 1300, 1400],
        ];
        $yearlySales = [
            'labels' => ['2022', '2023', '2024'],
            'values' => [12000, 15000, 18000],
        ];

        // Pass data to the view
        return view('admin.dashboard', compact('totalUsers', 'totalSales', 'totalViews', 'dailySales', 'monthlySales', 'yearlySales'));
    }


    // User Management
    public function manageUsers()
    {
        $users = User::paginate(10);
        return view('admin.users.index', compact('users'));
    }
    public function addUser()
    {
        return view('admin.users.add');

    }

    public function storeUser(Request $request)
    {
        // Validate input data
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Please enter a valid email address!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters!',
            'password.confirmed' => 'Passwords do not match!',
        ]);

        // Create new user
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return back()->with(
                'success', 'User added successful!');
        } catch (\Exception $e) {
            \Log::error('Failed to Add user: ' . $e->getMessage()); // Log error for debugging
            return back()->with('error', 'Failed to add user. Please try again.')->withInput();
        }
    }
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('admin.users.edit', compact('user'));

    }

    public function updateUser(Request $request, $id)
    {
        // Validate input data
        $validated = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,  // Allow the current user's email
            'password' => 'nullable|string|min:8|confirmed',  // Password is optional for updates
            'is_admin' => 'required|boolean'
        ], [
            'name.required' => 'Name is required!',
            'email.required' => 'Email is required!',
            'email.email' => 'Please enter a valid email address!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters!',
            'password.confirmed' => 'Passwords do not match!',
        ]);

        // Find the user by ID
        $user = User::findOrFail($id);

        // Only hash the password if it's provided
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // If no password is provided, remove the password field from the update data
            unset($validated['password']);
        }
        // Update the user with validated data
        $user->update($validated);

        // Return success message
        return back()->with('success', 'User updated successfully!');

        // // Update user
        // try {

        // } catch (\Exception $e) {
        //     \Log::error('Failed to Update user: ' . $e->getMessage()); // Log error for debugging
        //     return back()->with('error', 'Failed to update user. Please try again.')->withInput();
        // }
    }

    // Category Management

    public function manageCategories()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    public function addCategory()
    {
        return view('admin.categories.add');
    }

    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Category added successfully!');
    }

    public function editCategory($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function updateCategory(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category = Category::findOrFail($id);
        $category->update($request->all());

        return redirect()->route('admin.dashboard')->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Category deleted successfully!');
    }

    // Product Management
    public function manageProducts()
    {
        $products = Product::with('category')->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    public function addProduct()
    {
        $categories = Category::all();
        return view('admin.products.add', compact('categories'));
    }

    public function storeProduct(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,jpg,png',
            'is_featured' => 'nullable|boolean',
            'is_hot' => 'nullable|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);


        if ($request->hasFile('image_url')) {
            $validated['image_url'] = $request->file('image_url')->store('uploads/products', 'public');
        }


        Product::create($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Product added successfully!');
    }

    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function updateProduct(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'image_url' => 'nullable|image|mimes:jpeg,jpg,png',
            'is_featured' => 'nullable|boolean',
            'is_hot' => 'nullable|boolean',
            'category_id' => 'required|exists:categories,id',
        ]);

        // Handle image upload
        if ($request->hasFile('image_url')) {
            // Delete the old image if it exists
            if ($product->image_url && Storage::exists('public/' . $product->image_url)) {
                Storage::delete('public/' . $product->image_url);
            }

            $validated['image_url'] = $request->file('image_url')->store('uploads/products', 'public');
        }

        $product->update($validated);

        return redirect()->route('admin.dashboard')->with('success', 'Product updated successfully!');
    }

    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Product deleted successfully!');
    }
}
