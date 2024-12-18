<div class="col-md-4 mb-3">
    <div class="card">
        <div class="d-flex">


            <img src="{{ $product->image_url ? asset('storage/'.$product->image_url) : 'https://via.placeholder.com/640x480.png/004444?text='.rawurlencode($product->name) }}"
                class="card-img-top border-bottom bg-light my-auto" alt="{{ $product->name }}"
                style="aspect-ratio:1.5/1;">
        </div>
        <div class="card-body">
            <h6 class="card-title">{{ $product->name }}</h6>
            <p class="card-text">${{ $product->price }}</p>
            <a href="{{ route('product.view', $product->id) }}" class="btn btn-primary btn-sm">Buy
                Now</a>
            <button class="btn btn-success btn-sm add-to-cart" data-id="{{ $product->id }}"
                data-name="{{ $product->name }}" data-price="{{ $product->price }}"
                data-image="{{ $product->image_url }}">
                Add to Cart
            </button>
        </div>
    </div>
</div>