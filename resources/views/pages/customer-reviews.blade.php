<!-- Customer Reviews Page -->
<section class="customer-reviews py-5 mt-4" style="background-color: #f8f9fa;">
    <div class="container">
        <!-- Section Header -->
        <div class="text-center mb-5">
            <h2 class="fw-bold text-uppercase">
                <span class="text-warning">Customer</span> Reviews
            </h2>
            <hr class="mx-auto" style="width: 80px; border: 2px solid #ffc107;">
            <p class="text-muted mb-0">What our happy customers are saying about us!</p>
        </div>

        <!-- Reviews Grid -->
        <div class="row g-4">
            @foreach ([
                ['name' => 'Sadia Akter', 'image' => 'public/assets/images/customer.jpg', 'rating' => 5, 'review' => 'Absolutely loved the product! The quality is top-notch and delivery was super fast.'],
                ['name' => 'Rahim Khan', 'image' => 'public/assets/images/customer.jpg', 'rating' => 4, 'review' => 'Good product, worth the money. Customer support was helpful too.'],
                ['name' => 'Mitu Rahman', 'image' => 'public/assets/images/customer.jpg', 'rating' => 5, 'review' => 'Beautiful packaging and the sound quality of the earbuds is amazing!'],
                ['name' => 'Arif Hasan', 'image' => 'public/assets/images/customer.jpg', 'rating' => 4, 'review' => 'Nice experience overall. I will definitely buy again.'],
                ['name' => 'Tanvir Ahmed', 'image' => 'public/assets/images/customer.jpg', 'rating' => 5, 'review' => 'Fast delivery, authentic products and best service! Highly recommended.'],
                ['name' => 'Jannat Jahan', 'image' => 'public/assets/images/customer.jpg', 'rating' => 5, 'review' => 'Loved it! Design is awesome, product quality is premium.']
            ] as $review)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="review-card bg-white rounded-3 shadow-sm p-4 h-100 position-relative">
                        <div class="d-flex align-items-center mb-3">
                            <img src="{{ $review['image'] }}" alt="{{ $review['name'] }}" class="rounded-circle me-3" width="60" height="60" style="object-fit: cover;">
                            <div>
                                <h6 class="fw-bold mb-0">{{ $review['name'] }}</h6>
                                <div class="text-warning">
                                    @for ($i = 0; $i < 5; $i++)
                                        @if ($i < $review['rating'])
                                            <i class="fas fa-star"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                        <p class="text-muted mb-0">{{ $review['review'] }}</p>
                        <div class="quote-icon position-absolute top-0 end-0 p-3 text-warning opacity-25">
                            <i class="fas fa-quote-right fa-2x"></i>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<style>
.review-card {
    transition: all 0.3s ease;
    border: 1px solid #eee;
}
.review-card:hover {
    transform: translateY(-6px);
    box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}
.review-card img {
    border: 2px solid #ffc107;
}
@media (max-width: 767.98px) {
    .review-card {
        padding: 1.2rem;
    }
    .review-card img {
        width: 50px;
        height: 50px;
    }
}
</style>
