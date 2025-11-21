@extends('layouts.app')

@section('title', 'Contact Us | Marco BD')

@section('content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase">
            <span style="color: #cd4b57;">Contact</span> Us
        </h2>
        <p class="text-muted">Have any questions? We are here to help you!</p>
    </div>

    <!-- Contact Info Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="contact-card p-4 shadow-sm rounded-3 text-center h-100">
                <i class="fa-solid fa-phone fa-2x mb-3" style="color: #cd4b57;"></i>
                <h5 class="fw-semibold mb-2">Customer Support</h5>
                <p class="text-muted mb-1">Hotline: <a href="tel:+8801757672906">+8801757-672906</a></p>
                <p class="text-muted mb-0">Hours: 11am to 5pm, Wed–Mon</p>
                <p class="text-muted mt-1">Payment Support: <a href="tel:+8801965650609">+8801965-650609</a></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="contact-card p-4 shadow-sm rounded-3 text-center h-100">
                <i class="fa-solid fa-envelope fa-2x mb-3" style="color: #cd4b57;"></i>
                <h5 class="fw-semibold mb-2">Email Support</h5>
                <p class="text-muted mb-1">Customer: <a href="mailto:support@gadstyle.com">support@gadstyle.com</a></p>
                <p class="text-muted mb-1">Merchants: <a href="mailto:sales@gadstyle.com">sales@gadstyle.com</a></p>
                <p class="text-muted mb-0">Business Proposal: <a href="mailto:info@gadstyle.com">info@gadstyle.com</a></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="contact-card p-4 shadow-sm rounded-3 text-center h-100">
                <i class="fa-solid fa-location-dot fa-2x mb-3" style="color: #cd4b57;"></i>
                <h5 class="fw-semibold mb-2">Office Location</h5>
                <p class="text-muted mb-1">Dhaka, Bangladesh</p>
                <p class="text-muted">Technical Office: 8/34-B, Eastern Plaza Commercial Complex, Sonargaon Road</p>
            </div>
        </div>
    </div>

    <!-- FAQ Accordion -->
    <div class="faq-section mb-5">
        <h3 class="fw-semibold mb-4 text-center" style="color: #cd4b57;">Frequently Asked Questions</h3>
        <div class="accordion" id="faqAccordion">
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqOne">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Where is your Office?
                    </button>
                </h2>
                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="faqOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Our Technical Office address: 8/34-B, Eastern Plaza Commercial Complex, Sonargaon Road, Dhaka, Bangladesh.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        Can I pick product from your office?
                    </button>
                </h2>
                <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="faqTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Currently, we provide home delivery for most areas, but pickup from office can be arranged by prior appointment.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Do you provide home delivery?
                    </button>
                </h2>
                <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="faqThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        Yes, we deliver almost everywhere in Bangladesh. You can choose home delivery or cash-on-delivery.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Can I check the product before buying?
                    </button>
                </h2>
                <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="faqFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        In most areas, yes! Our delivery agent allows you to check the product before payment.
                    </div>
                </div>
            </div>
            <div class="accordion-item">
                <h2 class="accordion-header" id="faqFive">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                        How do you confirm order?
                    </button>
                </h2>
                <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="faqFive" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                        After receiving your order, our system and customer service team will confirm via phone or email.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->
    <div class="contact-form-section mb-5">
        <h3 class="fw-semibold mb-4 text-center" style="color: #cd4b57;">Send Us a Message</h3>
        <form action="" method="POST" class="p-4 p-md-5 shadow-sm rounded-3 bg-light">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Your Name</label>
                <input type="text" class="form-control" id="name" name="name" required placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Your Email</label>
                <input type="email" class="form-control" id="email" name="email" required placeholder="Enter your email">
            </div>
            <div class="mb-3">
                <label for="subject" class="form-label">Subject</label>
                <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject of your message">
            </div>
            <div class="mb-3">
                <label for="message" class="form-label">Message</label>
                <textarea class="form-control" rows="5" id="message" name="message" required placeholder="Type your message here..."></textarea>
            </div>
            <div class="text-center">
                <button type="submit" class="btn" style="background-color: #cd4b57; color: #fff;">Send Message</button>
            </div>
        </form>
    </div>

</div>

<style>
.contact-card {
    transition: transform 0.2s ease, box-shadow 0.2s ease;
}
.contact-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* FAQ Accordion Styling */
.accordion-button {
    color: #cd4b57;
    font-weight: 600;
}
.accordion-button:not(.collapsed) {
    background-color: #f8f1f2;
    color: #cd4b57;
}
.accordion-body {
    color: #555;
}

/* Contact Form Styling */
.contact-form-section .form-control:focus {
    border-color: #cd4b57;
    box-shadow: 0 0 5px rgba(205, 75, 87, 0.3);
}
.contact-form-section button:hover {
    background-color: #a83644;
}

/* Responsive */
@media (max-width: 767px) {
    .contact-card {
        margin-bottom: 20px;
    }
}
</style>

@endsection
