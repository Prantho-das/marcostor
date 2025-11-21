@extends('layouts.app')

@section('title', 'Super Deals')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
        <h4 class="fw-bold text-uppercase mb-3 mb-md-0">
            <span class="text-danger">Super</span> Deals
        </h4>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">← Back to Home</a>
    </div>

    <!-- Products Grid -->
    <div id="super-deals-container" class="row g-3">
        @include('partials.super-deals-items', ['products' => $products])
    </div>

    <!-- Load More Button -->
    @if($products->count() >= 24)
    <div class="text-center mt-4">
        <button id="load-more-super-deals" class="btn btn-danger px-4 py-2">Load More Products</button>
    </div>
    @endif
</div>

<!-- AJAX Load More -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    let skip = {{ count($products) }};
    const button = document.getElementById('load-more-super-deals');
    const container = document.getElementById('super-deals-container');

    if(button) {
        button.addEventListener('click', function() {
            button.innerText = 'Loading...';
            button.disabled = true;

            fetch(`{{ route('super.deals.loadMore') }}?skip=${skip}`)
                .then(res => res.json())
                .then(data => {
                    if(data.count > 0){
                        container.insertAdjacentHTML('beforeend', data.html);
                        skip += data.count;
                        button.innerText = 'Load More Products';
                        button.disabled = false;
                    } else {
                        button.innerText = 'No More Products';
                        button.classList.add('disabled');
                    }
                })
                .catch(() => {
                    button.innerText = 'Error, Try Again';
                    button.disabled = false;
                });
        });
    }
});
</script>

<!-- Custom Styles -->
<style>
/* Product Card */
.product-card {
    background: #fff;
    border: 1px solid #e2e2e2;
    border-radius: 10px;
    padding: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    height: 100%;
    display: flex;
    flex-direction: column;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.08);
}

/* Product Image */
.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 6px;
}

/* Product Name */
.product-card h6 {
    font-size: 0.95rem;
    font-weight: 600;
    color: #333;
    margin-top: 10px;
    min-height: 45px;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

/* Product Price */
.product-card p {
    font-size: 0.9rem;
    margin-top: 5px;
}

/* Strike-through for old price */
.product-card .text-muted {
    margin-right: 5px;
}

/* Load More Button */
#load-more-super-deals {
    min-width: 180px;
    font-weight: 600;
}

/* Responsive tweaks */
@media (max-width: 768px) {
    .product-card img {
        height: 150px;
    }
    .product-card h6 {
        min-height: 40px;
        font-size: 0.9rem;
    }
}

@media (max-width: 576px) {
    .product-card img {
        height: 130px;
    }
    #load-more-super-deals {
        width: 100%;
    }
}
</style>
@endsection
