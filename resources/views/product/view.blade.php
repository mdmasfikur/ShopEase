@extends('layouts.app.root')

@section('content')
<div class="container mt-5">
    <h1>Product Details</h1>

    <!-- Alerts -->
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- Product Image -->
                <div class="col-md-6">
                    @if($product->image_url)
                    <img src="{{ asset('storage/'.$product->image_url) }}" class="img-fluid rounded border"
                        alt="{{ $product->name }}">
                    @else
                    <img src="https://via.placeholder.com/640x480.png/004444?text={{rawurlencode($product->name)}}" class="img-fluid rounded border"
                        alt="{{ $product->name }}">
                    @endif
                </div>

                <!-- Product Information -->
                <div class="col-md-6">
                    <h2>{{ $product->name }}</h2>
                    <p><strong>Category:</strong> {{ $product->category ? $product->category->name : 'Uncategorized' }}
                    </p>
                    <p><strong>Price:</strong> ${{ number_format($product->price, 2) }}</p>
                    <p><strong>Views:</strong> {{ $product->views }}</p>
                    <p><strong>Description:</strong></p>
                    <p>{{ $product->description }}</p>
                    <div>
                        <a href="{{ route('checkout.index', ['product_id'=> $product->id]) }}"
                            class="btn btn-primary btn-sm">Buy Now</a>
                        <button class="btn btn-success btn-sm add-to-cart" data-id="{{ $product->id }}"
                            data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                            data-image="{{ $product->image_url }}">
                            Add to Cart
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">
            <a href="{{ route('index') }}" class="btn btn-secondary">Back to Products</a>
        </div>
    </div>
</div>
@endsection