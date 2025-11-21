<!-- Shop by Category Section -->
<section class="shop-category  pb-5 position-relative"
    style="background: linear-gradient(180deg, #f8f9fa 0%, #ffffff 100%);">
    <div class="container">

        <!-- Heading with decorative lines -->
        <div class="d-flex align-items-center justify-content-center mb-4">
            <hr class="flex-grow-1 me-3  opacity-50" style="height:2px; border-color: #cd4b57;">
            <h5 class="mb-0 text-center fw-bold text-uppercase" style="color: #cd4b57">Shop by Category</h5>
            <hr class="flex-grow-1 ms-3  opacity-50" style="height:2px; border-color: #cd4b57;">
        </div>

        <!-- Category Slider -->
        <div class="position-relative swiper-wrapper-container">
<div class="swiper shop-category-swiper">
    <div class="swiper-wrapper">
@foreach($subCategories as $cat)
    @php
        // Original path থেকে thumbs path তৈরি করা হচ্ছে
        $thumbPath = str_replace('processed', 'thumbs', $cat->image);
    @endphp

    <div class="swiper-slide text-center">
        <div class="category-item mx-auto p-2">
            <div class="category-image-wrapper">
                @if(\Illuminate\Support\Facades\Storage::exists('public/' . $thumbPath))
                    <img src="{{ asset('public/storage/' . $thumbPath) }}" 
                         alt="{{ $cat->name }}" 
                         class="img-fluid rounded-circle border border-2 p-2" style="border-color: #cd4b57;">
                @else
                    <img src="{{ asset('public/storage/' . $cat->image) }}" 
                         alt="{{ $cat->name }}" 
                         class="img-fluid rounded-circle border border-2 p-2" style="border-color: #cd4b57;">
                @endif
            </div>
            <p class="mt-2 mb-0 fw-semibold text-dark">
                <a href="{{ route('category.show', $cat->slug) }}" class="text-dark text-decoration-none">
                    {{ $cat->name }}
                </a>
            </p>
        </div>
    </div>
@endforeach

    </div>
</div>


            <!-- Navigation Arrows -->
            <div class="swiper-button-prev custom-prev"></div>
            <div class="swiper-button-next custom-next"></div>
        </div>
    </div>
</section>




<script>
document.addEventListener('DOMContentLoaded', function() {
    const shopSwiper = new Swiper('.shop-category-swiper', {
        loop: true,
        slidesPerView: 8,
        spaceBetween: 20,
        navigation: {
            nextEl: '.custom-next',
            prevEl: '.custom-prev',
        },
        breakpoints: {
            0: { slidesPerView: 3, spaceBetween: 10 },
            576: { slidesPerView: 3, spaceBetween: 15 },
            768: { slidesPerView: 4, spaceBetween: 15 },
            992: { slidesPerView: 6, spaceBetween: 18 },
            1200: { slidesPerView: 8, spaceBetween: 20 },
        },
    });

    const shopContainer = document.querySelector('.swiper-wrapper-container');
    const shopArrows = shopContainer.querySelectorAll('.custom-next, .custom-prev');
    shopArrows.forEach(btn => btn.style.opacity = 0);
    shopContainer.addEventListener('mouseenter', () => shopArrows.forEach(btn => btn.style.opacity = 1));
    shopContainer.addEventListener('mouseleave', () => shopArrows.forEach(btn => btn.style.opacity = 0));
});
</script>
  

<style>
/* Category Styling */
.category-item {
    transition: transform 0.3s ease;
}

.category-image-wrapper {
    width: 90px;
    height: 90px;
    margin: 0 auto;
    border-radius: 50%;
    background: #ffffff;
    border: 1px solid #dee2e6;
    display: flex;
    align-items: center;
    justify-content: center;
}

.category-image-wrapper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.category-item p {
    font-size: 0.9rem;
    color: #333;
}

/* Swiper Buttons (Smaller + Fade Effect on Hover) */
.custom-next,
.custom-prev {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    z-index: 10;
    width: 22px;
    height: 22px;
    color: #cd4b57;
    font-weight: bold;
    cursor: pointer;
    opacity: 0;
    transition: opacity 0.4s ease;
}

.custom-next::after,
.custom-prev::after {
    font-size: 18px;
    color: #cd4b57;
}

.custom-next {
    right: -30px;
}

.custom-prev {
    left: -30px;
}

/* Hover show arrows */
.swiper-wrapper-container:hover .custom-next,
.swiper-wrapper-container:hover .custom-prev {
    opacity: 1;
}

/* Mobile Responsiveness */
@media (max-width: 768px) {

    .custom-next,
    .custom-prev {
        opacity: 1 !important;
        /* Always visible on mobile */
    }

    .category-image-wrapper {
        width: 70px;
        height: 70px;
    }

    .category-item p {
        font-size: 0.8rem;
    }

    .custom-next,
    .custom-prev {
        width: 18px;
        height: 18px;
    }

    .custom-next::after,
    .custom-prev::after {
        font-size: 14px;
    }

    .custom-next {
        right: -10px;
    }

    .custom-prev {
        left: -10px;
    }
}
</style>