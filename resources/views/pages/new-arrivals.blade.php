<!-- New Arrivals Slider -->
<section class="new-arrivals pb-2 position-relative p-2 rounded" style="background-color: #f8f9fa;">
    <div class="container">

        <!-- Section Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-uppercase mb-0">
                    <span class="" style="color: #cd4b57">New</span> Arrivals
                </h5>
                <hr class="ms-2 mb-0" style="width: 50px; border: 1px solid #cd4b57;">
            </div>
           <a href="{{ route('new.arrivals.page') }}" class="btn btn-outline-danger btn-sm " >View All &raquo;</a>

        </div>

        <!-- Slider -->
        <div class="position-relative arrivals-swiper-wrapper">
            <div class="swiper arrivals-swiper">
                <div class="swiper-wrapper">
                    @forelse($newArrivals as $product)
                        <div class="swiper-slide">
                            <div class="arrival-card text-center ">
                                <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                                  <div class="arrival-image mb-2">
                                    @php
                                        $image = $product->mainImage->image_path ?? null;
                                    @endphp

                                    <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                        alt="{{ $product->name }}" class="">


                                    </div>

                                    <h6 class="mb-1 fw-semibold">{{ $product->name }}</h6>
                                </a>
                                <p class="mb-0">
                                    @if($product->old_price)
                                        <span class="text-muted text-decoration-line-through">৳{{ $product->old_price }}</span>
                                    @endif
                                    <span class=" fw-bold" style="color: #cd4b57">৳{{ $product->price }}</span>
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">No new arrivals available.</p>
                    @endforelse
                </div>
            </div>

            <!-- Navigation -->
            <div class="swiper-button-prev arrivals-prev"></div>
            <div class="swiper-button-next arrivals-next"></div>
        </div>

    </div>
</section>


<script>
document.addEventListener('DOMContentLoaded', function() {
    const arrivalsSwiper = new Swiper('.arrivals-swiper', {
        loop: true,
        slidesPerView: 8,
        spaceBetween: 20,
        navigation: {
            nextEl: '.arrivals-next',
            prevEl: '.arrivals-prev',
        },
        breakpoints: {
            0: { slidesPerView: 2, spaceBetween: 10 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 4, spaceBetween: 15 },
            992: { slidesPerView: 6, spaceBetween: 18 },
            1200: { slidesPerView: 8, spaceBetween: 20 },
        },
    });

    const arrivalsContainer = document.querySelector('.arrivals-swiper-wrapper');
    const arrivalsArrows = arrivalsContainer.querySelectorAll('.arrivals-prev, .arrivals-next');
    arrivalsArrows.forEach(btn => btn.style.opacity = 0);
    arrivalsContainer.addEventListener('mouseenter', () => arrivalsArrows.forEach(btn => btn.style.opacity = 1));
    arrivalsContainer.addEventListener('mouseleave', () => arrivalsArrows.forEach(btn => btn.style.opacity = 0));
});
</script>


<style>
.arrival-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e2e2e2;
    box-sizing: border-box;
}

.arrival-card h6 {
    min-height: 40px; /* বা তোমার font-size অনুযায়ী 45px, 50px */
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* সর্বোচ্চ ২ লাইন দেখাবে */
    -webkit-box-orient: vertical;
}

.arrival-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}
.arrival-image {
    position: relative;
    width: 100%;
    padding-top: 100%; /* 1:1 aspect ratio */
    overflow: hidden;
    border-radius: 6px;
}

.arrival-image img {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    object-fit: cover; /* scaled and cropped perfectly */
    transition: transform 0.3s ease;
}

.arrival-card:hover .arrival-image img {
    transform: scale(1.05); /* slight zoom effect on hover */
}
.arrivals-prev,
.arrivals-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    color: #cd4b57;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 10;
}
.arrivals-prev::after,
.arrivals-next::after {
    font-size: 18px;
    color: #cd4b57;
}
.arrivals-prev { left: -30px; }
.arrivals-next { right: -30px; }
@media (max-width: 768px) {
    .arrivals-prev, .arrivals-next {
        opacity: 1 !important;
        width: 24px; height: 24px;
    }
    .arrivals-prev::after, .arrivals-next::after {
        font-size: 16px;
    }
}
</style>
