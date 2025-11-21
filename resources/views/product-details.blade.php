@extends('layouts.app')

@section('content')
<section class="pb-5 mb-5" style="background-color:#fff;">
    <div class="container">
        <div class="row g-4 align-items-start">
            <!-- Left: Product Image -->
            <div class="col-lg-5 col-md-6 text-center">
               <div class="border rounded shadow-sm p-3 bg-white position-relative overflow-hidden zoom-container">
    <img id="mainImage"
         src="{{ $product->mainImage ? asset('public/storage/' . $product->mainImage->image_path) : asset('public/assets/images/placeholder.png') }}"
         alt="{{ $product->name }}"
         class="img-fluid zoom-image"
         style="max-height:400px; object-fit:contain;">
</div>


                <!-- Thumbnail Gallery -->
                <div class="d-flex justify-content-center gap-2 mt-3 flex-wrap">
                    @foreach($product->images as $img)
                        <img src="{{ asset('public/storage/' . $img->image_path) }}"
                             class="border rounded"
                             style="height:70px; cursor:pointer;"
                             onclick="document.querySelector('#mainImage').src='{{ asset('storage/' . $img->image_path) }}'">
                    @endforeach
                </div>
            </div>

            <!-- Right: Product Info -->
            <div class="col-lg-7 col-md-6">
                <!-- Breadcrumb -->
                <nav aria-label="breadcrumb" class="mb-2">
                    <ol class="breadcrumb small text-muted">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
                        @if($product->category)
                            <li class="breadcrumb-item">
                                <a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a>
                            </li>
                        @endif
                        <li class="breadcrumb-item active d-none d-sm-block">{{ $product->name }}</li>
                    </ol>
                </nav>

                <h4 class="fw-bold">{{ $product->name }}</h4>

                <!-- Price -->
                <div class="my-3">
                    @if($product->discount_price)
                        <span class="text-muted text-decoration-line-through fs-6">৳{{ $product->price }}</span>
                        <span class="fw-bold  fs-4 ms-2" style="color: #cd4b57">৳{{ $product->discount_price }}</span>
                    @else
                        <span class="fw-bold  fs-4" style="color: #cd4b57">৳{{ $product->price }}</span>
                    @endif
                </div>

                <!-- Quantity + Buttons -->
                <div class="d-flex flex-wrap align-items-center gap-3 mb-3">
                    <div class="input-group" style="width:120px;">
                        <button class="btn btn-outline-secondary" type="button" id="decrease">-</button>
                        <input type="text" class="form-control text-center" value="1" id="quantity">
                        <button class="btn btn-outline-secondary" type="button" id="increase">+</button>
                    </div>
                    <button class="btn btn-dark px-5 py-2 fw-semibold" id="addToCartBtn"
                     data-product-id="{{ $product->id }}">Add to Cart</button>


                    <button class="btn btn-danger px-5 py-2 fw-semibold">Buy Now</button>
                </div>

                <!-- Safe Checkout -->
                <div class="border p-3 rounded bg-light small text-center mb-3">
                    <strong>Guaranteed Safe Checkout</strong>
                    <div class="d-flex justify-content-center gap-2 mt-2 flex-wrap">
                        <img src="{{ asset('assets/images/payment/visa.png') }}" height="25" alt="">
                        <img src="{{ asset('assets/images/payment/mastercard.png') }}" height="25" alt="">
                        <img src="{{ asset('assets/images/payment/bkash.png') }}" height="25" alt="">
                        <img src="{{ asset('assets/images/payment/nagad.png') }}" height="25" alt="">
                        <img src="{{ asset('assets/images/payment/rocket.png') }}" height="25" alt="">
                    </div>
                </div>

                <!-- SKU & Category -->
                <ul class="list-unstyled small text-muted">
                    <li><strong>SKU:</strong> {{ $product->sku ?? 'N/A' }}</li>
                    <li><strong>Category:</strong> {{ $product->category->name ?? 'N/A' }}</li>
                    <li><strong>Brand:</strong> {{ $product->brand->name ?? 'N/A' }}</li>
                </ul>
            </div>
        </div>

    <!-- Description Section -->
<div class="row mt-5">
    <div class="col-lg-12">
        <div class="border rounded p-4 bg-white shadow-sm product-description">
            <h5 class="fw-bold mb-3">Product Description</h5>
            <p class="text-muted small">{!! $product->description !!}</p>
        </div>
    </div>
</div>

    </div>
</section>

<style>
.breadcrumb a {
    color: #6c757d;
    text-decoration: none;
}
.breadcrumb a:hover {
    text-decoration: underline;
}

/* Default (Desktop) */
.input-group {
    width: 120px;
}

.zoom-container {
    cursor: zoom-in;
    position: relative;
    overflow: hidden;
}

.zoom-image {
    transition: transform 0.2s ease-out;
    transform-origin: center center;
}

.zoom-container:hover .zoom-image {
    transform: scale(1.6); /* কতটা বড় হবে */
}


/* Mobile responsive layout */
@media (max-width: 768px) {
    /* Make quantity and buttons stack vertically */
    .d-flex.flex-wrap.align-items-center.gap-3.mb-3 {
        flex-direction: column !important;
        align-items: stretch !important;
        gap: 12px !important;
    }

    .input-group {
        width: 100% !important;
    }

    .btn-dark,
    .btn-primary {
        width: 100% !important;
    }

    #quantity {
        text-align: center;
    }

    /* Description alignment fix */
    .product-description p,
    .product-description {
        text-align: left !important;
    }
}
</style>



<script>
document.addEventListener("DOMContentLoaded", () => {
    const quantityInput = document.getElementById('quantity');
    document.getElementById('increase').addEventListener('click', () => {
        quantityInput.value = parseInt(quantityInput.value) + 1;
    });
    document.getElementById('decrease').addEventListener('click', () => {
        if (quantityInput.value > 1)
            quantityInput.value = parseInt(quantityInput.value) - 1;
    });

    // Add to Cart functionality
    const addToCartBtn = document.getElementById('addToCartBtn');
    addToCartBtn.addEventListener('click', () => {
        const qty = parseInt(document.getElementById('quantity').value) || 1;
        fetch("{{ route('cart.add') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: addToCartBtn.dataset.productId,
                quantity: qty
            }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                // nicer UX: use toast instead of alert
                showToast(data.message || 'Added to cart');
                loadCartSidebar(); // 🆕 sidebar data refresh
                openCartSidebar(); // 🔥 এখানে নতুন ফাংশন কল হবে
            } else {
                showToast('Could not add to cart', 'danger');
            }
        }).catch(err => showToast('Something went wrong','danger'));
    });


    const zoomContainer = document.querySelector('.zoom-container');
    const zoomImage = document.querySelector('.zoom-image');

    zoomContainer.addEventListener('mousemove', (e) => {
        const rect = zoomContainer.getBoundingClientRect();
        const x = ((e.clientX - rect.left) / rect.width) * 100;
        const y = ((e.clientY - rect.top) / rect.height) * 100;
        zoomImage.style.transformOrigin = `${x}% ${y}%`;
    });

    zoomContainer.addEventListener('mouseleave', () => {
        zoomImage.style.transformOrigin = 'center center';
    });



    function showToast(message, type = 'success') {
        // simple fallback
        alert(message);
        // ideally implement Bootstrap toast or snackbar for nicer UX
    }
});


</script>



@include('cart-sidebar')

@endsection
