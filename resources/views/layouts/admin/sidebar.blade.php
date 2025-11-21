<div class="sidebar bg-white shadow-sm" id="sidebar" style="width:250px; min-height:100vh;">
    <div class="text-center py-4 border-bottom">
        <h4 class="text-primary fw-bold mb-0">🛍️ MyShop</h4>
        <small class="text-muted">Admin Panel</small>
    </div>

    <a href="{{ route('admin.dashboard') }}" class="d-block px-4 py-2 text-decoration-none text-dark mt-3 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <i class="bi bi-house me-2"></i> Dashboard
    </a>

    <a href="{{ route('admin.products.index') }}" class="d-block px-4 py-2 text-decoration-none text-dark {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
        <i class="bi bi-box-seam me-2"></i> Products
    </a>

    <a href="{{ route('admin.categories.index') }}" class="d-block px-4 py-2 text-decoration-none text-dark {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
        <i class="bi bi-tags me-2"></i> Categories
    </a>

        {{-- ✅ New Brand Menu --}}
    <a href="{{ route('admin.brands.index') }}"
       class="d-block px-4 py-2 text-decoration-none text-dark {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
        <i class="bi bi-award me-2"></i> Brands
    </a>

    <a href="{{ route('admin.colors.index') }}"
      class="d-block px-4 py-2 text-decoration-none text-dark {{ request()->routeIs('admin.colors.*') ? 'active' : '' }}">
        <i class="bi bi-palette me-2"></i> Colors
    </a>
    
    
    <a href="{{ route('admin.orders.index') }}" class="d-block px-4 py-2 text-decoration-none text-dark">
        <i class="bi bi-cart-check me-2"></i> Orders
    </a>


    <a href="#" class="d-block px-4 py-2 text-decoration-none text-dark">
        <i class="bi bi-people me-2"></i> Customers
    </a>

    <a href="{{ route('admin.settings.index') }}" 
       class="d-block px-4 py-2 text-decoration-none text-dark {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
        <i class="bi bi-gear me-2"></i> Settings
    </a>

    <hr>

    <form action="{{ route('logout') }}" method="POST" class="px-3 mb-4">
        @csrf
        <button type="submit" class="btn btn-danger w-100">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
        </button>
    </form>
</div>
