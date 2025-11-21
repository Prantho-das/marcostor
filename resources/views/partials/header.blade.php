<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark py-2 shadow-sm">
    <div class="container">

        <!-- Left: Logo -->
        <a class="navbar-brand d-flex align-items-center" href="{{ url('/') }}">
            <img src="{{ asset('public/assets/images/marco_logo_bg.png') }}" alt="Logo" width="80" height="45" class="me-2">
        </a>

        <!-- Center: Search Field -->
        <form class="d-none d-lg-flex mx-auto w-50" role="search">
            <input class="form-control rounded-start-pill" type="search" placeholder="Search..." aria-label="Search">
            <button class="btn  rounded-end-pill" type="submit" style="background-color:#cd4b57"><i class="fas fa-search"></i></button>
        </form>

         <!-- Right: Icons + User -->
        <div class="d-flex align-items-center">


            <!-- User Dropdown -->
            @guest
            <a class="nav-link text-light me-2" href="{{ route('login') }}"><i
                    class="fa-solid fa-right-to-bracket me-1"></i>Login</a>
            <a class="nav-link text-light" href="{{ route('register') }}"><i
                    class="fa-solid fa-user-plus me-1"></i>Register</a>
            @else
            <div class="dropdown">
                <a href="#"
                    class="d-flex align-items-center text-light text-decoration-none dropdown-toggle" id="userDropdown"
                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fa-regular fa-circle-user fa-lg me-2"></i>
                    <span>{{ Auth::user()->name }}</span>
                </a>

                <ul class="dropdown-menu dropdown-menu-end shadow fade" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#"><i
                                class="fa-solid fa-gauge me-2 text-primary"></i>Dashboard</a></li>
                    <li><a class="dropdown-item" href="#"><i
                                class="fa-solid fa-box me-2 text-success"></i>Orders</a></li>
                    <li><a class="dropdown-item" href="#"><i
                                class="fa-solid fa-location-dot me-2 text-warning"></i>Addresses</a></li>
                    <li><a class="dropdown-item" href="#"><i
                                class="fa-solid fa-user-gear me-2 text-info"></i>Account Details</a></li>
                    <li><a class="dropdown-item" href="#"><i
                                class="fa-solid fa-heart me-2 text-danger"></i>Wishlist</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="m-0">@csrf
                            <button type="submit" class="dropdown-item text-danger"><i
                                    class="fa-solid fa-right-from-bracket me-2"></i>Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
            @endguest

            <!-- Wishlist Icon -->
            <div class="position-relative me-3 d-none d-lg-block">
                <i class="fas fa-heart fa-lg text-light"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">3</span>
            </div>

            <!-- Cart Icon -->
            <a href="{{ route('cart.index') }}" class="position-relative me-3 d-none d-lg-block text-decoration-none">
                <i class="fas fa-shopping-cart fa-lg text-light"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                     {{ $cartCount ?? 0 }}
                </span>
            </a>




            <!-- Mobile Toggle -->
            <button class="navbar-toggler ms-3 d-lg-none" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>
    </div>

    <!-- Mobile Search (below navbar) -->
    <div class="container-fluid d-lg-none bg-dark pb-2 px-3">
        <form class="d-flex mt-2 w-100" role="search">
            <input class="form-control me-2 rounded-start-pill" type="search" placeholder="Search..."
                aria-label="Search">
            <button class="btn  rounded-end-pill" type="submit" style="background-color:#cd4b57"><i class="fas fa-search"></i></button>
        </form>
    </div>
</nav>

<!-- Sidebar (Mobile Menu) -->
<div class="offcanvas offcanvas-end text-bg-dark py-5 mb-5" tabindex="-1" id="sidebar">
    <div class="offcanvas-header border-bottom border-secondary">
        <h5 class="offcanvas-title">Menu</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body">

   @include('partials.sidebar-categories')
        @guest
      
            <div class="d-grid gap-2 mb-3">
                <a href="{{ route('login') }}" class="btn btn-outline-light"><i class="fa-solid fa-right-to-bracket me-1"></i>Login</a>
                <a href="{{ route('register') }}" class="btn btn-primary"><i class="fa-solid fa-user-plus me-1"></i>Register</a>
            </div>
        @else
            <div class="list-group mb-3">

                <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-0">
                    <i class="fa-solid fa-user-gear me-2 text-info"></i>Account Details
                </a>
                <a href="#" class="list-group-item list-group-item-action bg-dark text-light border-0">
                    <i class="fa-solid fa-heart me-2 text-danger"></i>Wishlist
                </a>
               
                <form action="{{ route('logout') }}" method="POST" class="mt-2">@csrf
                    <button class="btn btn-danger w-100">
                        <i class="fa-solid fa-right-from-bracket me-2"></i>Logout
                    </button>
                </form>
            </div>
        @endguest


    </div>
</div>


<!-- Custom CSS -->
<style>
/* Dropdown Hover Animation (Desktop only) */
.dropdown:hover .dropdown-menu {
    display: block;
    margin-top: 0.5rem;
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
}

.dropdown-menu {
    display: none;
    opacity: 0;
    visibility: hidden;
    transform: translateY(10px);
    transition: all 0.25s ease;
}

.dropdown-menu.fade.show {
    opacity: 1;
    transform: translateY(0);
    visibility: visible;
}

.dropdown-item i {
    width: 18px;
}

/* Navbar balancing */
.navbar-brand img {
    transition: 0.3s ease;
}

.navbar-brand img:hover {
    transform: scale(1.03);
}

/* Navbar right section spacing */
.navbar .d-flex.align-items-center > *:not(:last-child) {
  margin-right: 1rem !important; /* 16px space between each item */
}

/* Slightly more breathing space for icons */
.navbar .fa-heart,
.navbar .fa-shopping-cart,
.navbar .fa-circle-user {
  padding: 0 4px;
}


/* Mobile Adjustments */
@media (max-width: 991px) {
    .navbar {
        padding: 0.5rem 1rem;
        flex-direction: column;
    }

    .navbar .form-control,
    .navbar .btn {
        flex: 1 1 auto;
    }

    /* Hide user info & auth buttons on mobile */
    .navbar .nav-link.text-light,
    .navbar .dropdown {
        display: none !important;
    }

    .dropdown:hover .dropdown-menu {
        display: none;
        /* disable hover on mobile */
    }

    .navbar-brand img {
        width: 80px;
        height: auto;
    }
}
</style>