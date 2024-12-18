<?php

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WishlistController;
use Illuminate\Support\Facades\Route;

// Index Route
Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');

// Registration Route
Route::get('/register', [CustomAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [CustomAuthController::class, 'register']);
// Login Route
Route::get('/login', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [CustomAuthController::class, 'login']);
// Logout Route
Route::get('/logout', [CustomAuthController::class, 'logout'])->name('logout');


// Product Routes

Route::prefix('product')->name('product.')->group(function () {
    Route::get('/view/{id}', [ProductController::class, 'view'])->name('view');

    Route::get('/latest', [ProductController::class, 'latest'])->name('latest');
    Route::get('/popular', [ProductController::class, 'popular'])->name('popular');
    Route::get('/hot', [ProductController::class, 'hot'])->name('hot');


});


// Category Routes
Route::prefix('categories')->name('category.')->group(function () {
    Route::get('/{id}', [CategoryController::class, 'view'])->name('view');
});
// Authenticated Routes
Route::middleware(['auth'])->group(function () {
    // Profile Routes
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');
        Route::get('/update', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update', [ProfileController::class, 'update'])->name('update');
        Route::get('/orders', [OrderController::class, 'orders'])->name('orders');
    });

    // Checkout Routes
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
        Route::post('/process', [CheckoutController::class, 'process'])->name('process');
        Route::get('/success', [CheckoutController::class, 'success'])->name('success');
    });

    // Wishlist Routes
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        Route::get('/', [WishlistController::class, 'index'])->name('index');
        Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
        Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    });

    // Admin Routes
    Route::middleware('is_admin')->group(function(){
        Route::prefix('admin')->name('admin.')->group(function () {
            Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
            // User Management
            Route::prefix('users')->name('users.')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'manageUsers'])->name('index');
                Route::get('/add', [AdminDashboardController::class, 'addUser'])->name('add');
                Route::post('/add', [AdminDashboardController::class, 'storeUser'])->name('store');
                Route::get('/edit/{id}', [AdminDashboardController::class, 'editUser'])->name('edit');
                Route::post('/edit/{id}', [AdminDashboardController::class, 'updateUser'])->name('update');
                Route::delete('/delete/{id}', [AdminDashboardController::class, 'deleteUser'])->name('delete');
            });
    
            // Category Management
            Route::prefix('categories')->name('categories.')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'manageCategories'])->name('index');
                Route::get('/add', [AdminDashboardController::class, 'addCategory'])->name('add');
                Route::post('/add', [AdminDashboardController::class, 'storeCategory'])->name('store');
                Route::get('/edit/{id}', [AdminDashboardController::class, 'editCategory'])->name('edit');
                Route::put('/edit/{id}', [AdminDashboardController::class, 'updateCategory'])->name('update');
                Route::delete('/delete/{id}', [AdminDashboardController::class, 'deleteCategory'])->name('delete');
            });
    
            // Product Management
            Route::prefix('products')->name('products.')->group(function () {
                Route::get('/', [AdminDashboardController::class, 'manageProducts'])->name('index');
                Route::get('/add', [AdminDashboardController::class, 'addProduct'])->name('add');
                Route::post('/add', [AdminDashboardController::class, 'storeProduct'])->name('store');
                Route::get('/edit/{id}', [AdminDashboardController::class, 'editProduct'])->name('edit');
                Route::put('/edit/{id}', [AdminDashboardController::class, 'updateProduct'])->name('update');
                Route::delete('/delete/{id}', [AdminDashboardController::class, 'deleteProduct'])->name('delete');
            });
        });
    });
});
