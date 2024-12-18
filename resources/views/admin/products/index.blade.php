@extends('layouts.admin')
@section('content')

<!-- Products Section -->
<div class="container mt-3">
    <div class="d-flex">
        <h2 class="flex-fill">Manage Products</h2>
        <a href="{{ route('admin.products.add') }}" class="btn btn-primary mb-3">Add Product</a>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Views</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>{{ $product->id }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category ? $product->category->name : 'Uncategorized' }}</td>
                <td>${{ $product->price }}</td>
                <td>{{ $product->views }}</td>
                <td>
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.products.delete', $product->id) }}" method="POST"
                        style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <div>
        <x-pagination :paginator="$products" />
    </div>
</div>
@endsection