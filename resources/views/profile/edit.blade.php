@extends('layouts.app.root')

@section('content')
<!-- Profile Section -->
<div class="container mt-5">
    <div class="row">
        <div class="col-lg-4">
            <!-- User Information Card -->
            <div class="card">
                <div class="card-body text-center">
                    <img src="{{$user->profile_picture ?? 'https://www.gravatar.com/avatar/'.$emailHash.'?d=identicon'}}" alt="User Avatar" class="rounded-circle mb-3"
                        style="width: 120px; height: 120px;">
                    <h5 class="card-title">{{ Auth::user()->name }}</h5>
                    <p class="card-text text-muted">{{ Auth::user()->email }}</p>
                    <a href="{{route('profile.index')}}" class="btn btn-primary">View Profile</a>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <!-- Account Details -->
            <div class="card">
                <div class="card-header">
                    <h5>Account Details</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('profile.update') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ Auth::user()->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                value="{{ Auth::user()->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="password" name="password">
                            <small class="text-muted">Leave blank if you don't want to change the password.</small>
                        </div>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection