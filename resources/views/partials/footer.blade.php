<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<!-- ======= FOOTER START ======= -->
<footer class="footer-desktop text-center text-md-start bg-light border-top mt-5 pt-5">
  <div class="container">
    <div class="row gy-4">
      <!-- Brand & About -->
      <div class="col-md-3">
        <h5 class="fw-bold mb-3">Marco</h5>
        <p class="text-secondary small">
          Marco is your trusted destination for premium quality products and top-notch shopping experience.
        </p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-secondary fs-5"><i class="fab fa-facebook"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="fab fa-twitter"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="fab fa-instagram"></i></a>
          <a href="#" class="text-secondary fs-5"><i class="fab fa-linkedin"></i></a>
        </div>
      </div>

      <!-- Customer Care -->
      <div class="col-md-3">
        <h6 class="fw-bold mb-3">Customer Care</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">FAQ</a></li>
          <li><a href="#" class="footer-link">Reviews</a></li>
          <li><a href="#" class="footer-link">Feedback</a></li>
          <li><a href="{{ route('contact') }}" class="footer-link">Contact Us</a></li>
        </ul>
      </div>

      <!-- Information -->
      <div class="col-md-3">
        <h6 class="fw-bold mb-3">Information</h6>
        <ul class="list-unstyled">
          <li><a href="#" class="footer-link">EMI Facility</a></li>
          <li><a href="#" class="footer-link">Payment Guides</a></li>
          <li><a href="#" class="footer-link">Returns & Refund</a></li>
          <li><a href="#" class="footer-link">Shipping Policy</a></li>
        </ul>
      </div>

      <!-- Legal -->
      <div class="col-md-3">
        <h6 class="fw-bold mb-3">Legal</h6>
        <ul class="list-unstyled">
          <li><a href="{{ route('terms.conditions') }}" class="footer-link">Terms & Conditions</a></li>
          <li><a href="{{ route('privacy.policy') }}" class="footer-link">Privacy Policy</a></li>
          <li><a href="{{ route('about') }}" class="footer-link">About Us</a></li>
        </ul>
      </div>
    </div>

    <hr class="my-4">

    <div class="row align-items-center">
      <div class="col-md-6 text-secondary small">
        &copy; {{ date('Y') }} Marco. All rights reserved.
      </div>
      <div class="col-md-6 text-md-end mt-2 mt-md-0">
        <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" height="25" class="me-2 opacity-75">
        <!-- <img src="https://upload.wikimedia.org/wikipedia/commons/5/5e/MasterCard_Logo.svg" alt="Mastercard" height="25" class="me-2 opacity-75"> -->
        <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" height="25" class="opacity-75">
      </div>
    </div>
  </div>
</footer>

<!-- ======= MOBILE BOTTOM NAV START ======= -->
<div class="footer-mobile d-lg-none">
  <nav class="mobile-nav">
    <a href="#" class="nav-item">
      <i class="fa-solid fa-magnifying-glass"></i>
      <span>Search</span>
    </a>
      <a href="{{ route('cart.index') }}" class="nav-item position-relative">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>Cart</span>

        @if(isset($cartCount) && $cartCount > 0)
          <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                style="font-size: 0.65rem; padding: 3px 6px; transform: translate(-35%, -25%);">
            {{ $cartCount }}
          </span>
        @endif
      </a>


    <a href="{{ url('/') }}" class="nav-item home-btn">
      <div class="home-icon">
        <i class="fa-solid fa-house"></i>
      </div>
    </a>
    <a href="#" class="nav-item">
      <i class="fa-regular fa-user"></i>
      <span>Account</span>
    </a>
    <a href="https://wa.me/8801754826927?text=Hello%20Marco%2C%20I%20need%20some%20help%20with%20my%20order."
   target="_blank" 
   class="nav-item">
  <i class="fa-solid fa-circle-question"></i>
  <span>Help</span>
</a>

  </nav>
</div>

<!-- ======= FOOTER CSS ======= -->
<style>
  /* -------- Desktop Footer -------- */
  .footer-desktop {
    font-size: 0.95rem;
    color: #555;
  }

  .footer-desktop h5, 
  .footer-desktop h6 {
    color: #000;
  }

  .footer-link {
    color: #6c757d;
    text-decoration: none;
    display: block;
    margin-bottom: 6px;
    transition: color 0.2s ease;
  }

  .footer-link:hover {
    color: #0d6efd;
  }

  .footer-desktop .fa-brands:hover {
    color: #0d6efd;
  }

  .footer-desktop hr {
    border-color: #ddd;
  }

  /* -------- Mobile Footer Navigation -------- */
  .footer-mobile {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    border-top: 1px solid #ddd;
    z-index: 1050;
    box-shadow: 0 -1px 8px rgba(0, 0, 0, 0.1);
  }

  .mobile-nav {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 6px 0 4px;
  }

  .mobile-nav .nav-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    color: #6c757d;
    text-decoration: none;
    font-size: 0.8rem;
    transition: all 0.2s ease;
  }

  .mobile-nav .nav-item i {
    font-size: 1.3rem;
    margin-bottom: 2px;
  }

  .mobile-nav .nav-item:hover,
  .mobile-nav .nav-item.active {
    color: #0d6efd;
  }

  /* Home Icon Special Styling */
  .mobile-nav .home-btn {
    position: relative;
    top: -18px;
  }

  .home-icon {
    background: #0d6efd;
    color: #fff;
    width: 58px;
    height: 58px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 3px 8px rgba(13, 110, 253, 0.3);
    transition: transform 0.2s ease;
  }

  .home-icon i {
    font-size: 1.6rem;
  }

  .home-icon:hover {
    transform: scale(1.05);
  }

  /* Hide desktop footer on mobile */
  @media (max-width: 991px) {
    .footer-desktop {
      display: none;
    }
  }

  /* Hide mobile footer on desktop */
  @media (min-width: 992px) {
    .footer-mobile {
      display: none;
    }
  }
</style>
