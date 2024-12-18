@extends('layouts.app.root')

@section('content')
<div class="container">
    <h1>{{ $category->name }}</h1>
    <p>{{ $category->description }}</p>

    <div class="row">
        @foreach ($products as $product)
        <x-product :product="$product"/>
        @endforeach
    </div>
    <x-pagination :paginator="$products"/>
</div>
@endsection
