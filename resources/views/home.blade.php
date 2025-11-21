@extends('layouts.app')

@section('title', 'Home')

@section('content')

<div class="pb-5">
         @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @include('pages.hero')

      @include('pages.shop-by-category', ['subCategories' => $subCategories])
    
    @include('pages.new-arrivals')

    @include('pages.super-deals')

    @include('pages.bag-collection')

    @include('pages.cover-cases')

    @include('pages.sound-devices')

    @include('pages.customer-reviews')
</div>
@endsection
