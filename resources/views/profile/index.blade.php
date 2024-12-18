@extends('layouts.app.root')

@section('content')
<!-- Profile Section -->
<div class="container mt-5">
    <div class="row">
        <!-- User Information -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{$user->profile_picture ?? 'https://www.gravatar.com/avatar/'.$emailHash.'?d=identicon'}}" alt="User Avatar"
                        class="rounded-circle mb-3 border" style="width: 120px; height: 120px;">
                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                    <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                </div>
            </div>
        </div>

        <!-- Order History -->
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h5>Order History</h5>
                </div>
                <div class="card-body">
                    @if($orders->count() > 0)
                        <ul class="list-group">
                            @foreach($orders as $order)
                                <li class="list-group-item">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span>#{{ $order->id }} {{$order->product->name}} x{{$order->quantity}}</span>
                                        <span class="text-muted">{{ $order->created_at->format('d M Y h:m:s') }}</span>
                                    </div>
                                    <small class="text-muted">
                                        Total: ${{ number_format($order->total_price, 2) }}
                                    </small>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-muted">No orders found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
