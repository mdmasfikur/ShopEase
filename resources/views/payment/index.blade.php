@extends('layouts.app.root')

@section('content')
<div class="container mt-5">
    <h3 class="text-center">Fake Payment Gateway</h3>
    <p class="text-center">Enter your payment details to complete the purchase.</p>

    <form action="{{ route('payment') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="card_number" class="form-label">Card Number</label>
            <input type="text" name="card_number" id="card_number" class="form-control" placeholder="1234 5678 9012 3456" required>
        </div>
        <div class="mb-3">
            <label for="card_holder" class="form-label">Card Holder Name</label>
            <input type="text" name="card_holder" id="card_holder" class="form-control" placeholder="John Doe" required>
        </div>
        <div class="mb-3">
            <label for="expiry_date" class="form-label">Expiry Date (MM/YY)</label>
            <input type="text" name="expiry_date" id="expiry_date" class="form-control" placeholder="12/24" required>
        </div>
        <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" name="cvv" id="cvv" class="form-control" placeholder="123" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Pay ${{ $total }}</button>
    </form>
</div>
@endsection
