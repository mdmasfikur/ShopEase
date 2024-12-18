@extends('layouts.app.root')

@section('content')
<div class="container">
    <h3 class="mt-5">Checkout</h3>
    @if(count($cart_items) > 0)
    <div class="row">
        <!-- Cart Details -->
        <div class="col-md-8">
            <h5>Items in Your Cart</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total = 0;
                    @endphp
                    @foreach($cart_items as $item)
                    <tr>
                        <td><img src="{{ $item['product']['image_url'] ? asset('storage/'.$item['product']['image_url']) : 'https://via.placeholder.com/640x480.png/004444?text='.rawurlencode($item['product']['name'])  }}" width="50" alt="{{ $item['product']['name'] }}"></td>
                        <td>{{ $item['product']['name'] }}</td>
                        <td>${{ $item['product']['price'] }}</td>
                        <td>{{ $item['quantity'] }}</td>
                        <td>${{ $item['product']['price'] * $item['quantity'] }}</td>
                    </tr>
                    @php
                        $total += $item['product']['price'] * $item['quantity'];
                    @endphp
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Billing Information -->
        <div class="col-md-4">
            <h5>Billing Information</h5>
            <form action="{{ route('checkout.process') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" disabled value="{{ Auth::user()->name }}">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" disabled value="{{ Auth::user()->email }}">
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Shipping Address</label>
                    <textarea class="form-control" id="address" name="address" required></textarea>
                </div>
                <h5>Total: ${{ $total }}</h5>
                <button type="submit" class="btn btn-primary">Proceed to Payment</button>
            </form>
        </div>
    </div>
    @else
    <div class="alert alert-warning mt-3">Your cart is empty.</div>
    @endif
</div>
@endsection
