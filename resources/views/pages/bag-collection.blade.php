<!-- Bags Collection Section -->
<section class="bags-collection py-4" style="background-color: #f8f9fa;">
    <div class="container p-4">
        <!-- Section Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-uppercase mb-0">
                     <span class="" style="color:#cd4b57">{{ $bagsCategory->name ?? 'Bag' }}</span> Collection
                </h5>
                <hr class="ms-2 mb-0" style="width: 50px; border: 1px solid #007bff;">
            </div>

            <a href="{{ route('category.show', $bagsProducts->first()->category->slug ?? '') }}" class="btn btn-outline-danger btn-sm">
                View All &raquo;
            </a>
        </div>

        <div class="row g-3">
            <!-- Left Side Image -->
            <div class="col-lg-3 col-md-12">
                <div class="promo-image rounded overflow-hidden shadow-sm h-100">
                    <img src="{{ asset('public/assets/images/bag.jpeg') }}" alt="Bag Collection" class="img-fluid w-100 h-100 object-fit-contain">
                </div>
            </div>

            <!-- Right Side Products -->
            <div class="col-lg-9 col-md-12">
                <div class="row g-3">
                    @forelse ($bagsProducts as $product)
                        <div class="col-6 col-md-4 col-lg-2">
                            <div class="product-card text-center p-2 bg-white rounded shadow-sm h-100 border">
                                 <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                                @php
                                        $image = $product->mainImage->image_path ?? null;
                                    @endphp

                                    <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                        alt="{{ $product->name }}" class="img-fluid " style="height:130px; object-fit:cover;">

                                <h6 class="fw-semibold small mb-1">{{ $product->name }}</h6>
                                </a>
                                <p class="mb-0 small">
                                    @if($product->discount_price)
                                        <span class="text-muted text-decoration-line-through">৳{{ number_format($product->price) }}</span><br>
                                        <span class="text-danger fw-bold">৳{{ number_format($product->discount_price) }}</span>
                                    @else
                                        <span class="text-dark fw-bold">৳{{ number_format($product->price) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No bag products found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>


<style>
.product-card {
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.product-card img {
    max-height: 130px;
    object-fit: cover;
}

.product-card h6 {
    font-size: 0.85rem; /* slightly smaller for better fit */
    font-weight: 600;
    margin-bottom: 0.25rem;
    white-space: nowrap;        /* single line */
    overflow: hidden;           /* hide overflow */
    text-overflow: ellipsis;    /* show ... if overflow */
}

.product-card p {
    margin-bottom: 0;
    font-size: 0.8rem;
}

@media (max-width: 767.98px) {
    .product-card img {
        height: 120px;
    }
    .product-card h6 {
        font-size: 0.8rem;
    }
    .product-card p {
        font-size: 0.75rem;
    }
}

</style>
