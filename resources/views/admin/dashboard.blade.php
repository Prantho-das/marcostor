@extends('layouts.admin.master')

@section('title', 'Admin Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="row g-4">
    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center hover-scale">
            <div class="text-primary mb-2"><i class="bi bi-box fs-1"></i></div>
            <h6 class="fw-semibold text-muted">Products</h6>
            <h4 class="fw-bold mt-1">120</h4>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center hover-scale">
            <div class="text-success mb-2"><i class="bi bi-cart4 fs-1"></i></div>
            <h6 class="fw-semibold text-muted">Orders</h6>
            <h4 class="fw-bold mt-1">80</h4>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center hover-scale">
            <div class="text-warning mb-2"><i class="bi bi-people fs-1"></i></div>
            <h6 class="fw-semibold text-muted">Customers</h6>
            <h4 class="fw-bold mt-1">45</h4>
        </div>
    </div>

    <div class="col-md-3 col-6">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center hover-scale">
            <div class="text-danger mb-2"><i class="bi bi-cash-stack fs-1"></i></div>
            <h6 class="fw-semibold text-muted">Revenue</h6>
            <h4 class="fw-bold mt-1">৳1,20,000</h4>
        </div>
    </div>
</div>

<style>
    .hover-scale {
        transition: all 0.2s ease-in-out;
    }
    .hover-scale:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1);
    }
</style>
@endsection
