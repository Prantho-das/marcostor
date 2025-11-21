@extends('layouts.app')

@section('title', 'About Us | Marco BD')

@section('content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase">
           About <span style="color: #cd4b57;">Marco</span> 
        </h2>
        <p class="text-muted">Your trusted online gadgets & accessories store in Bangladesh</p>
    </div>

    <!-- What We Do -->
    <section class="mb-5">
        <div class="row align-items-center g-4">
            <div class="col-md-6">
                <img src="{{ asset('public/assets/images/marco_logo.jpg') }}" class="img-fluid rounded shadow" alt="About Marco" style="max-height: 300px; object-fit: contain; width: 80%;">
            </div>
            <div class="col-md-6">
                <h4 class="fw-semibold mb-3" style="color: #cd4b57;">What We Really Do?</h4>
                <p class="text-muted">
                    We provide a wide range of branded gadgets and accessories from different sources
                    and deliver them right to your doorstep. Our goal is to ensure convenience, quality,
                    and satisfaction — every single time.
                </p>
                <p class="text-muted">
                    Our customer support team is always here to assist you with detailed product information
                    and after-sales service.
                </p>
            </div>
        </div>
    </section>

    <!-- Vision -->
    <section class="mb-5 bg-light p-4 rounded-3 shadow-sm">
        <h4 class="fw-semibold mb-3" style="color: #cd4b57;">Our Vision</h4>
        <p class="text-muted mb-0">
            Our ultimate goal is to satisfy every customer in Bangladesh through honesty, quality products,
            reasonable prices, and fast delivery. We believe that trust and transparency build long-term relationships.
        </p>
    </section>

    <!-- History -->
    <section class="mb-5">
        <div class="row align-items-center g-4 flex-md-row-reverse">
            <div class="col-md-6">
                <img src="{{ asset('public/assets/images/marco_logo.jpg') }}" class="img-fluid rounded shadow" alt="Our History" style="max-height: 300px; object-fit: contain; width: 80%;">
            </div>
            <div class="col-md-6">
                <h4 class="fw-semibold mb-3" style="color: #cd4b57;">History of Beginning</h4>
                <p class="text-muted">
                    Marco BD started its journey in early 2020 with a simple mission — to make high-quality
                    gadgets and accessories accessible to everyone in Bangladesh. Today, we’re proud to be one of
                    the most trusted online gadget stores in the country.
                </p>
            </div>
        </div>
    </section>

    <!-- Order Process -->
    <section class="mb-5 bg-light p-4 rounded-3 shadow-sm">
        <h4 class="fw-semibold mb-3" style="color: #cd4b57;">Order Process</h4>
        <p class="text-muted">
            You can place orders directly from our website, over the phone, or through our social media channels.
            Once we receive your order, it usually takes 24–48 hours to process and prepare for delivery.
        </p>
    </section>

    <!-- Payment Method -->
    <section class="mb-5">
        <h4 class="fw-semibold mb-3" style="color: #cd4b57;">Payment Method</h4>
        <p class="text-muted">
            We support over 15 secure payment gateways through SSLCommerz. Payments can be made via
            Debit/Credit cards, Mobile Banking, Internet Banking, and E-wallets — ensuring your transaction
            is 100% safe.
        </p>
    </section>

    <!-- Delivery System -->
    <section class="mb-5 bg-light p-4 rounded-3 shadow-sm">
        <h4 class="fw-semibold mb-3" style="color: #cd4b57;">Delivery System</h4>
        <p class="text-muted">
            We deliver almost everywhere in Bangladesh using our own delivery network and trusted courier services.
            You can choose home delivery or cash-on-delivery options. In most areas, you can even check the product
            before making payment.
        </p>
        <h6 class="fw-semibold" style="color: #cd4b57;" class="mt-3">Delivery Time</h6>
        <p class="text-muted mb-0">
            Inside Dhaka: 3–5 working days <br>
            Outside Dhaka: 5–7 working days <br>
            Our delivery agents always call before reaching your location to ensure smooth delivery.
        </p>
    </section>

    <!-- Contact -->
    <section class="contact-info py-4 text-center border-top">
        <h4 class="fw-semibold" style="color: #cd4b57;">Contact Us</h4>
        <p class="text-muted mb-1">📍 Dhaka , Bangladesh</p>
        <p class="text-muted mb-1">📞 Hotline: <a href="tel:+8801745543676" class="text-decoration-none text-dark">01757-672906</a></p>
        <p class="text-muted mb-1">💬 WhatsApp: <a href="https://wa.me/8801745543676" class="text-decoration-none text-dark">+8801757-672906</a></p>
        <p class="text-muted mb-1">📧 Email: <a href="mailto:support@Marco.com" class="text-decoration-none text-dark">support@Marco.com</a></p>
        <p class="text-muted mt-2 small">Trade License: TRAD/DSCC/006478/2025 | E-TIN: 354891231</p>
    </section>

</div>

<style>
/* Extra polish for sections */
section {
    transition: transform 0.2s ease;
}
section:hover {
    transform: translateY(-3px);
}

/* Mobile Responsive Adjustments */
@media (max-width: 767px) {
    section img {
        max-height: 250px;
    }
    section h4, section h6 {
        font-size: 1.1rem;
    }
    section p {
        font-size: 0.9rem;
    }
}
</style>
@endsection
