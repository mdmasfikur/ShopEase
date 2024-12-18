@extends('layouts.admin')

@section('content')
<div class="container mt-5">
    <h1>Add Category</h1>
    <form action="{{ route('index') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Category Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Add</button>
    </form>
</div>
@endsection
