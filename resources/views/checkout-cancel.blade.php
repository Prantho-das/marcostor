@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2>Payment Cancelled</h2>
    <p>Your transaction was cancelled. You can try again or continue shopping.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go Back to Shop</a>
</div>
@endsection
