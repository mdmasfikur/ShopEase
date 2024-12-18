<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        $orders = Order::where('user_id', auth()->id())->with('product')->get();
        return view('profile.orders', compact('orders'));
    }
}
