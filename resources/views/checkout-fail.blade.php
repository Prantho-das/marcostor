@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <h2>Payment Failed!</h2>
    <p>Sorry, your transaction could not be completed.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go Back to Shop</a>
</div>
@endsection
