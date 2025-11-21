@foreach($products as $product)
    <div class="col-6 col-md-4 col-lg-2">
        <div class="product-card text-center">
            <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
              @php
                                        $image = $product->mainImage->image_path ?? null;
                                    @endphp

                                    <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                        alt="{{ $product->name }}" class="">


                <h6 class="mt-2 fw-semibold">{{ $product->name }}</h6>
            </a>
            <p class="mb-0">
                @if($product->old_price)
                    <span class="text-muted text-decoration-line-through">৳{{ $product->old_price }}</span>
                @endif
                <span class=" fw-bold" style="color: #cd4b57">৳{{ $product->price }}</span>
            </p>
        </div>
    </div>

    <style>
.product-card {
    background: #fff;
    border: 1px solid #e2e2e2;
    border-radius: 10px;
    padding: 10px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    box-sizing: border-box;
    height: 100%; /* grid height maintain করবে */
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
}

/* image part */
.product-card img {
    width: 100%;
    height: 160px;
    object-fit: cover;
    border-radius: 6px;
}

/* name fix */
.product-card h6 {
    font-size: 0.9rem;
    font-weight: 600;
    color: #333;
    min-height: 40px; /* name height equal রাখবে */
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* সর্বোচ্চ ২ লাইন দেখাবে */
    -webkit-box-orient: vertical;
}

/* price layout fix */
.product-card p {
    font-size: 0.9rem;
    margin-top: 5px;
}

/* Optional: Responsive tweak */
@media (max-width: 768px) {
    .product-card img {
        height: 130px;
    }
}
</style>

@endforeach
