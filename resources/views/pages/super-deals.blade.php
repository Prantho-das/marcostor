<!-- Super Deals Slider -->
<section class="super-deals py-4 position-relative rounded">
    <div class="container p-4" style="background-color: #f8f9fa;">

        <!-- Section Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-uppercase mb-0">
                    <span class="text-danger">Super</span> Deals
                </h5>
                <hr class="ms-2 mb-0" style="width: 50px; border: 1px solid #dc3545;">
            </div>

            <a href="{{ route('super.deals') }}" class="btn btn-outline-danger btn-sm">View All &raquo;</a>
        </div>

        <!-- Slider -->
        <div class="position-relative super-deals-swiper-wrapper">
            <div class="swiper super-deals-swiper">
                <div class="swiper-wrapper">
                    @forelse($superDeals as $product)
                        <div class="swiper-slide">
                            <div class="arrival-card text-center">
                                <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                                    <div class="arrival-image mb-3">
                                        @php
                                            $image = $product->mainImage->image_path ?? null;
                                        @endphp
                                        <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                             alt="{{ $product->name }}" class="img-fluid">
                                    </div>
                                    <h6 class="mb-1 fw-semibold">{{ $product->name }}</h6>
                                </a>
                                <p class="mb-0">
                                    @if($product->price && $product->discount_price)
                                        <span class="text-muted text-decoration-line-through">৳{{ $product->price }}</span>
                                        <span class="text-danger fw-bold">৳{{ $product->discount_price }}</span>
                                    @else
                                        <span class="text-danger fw-bold">৳{{ $product->price }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No Super Deals available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Navigation -->
            <div class="swiper-button-prev super-deals-prev"></div>
            <div class="swiper-button-next super-deals-next"></div>
        </div>

    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const superDealsSwiper = new Swiper('.super-deals-swiper', {
        loop: true,
        slidesPerView: 8,
        spaceBetween: 20,
        navigation: {
            nextEl: '.super-deals-next',
            prevEl: '.super-deals-prev',
        },
        breakpoints: {
            0: { slidesPerView: 2, spaceBetween: 10 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 4, spaceBetween: 15 },
            992: { slidesPerView: 6, spaceBetween: 18 },
            1200: { slidesPerView: 8, spaceBetween: 20 },
        },
    });

    const container = document.querySelector('.super-deals-swiper-wrapper');
    const arrows = container.querySelectorAll('.super-deals-prev, .super-deals-next');
    arrows.forEach(btn => btn.style.opacity = 0);
    container.addEventListener('mouseenter', () => arrows.forEach(btn => btn.style.opacity = 1));
    container.addEventListener('mouseleave', () => arrows.forEach(btn => btn.style.opacity = 0));
});
</script>

<style>
.super-deals .arrival-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e2e2e2;
    box-sizing: border-box;
}

.super-deals .arrival-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.super-deals .arrival-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
}

.super-deals-prev,
.super-deals-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    color: #dc3545;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 10;
}

.super-deals-prev::after,
.super-deals-next::after {
    font-size: 18px;
    color: #dc3545;
}

.super-deals-prev { left: -30px; }
.super-deals-next { right: -30px; }

@media (max-width: 768px) {
    .super-deals-prev,
    .super-deals-next {
        opacity: 1 !important;
        width: 24px;
        height: 24px;
    }
    .super-deals-prev::after,
    .super-deals-next::after {
        font-size: 16px;
    }
}
</style>
