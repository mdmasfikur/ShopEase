@extends('layouts.app.root')
@section('content')
<!-- Banner / Carousel -->
<div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        @foreach($featuredProducts as $index => $product)
        <div class="carousel-item w-100 {{ $index === 0 ? 'active' : '' }}"
            style='background: url("{{ $product->image_url ? asset('storage/'.$product->image_url) : "https://via.placeholder.com/640x480.png/004444?text=".rawurlencode($product->name) }}") center/cover no-repeat;'>
            <div class="carousel-caption d-block bg-dark bg-opacity-50">
                <h5>{{ $product->name }}</h5>
                <p>${{ $product->price }}</p>
                <a href="{{ route('product.view', $product->id) }}" class="btn btn-primary">View Product</a>
            </div>
        </div>
        @endforeach
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<div class="container">
    <div class="d-md-flex mt-4">
        <!-- Sidebar for Categories -->
        <aside class="col-md-3 me-lg-4">
            <h5 class="text-center">Categories</h5>
            <div class="list-group">
                @foreach($categories as $category)
                <a href="{{route('category.view',$category->id)}}"
                    class="list-group-item list-group-item-action">{{$category->name}}</a>
                @endforeach
                </ul>
        </aside>

        <!-- Main Content -->
        <section>
            <!-- Hot Products -->
            <div class="">
                <h5 class="text-center">🔥 Hot Products 🔥</h5>
                <div class="row">
                    @foreach($hotProducts as $product)
                    <x-product :product="$product" />
                    @endforeach
                </div>
                <div class="d-flex">
                    <a href="{{route('product.hot')}}" class="mx-auto border rounded text-decoration-none p-2 m-0">See
                        More</a>
                </div>
            </div>

            <hr />

            <!-- Popular Products -->
            <div class="">
                <h5 class="text-center"> Popular Products </h5>
                <div class="row">
                    @foreach($popularProducts as $product)
                    <x-product :product="$product" />
                    @endforeach
                </div>
                <div class="d-flex">
                    <a href="{{route('product.popular')}}"
                        class="mx-auto border rounded text-decoration-none p-2 m-0">See More</a>
                </div>
            </div>

            <hr />

            <!-- Recent Products -->
            <div class="">
                <h5 class="text-center">Recent Products</h5>
                <div class="row">
                    @foreach($recentProducts as $product)
                    <x-product :product="$product" />
                    @endforeach
                </div>
                <div class="d-flex">
                    <a href="{{route('product.latest')}}"
                        class="mx-auto border rounded text-decoration-none p-2 m-0">See More</a>
                </div>
            </div>

        </section>
    </div>
</div>
@endsection