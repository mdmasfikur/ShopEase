@extends('layouts.app.root')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <h3>My Wishlist</h3>
            @if($wishlist->isEmpty())
                <p>Your wishlist is empty. <a href="{{ route('index') }}">Browse products</a>.</p>
            @else
                <div class="row">
                    @foreach($wishlist as $item)
                        <div class="col-md-4 mb-4">
                            <div class="card">
                                <img src="{{ $item->product->image_url }}" class="card-img-top" alt="{{ $item->product->name }}">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $item->product->name }}</h5>
                                    <p class="card-text">${{ number_format($item->product->price, 2) }}</p>
                                    <form action="{{ route('wishlist.remove', $item->product) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn btn-danger">Remove</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
