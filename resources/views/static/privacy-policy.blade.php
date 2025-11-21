@extends('layouts.app')

@section('title', 'Privacy Policy | Marco')

@section('content')
<div class="container py-5">

    <!-- Page Header -->
    <div class="text-center mb-5">
        <h2 class="fw-bold text-uppercase">Privacy <span class="text-primary">Policy</span></h2>
        <p class="text-muted">How Marco respects and protects your personal information</p>
    </div>

    <!-- Introduction -->
    <section class="mb-4">
        <p class="text-muted">
            Welcome to <strong>Marco</strong>, your trusted online gadgets & accessories store in Bangladesh. 
            Your privacy matters to us. This Privacy Policy explains how we collect, store, use, and protect 
            your personal information when you visit our website or make a purchase. By using our site, you 
            consent to the practices described here.
        </p>
    </section>

    <!-- Data Collection -->
    <section class="mb-4 bg-light p-4 rounded shadow-sm">
        <h4 class="fw-semibold mb-3">What Personal Data We Collect</h4>
        <p class="text-muted">
            To process your orders and provide services, we may collect information such as your name, 
            email, postal address, phone number, payment details, and delivery address. We only collect 
            data necessary for providing our services and for fulfilling your orders.
        </p>
        <p class="text-muted">
            When you browse our website, we may also collect non-personal information such as IP addresses, 
            browser type, and device details to improve our services and user experience.
        </p>
    </section>

    <!-- Use of Information -->
    <section class="mb-4">
        <h4 class="fw-semibold mb-3">How We Use Your Information</h4>
        <ul class="text-muted">
            <li>Process and fulfill your orders securely.</li>
            <li>Provide customer support and answer your inquiries.</li>
            <li>Improve our website layout, content, and services.</li>
            <li>Send notifications about orders, updates, and promotions if you have opted in.</li>
            <li>Analyze trends and gather insights for better service.</li>
        </ul>
    </section>

    <!-- Third Party Sharing -->
    <section class="mb-4 bg-light p-4 rounded shadow-sm">
        <h4 class="fw-semibold mb-3">Third Party Sharing</h4>
        <p class="text-muted">
            We may share your data with trusted third-party service providers such as couriers or payment 
            gateways strictly for the purpose of fulfilling orders. These providers are contractually bound 
            to keep your information confidential and secure.
        </p>
    </section>

    <!-- Cookies & Analytics -->
    <section class="mb-4">
        <h4 class="fw-semibold mb-3">Cookies and Analytics</h4>
        <p class="text-muted">
            Marco uses cookies and analytics tools to enhance your browsing experience. Cookies help us 
            remember your preferences, improve navigation, and analyze site traffic. You may disable cookies 
            in your browser, but some features of the site may not function properly.
        </p>
    </section>

    <!-- Security Measures -->
    <section class="mb-4 bg-light p-4 rounded shadow-sm">
        <h4 class="fw-semibold mb-3">How We Protect Your Information</h4>
        <p class="text-muted">
            We implement strict industry-standard measures such as SSL encryption and secure storage 
            protocols to protect your personal data from unauthorized access or misuse. While no system 
            is 100% secure, we strive to maintain the highest standards.
        </p>
    </section>

    <!-- User Rights -->
    <section class="mb-4">
        <h4 class="fw-semibold mb-3">Your Rights</h4>
        <p class="text-muted">
            You have the right to access, update, or request deletion of your personal information at any time. 
            You may also opt out of marketing communications or contact us for assistance with your data.
        </p>
    </section>

    <!-- Contact Info -->
    <section class="contact-info py-4 text-center border-top">
        <h4 class="fw-semibold mb-3">Contact Us</h4>
        <p class="text-muted mb-1">📍 Technical Office: 8/34-B, Eastern Plaza, Sonargaon Road, Dhaka-1205</p>
        <p class="text-muted mb-1">📞 Hotline: <a href="tel:+8801757672906" class="text-decoration-none text-dark">01757-672906</a></p>
        <p class="text-muted mb-1">💬 WhatsApp: <a href="https://wa.me/8801757672906" class="text-decoration-none text-dark">+8801757-672906</a></p>
        <p class="text-muted mb-1">📧 Email: <a href="mailto:support@marco.com" class="text-decoration-none text-dark">support@marco.com</a></p>
    </section>

</div>

<style>
    /* Section hover effect */
    section {
        transition: transform 0.2s ease;
    }
    section:hover {
        transform: translateY(-3px);
    }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        section {
            padding: 20px 15px !important;
        }
    }

    /* Link hover effect */
    a.text-dark:hover {
        text-decoration: underline;
        color: #cd4b57;
    }
</style>
@endsection
