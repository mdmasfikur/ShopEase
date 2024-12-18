@extends('layouts.app.root')

@section('content')
<div class="container">
    <h1 class="text-center py-2">Popular Products</h1>
    <div class="row">
        @foreach ($products as $product)
        <x-product :product="$product" />
        @endforeach
    </div>
    <x-pagination :paginator="$products" />
</div>
@endsection