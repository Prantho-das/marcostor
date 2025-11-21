<div class="coverer-fluid px-0 hero-section pb-3">
    <!-- Desktop & Tablet View -->
    <div class="d-none d-md-flex">
        <div class="row g-2">
            <!-- Left Large Image -->
            <div class="col-md-8">
                <img src="{{ asset('public/assets/images/hero2.png') }}" alt="Large Image" class="img-fluid w-100 h-100 object-fit-cover rounded">
            </div>
            <!-- Right Two Images -->
            <div class="col-md-4 d-flex flex-column gap-2">
                <img src="{{ asset('public/assets/images/hero2.png') }}" alt="Small Image 1" class="img-fluid w-100 h-50 object-fit-cover rounded">
                <img src="{{ asset('public/assets/images/hero3.avif') }}" alt="Small Image 2" class="img-fluid w-100 h-50 object-fit-cover rounded">
            </div>
        </div>
    </div>

    <!-- Mobile Slider View -->
    <div class="d-md-none">
        <div id="heroMobileSlider" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="{{ asset('assets/images/hero2.png') }}" class="d-block w-100" alt="Slide 1">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/images/hero2.png') }}" class="d-block w-100" alt="Slide 2">
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('assets/images/hero3.avif') }}" class="d-block w-100" alt="Slide 3">
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .hero-section img {
    border-radius: 10px;
    object-fit: cover;
    height: 100%;
}

@media (max-width: 767px) {
    .carousel-item img {
       
        object-fit: contain;
    }
}

</style>