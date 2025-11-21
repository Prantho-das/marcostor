@extends('layouts.app')

@section('title', 'Terms & Conditions')

@section('content')
<style>
    .terms-container {
        max-width: 1000px;
        margin: 50px auto;
        background: #fff;
        padding: 10px;
        border-radius: 15px;
       
        font-family: "Poppins", sans-serif;
        line-height: 1.8;
        color: #333;
        transition: all 0.3s ease-in-out;
    }
    .terms-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.15);
    }
    .terms-title {
        font-size: 2rem;
        font-weight: 700;
        color: #e63946;
        margin-bottom: 20px;
        text-align: center;
        text-transform: uppercase;
        border-bottom: 2px solid #e63946;
        display: inline-block;
        padding-bottom: 5px;
    }
    .terms-section {
        margin-top: 30px;
    }
    .terms-section h4 {
        color: #111;
        font-weight: 600;
        margin-bottom: 10px;
        position: relative;
    }
    .terms-section h4::before {
        content: "◆";
        color: #e63946;
        margin-right: 8px;
    }
    .terms-section p {
        text-align: justify;
    }
    .terms-updated {
        text-align: center;
        font-size: 14px;
        margin-top: 40px;
        color: #777;
    }
</style>

<div class="container">
    <div class="terms-container">
        <h2 class="terms-title">Terms & Conditions</h2>
        <p>
            This website is operated by <strong>Gadstyle BD</strong> (Registered name of gadstyle.com). Throughout the site, the terms “we”, “us” and “our” refer to gadstyle.com or GadStyle BD.
            By visiting our site and/or purchasing something from us, you engage in our “Services” and agree to be bound by the following Terms of Service. Please read these Terms carefully before using our website.
        </p>

        <div class="terms-section">
            <h4>1. General Conditions</h4>
            <p>
                By agreeing to these Terms, you represent that you are of the age of majority in your province or country of residence.
                You may not use our products for any illegal or unauthorized purpose nor violate any laws in your jurisdiction. 
                Transmission of any destructive code, viruses, or worms is strictly prohibited. Violation of any of these Terms may result in immediate termination of your Services.
                We reserve the right to refuse service to anyone for any reason at any time.
            </p>
        </div>

        <div class="terms-section">
            <h4>2. Pricing</h4>
            <p>
                Prices for our products are subject to change without notice. We reserve the right to modify or discontinue any product or service at any time without liability.
                Due to unstable USD exchange rates, prices may fluctuate. If a product becomes unavailable or cannot be provided, we reserve the right to cancel the order without notice.
            </p>
        </div>

        <div class="terms-section">
            <h4>3. Products</h4>
            <p>
                Products are available exclusively online through the website. They may have limited quantities and are subject to return only according to our Return Policy.
                While we strive to display accurate colors and product details, we cannot guarantee that your monitor will accurately represent product colors.
                Gadstyle reserves the right to cancel or refund any order in cases of product unavailability, quality issues, or authenticity disputes.
            </p>
        </div>

        <div class="terms-section">
            <h4>4. Accuracy of Billing and Account Information</h4>
            <p>
                We reserve the right to refuse any order you place with us. Orders may be limited or canceled per person, per household, or per order basis.
                You must provide accurate and up-to-date purchase and account information, including a valid phone number and email address.
                Each customer must maintain one unique account; duplicate accounts using the same contact details are prohibited.
            </p>
        </div>

        <div class="terms-section">
            <h4>5. Discounts & Allowances</h4>
            <p>
                Discounts and promotional codes are one-time offers and may not be reused.  
                Coupons, gift cards, or referral codes cannot be refunded or reused once applied to an order.  
                Gadstyle reserves the right to cancel any promotional offer or discount at any time without prior notice.
            </p>
        </div>

        <div class="terms-section">
            <h4>6. Third Party Links</h4>
            <p>
                Our website may include links to third-party sites not operated by us.  
                We are not responsible for examining or evaluating their content and will not be liable for any damages arising from their products, services, or content.
                Users should review third-party policies carefully before making any transaction through external sites.
            </p>
        </div>

        <div class="terms-section">
            <h4>7. Personal Information</h4>
            <p>
                Your submission of personal information through our store is governed by our <a href="{{ route('privacy.policy') }}">Privacy Policy</a>.
            </p>
        </div>

        <div class="terms-section">
            <h4>8. Errors, Inaccuracies, and Omissions</h4>
            <p>
                Occasionally, there may be information on our site that contains typographical errors or inaccuracies related to product descriptions, pricing, or promotions.
                We reserve the right to correct any errors, inaccuracies, or omissions and to change or update information without prior notice.
            </p>
        </div>

        <div class="terms-section">
            <h4>9. Order Cancellation</h4>
            <p>
                Gadstyle reserves the right to cancel any order after quality control checks if an issue is detected.
                Orders may also be canceled in cases of product unavailability, stock issues, or customer refusal to pay advance where required.
                For customers outside Dhaka, a 300 BDT advance may be required to confirm orders.
            </p>
        </div>

        <div class="terms-section">
            <h4>10. Prohibited Uses</h4>
            <p>
                Users are prohibited from using the website for any unlawful purpose, including but not limited to:
                spreading malicious software, spamming, violating intellectual property rights, or transmitting misleading information.
                We reserve the right to terminate any account violating these terms.
            </p>
        </div>

        <div class="terms-section">
            <h4>11. Disclaimer of Warranties; Limitation of Liability</h4>
            <p>
                We do not guarantee that your use of our service will be uninterrupted, timely, or error-free.
                The services and all products are provided "as is" and "as available" without any warranty or condition of any kind.
                Gadstyle BD, its affiliates, or partners shall not be liable for any damages resulting from the use or inability to use the service.
            </p>
        </div>

        <div class="terms-section">
            <h4>12. Indemnification</h4>
            <p>
                You agree to indemnify and hold harmless Gadstyle BD, its officers, employees, and partners from any claim or demand arising from your breach of these Terms or violation of any law.
            </p>
        </div>

        <div class="terms-section">
            <h4>13. Severability</h4>
            <p>
                If any provision of these Terms is found to be unlawful or unenforceable, the remaining provisions shall continue to be valid and enforceable.
            </p>
        </div>

        <div class="terms-section">
            <h4>14. Termination</h4>
            <p>
                These Terms remain effective until terminated by either party. Gadstyle BD may terminate your access at any time without notice if you fail to comply with any condition stated herein.
            </p>
        </div>

        <div class="terms-section">
            <h4>15. Governing Law</h4>
            <p>
                These Terms and Conditions shall be governed and construed in accordance with the applicable laws governing eCommerce in Bangladesh.
            </p>
        </div>

        <div class="terms-section">
            <h4>16. Changes to Terms</h4>
            <p>
                We reserve the right to update, modify, or replace any part of these Terms at any time. It is your responsibility to check this page periodically for updates.
                Continued use of our website after any changes constitutes acceptance of the new Terms.
            </p>
        </div>

        <div class="terms-section">
            <h4>Contact Information</h4>
            <p>
                Questions about the Terms of Service should be sent to <a href="mailto:info@gadstyle.com">info@gadstyle.com</a>.
            </p>
        </div>

        <p class="terms-updated">Last Updated: November 2025</p>
    </div>
</div>
@endsection
