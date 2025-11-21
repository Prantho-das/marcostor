<!-- Cover Cases Slider -->
<section class="cover-cases pb-2 position-relative p-2 rounded mt-3" style="background-color: #f8f9fa;">
    <div class="container">

        <!-- Section Heading -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center">
                <h5 class="fw-bold text-uppercase mb-0">
                      <span class="" style="color: #cd4b57">{{ $coversCategory->name ?? 'Covers' }}</span> Collection
                </h5>
                <hr class="ms-2 mb-0" style="width: 50px; border: 1px solid #198754;">
            </div>

            <a href="{{ route('category.show', $coverProducts->first()->category->slug ?? '') }}" class="btn btn-outline-danger btn-sm">View All &raquo;</a>
        </div>

        <div class="position-relative cover-cases-swiper-wrapper">
            <div class="swiper cover-cases-swiper">
                <div class="swiper-wrapper">
                    @forelse ($coverProducts as $product)
                        <div class="swiper-slide">
                            <div class="case-card text-center p-3">
                                <div class="case-image mb-3">
                                     <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
                                     @php
                                        $image = $product->mainImage->image_path ?? null;
                                    @endphp

                                    <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" 
                                        alt="{{ $product->name }}" class="img-fluid" style="height:130px; object-fit:cover;">
                                    </a>
                                </div>
                                <h6 class="case-title">{{ $product->name }}</h6>
                                <p class="mb-0">
                                     @if($product->discount_price)
                                        <span class="text-muted text-decoration-line-through">৳{{ number_format($product->price) }}</span>
                                        <span class=" fw-bold" style="color: #cd4b57">৳{{ number_format($product->discount_price) }}</span>
                                    @else
                                        <span class="text-dark fw-bold">৳{{ number_format($product->price) }}</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted text-center">No cover case products found.</p>
                    @endforelse
                </div>
            </div>

            <div class="swiper-button-prev cover-prev"></div>
            <div class="swiper-button-next cover-next"></div>
        </div>
    </div>
</section>


<!-- Swiper Script -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const coverSwiper = new Swiper('.cover-cases-swiper', {
        loop: true,
        slidesPerView: 8,
        spaceBetween: 20,
        navigation: {
            nextEl: '.cover-next',
            prevEl: '.cover-prev',
        },
        breakpoints: {
            0: { slidesPerView: 2, spaceBetween: 10 },
            576: { slidesPerView: 2, spaceBetween: 10 },
            768: { slidesPerView: 4, spaceBetween: 15 },
            992: { slidesPerView: 6, spaceBetween: 18 },
            1200: { slidesPerView: 8, spaceBetween: 20 },
        },
    });

    const coverContainer = document.querySelector('.cover-cases-swiper-wrapper');
    const coverArrows = coverContainer.querySelectorAll('.cover-prev, .cover-next');
    coverArrows.forEach(btn => btn.style.opacity = 0);
    coverContainer.addEventListener('mouseenter', () => coverArrows.forEach(btn => btn.style.opacity = 1));
    coverContainer.addEventListener('mouseleave', () => coverArrows.forEach(btn => btn.style.opacity = 0));
});
</script>

<style>
/* Card Styling */
.case-card {
    background: #fff;
    border-radius: 10px;
    padding: 12px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border: 1px solid #e2e2e2;
    box-sizing: border-box;
}

.case-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
}

.case-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 6px;
}

.case-title {
    font-size: 0.9rem;
    font-weight: 600;
    line-height: 1.2;
    max-height: 2.4em; /* 2 lines */
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2; /* truncate after 2 lines */
    -webkit-box-orient: vertical;
    margin-bottom: 4px;
}

/* Swiper Buttons */
.cover-prev,
.cover-next {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 28px;
    height: 28px;
    color: #198754;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.3s ease;
    z-index: 10;
}

.cover-prev::after,
.cover-next::after {
    font-size: 18px;
    color: #198754;
}

.cover-prev {
    left: -30px;
}

.cover-next {
    right: -30px;
}

/* Always visible on mobile */
@media (max-width: 768px) {
    .cover-prev,
    .cover-next {
        opacity: 1 !important;
        width: 24px;
        height: 24px;
    }
    .cover-prev::after,
    .cover-next::after {
        font-size: 16px;
    }
}
</style>
