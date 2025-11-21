<!-- Sound Devices Section -->
<section class="sound-devices py-4 mt-4" style="background-color: #f8f9fa;">
    <div class="container p-4">
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-uppercase mb-0">
                    <span class="" style="color: #cd4b57">{{ $soundCategory->name ?? 'Sounds'}}</span> Devices
                </h5>
                <hr class="ms-2 mb-0" style="width: 50px; border: 1px solid #cd4b57;">
            </div>
            <a href="{{  route('category.show', $soundProducts->first()->category->slug ?? '')  }}" class="btn btn-outline-danger btn-sm">View All &raquo;</a>
        </div>

        <div class="row g-3">
            <div class="col-lg-3 col-md-12">
                <div class="promo-image rounded overflow-hidden shadow-sm h-100">
                    <img src="{{ asset('public/assets/images/sound.webp') }}" alt="Sound Devices" class="img-fluid w-100 h-100 object-fit-contain">
                </div>
            </div>

            <div class="col-lg-9 col-md-12">
                <div class="row g-3" id="product-list">
                    @forelse ($soundProducts as $product)
                        <div class="col-6 col-md-4 col-lg-2 product-card">
                            <div class="text-center p-2 bg-white rounded shadow-sm h-100 border">
                                 <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                                 @php
                                        $image = $product->mainImage->image_path ?? null;
                                    @endphp

                                    <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                        alt="{{ $product->name }}" class="img-fluid " style="height:130px; object-fit:cover;">
                                    </a>
                                        
                                <h6 class="fw-semibold small mb-1">{{ $product->name }}</h6>
                                <p class="mb-0 small">
                                     @if($product->discount_price)
                                        <span class="text-muted text-decoration-line-through">৳{{ number_format($product->price) }}</span><br>
                                        <span class=" fw-bold" style="color: #cd4b57">৳{{ number_format($product->discount_price) }}</span>
                                    @else
                                        <span class="text-dark fw-bold">৳{{ number_format($product->price) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No sound device products found.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>

<!-- JS Filtering Logic -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const buttons = document.querySelectorAll('.filter-btn');
    const products = document.querySelectorAll('.product-card');

    buttons.forEach(btn => {
        btn.addEventListener('click', () => {
            buttons.forEach(b => b.classList.remove('active', 'btn-success'));
            buttons.forEach(b => b.classList.add('btn-outline-success'));
            btn.classList.remove('btn-outline-success');
            btn.classList.add('btn-success', 'active');

            const filter = btn.dataset.filter;
            products.forEach(product => {
                if (filter === 'all' || product.dataset.category === filter) {
                    product.style.display = 'block';
                } else {
                    product.style.display = 'none';
                }
            });
        });
    });
});
</script>

<style>
.product-card {
    transition: all 0.3s ease;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.1);
}
.filter-btn.active {
    box-shadow: 0 2px 8px rgba(25,135,84,0.4);
}
@media (max-width: 767.98px) {
    .product-card img {
        height: 120px;
    }
}
</style>
