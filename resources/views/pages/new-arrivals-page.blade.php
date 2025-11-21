@extends('layouts.app')

@section('title', 'New Arrivals')

@section('content')
<div class="container py-4  mb-5 pb-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h4 class="fw-bold text-uppercase mb-0">
            <span class="" style="color:#cd4b57">New</span> Arrivals
        </h4>
        <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-sm">← Back to Home</a>
    </div>

    <div id="new-arrivals-container" class="row g-3">
        @include('partials.new-arrivals-items', ['products' => $products])
    </div>

    @if($products->count() >= 24)
    <div class="text-center mt-4">
        <button id="load-more" class="btn btn-primary px-4">
            Load More Products
        </button>
    </div>
    @endif
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let skip = {{ count($products) }};
    const button = document.getElementById('load-more');
    const container = document.getElementById('new-arrivals-container');

    if (button) {
        button.addEventListener('click', function() {
            button.innerText = 'Loading...';
            button.disabled = true;

            fetch(`{{ route('new.arrivals.loadMore') }}?skip=${skip}`)
                .then(res => res.json())
                .then(data => {
                    if (data.count > 0) {
                        container.insertAdjacentHTML('beforeend', data.html);
                        skip += data.count;
                        button.innerText = 'Load More Products';
                        button.disabled = false;
                    } else {
                        button.innerText = 'No More Products';
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

<style>
.product-card {
    background: #fff;
    border: 1px solid #e2e2e2;
    border-radius: 10px;
    padding: 12px;
    transition: 0.3s;
}
.product-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.08);
}
.product-card img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 6px;
}
</style>
@endsection
