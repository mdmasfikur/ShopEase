@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Add New Product</h1>

    <!-- Alerts -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" id="price" name="price" step="0.01" class="form-control" value="{{ old('price') }}" required>
        </div>
        <div class="mb-3">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-select" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
        </div>
        <div class="mb-3">
            <label for="image_url" class="form-label">Product Image</label>
            <input type="file" id="image_url" name="image_url" class="form-control" accept="image/*">
        </div>
        <div class="form-check mb-3">
            <!-- Hidden input to send false value if unchecked -->
            <input type="hidden" name="is_featured" value="0">
            <input type="checkbox" id="is_featured" name="is_featured" class="form-check-input" value="1" {{ old('is_featured') ? 'checked' : '' }}>
            <label for="is_featured" class="form-check-label">Featured</label>
        </div>
        <div class="form-check mb-3">
            <!-- Hidden input to send false value if unchecked -->
            <input type="hidden" name="is_hot" value="0">
            <input type="checkbox" id="is_hot" name="is_hot" class="form-check-input" value="1" {{ old('is_hot') ? 'checked' : '' }}>
            <label for="is_hot" class="form-check-label">Mark as Hot</label>
        </div>
        <button type="submit" class="btn btn-primary">Add Product</button>
    </form>
</div>
@endsection
