<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Auth;
use Illuminate\Http\Request;
use Session;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $id = $request->get('product_id');

        if (! $id) {
            // Fetch cart data from session
            $cart = session('cart_items', []); // Example: storing cart data in session
            $productIds = collect($cart)->pluck('id')->unique();
            $products = Product::findMany($productIds);
            $cart_items = collect($cart)->map(function ($cartItem) use ($products) {
                // Find the product by id and add it to the cart item
                $cartItem['product'] = $products->firstWhere('id', $cartItem['id']);
                return $cartItem;
            });
        } else {
            $cart = [['id' => $id, 'quantity' => 1]];
            $product = Product::findOrFail($id);
            $cart_items = [
                ['id' => $id, 'quantity' => 1, 'product' => $product]
            ];
        }

        $user = Auth::user();

        return view('checkout.index', compact('user','cart_items'));
    }

    public function updateCart(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'cart' => 'array', // Ensure cart is an array
            'cart.*.id' => 'required|integer', // Each item must have an id
            'cart.*.quantity' => 'required|integer|min:1', // Each item must have a quantity
        ]);

        // Store In Session
        session(['cart_items' => $validatedData['cart']]);

        return response()->json([
            'message' => 'Cart saved successfully.',
            'cart' => $validatedData['cart'],
        ], 200);
    }
    public function process(Request $request)
    {
        // Validate billing information
        $request->validate([
            'address' => 'required|string',
        ]);

        // Check if the cart exists in session
        $cart = Session::get('cart_items');
        if (! $cart || count($cart) === 0) {
            return redirect()->back()->with('error', 'Your cart is empty!');
        }

        // Start placing orders
        $orders = [];
        $userId = Auth::id(); // Get the currently logged-in user's ID
        $totalOrderPrice = 0;

        foreach ($cart as $item) {
            $product = Product::findOrFail($item['id']);
            $productId = $item['id'];
            $quantity = $item['quantity'];
            $price = $product->price; // Ensure price is included in the cart

            $totalPrice = $price * $quantity;
            $totalOrderPrice += $totalPrice;

            $orders[] = [
                'user_id' => $userId,
                'product_id' => $productId,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // Insert orders in bulk for efficiency
        Order::insert($orders);

        // Clear the cart
        //Session::forget('cart');

        // Return success response
        return redirect()->route('checkout.success')->with('success', 'Your order has been placed successfully!');
    }

    public function success()
    {
        return view('checkout.success');
    }
}
