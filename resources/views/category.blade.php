@extends('layouts.app')

@section('content')
<section class="py-2 mb-5 pb-5" style="background-color: #fff;">
    <div class="container">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-lg-3 mb-4 category-sidebar">
                <form method="GET" action="{{ route('category.show', $category->slug) }}">
                    <!-- Filter by Brand -->
                    <div class="mb-4 border p-3 rounded shadow-sm bg-white">
                        <h6 class="fw-bold mb-3">FILTER BY BRAND</h6>
                        <select name="brand" class="form-select">
                            <option value="">All Brands</option>
                            @foreach($brands as $brand)
                                <option value="{{ $brand->id }}" {{ request('brand') == $brand->id ? 'selected' : '' }}>
                                    {{ $brand->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Color -->
                    <div class="mb-4 border p-3 rounded shadow-sm bg-white">
                        <h6 class="fw-bold mb-3">FILTER BY COLOR</h6>
                        <select name="color" class="form-select">
                            <option value="">Any Color</option>
                            @foreach($colors as $color)
                                <option value="{{ $color->id }}" {{ request('color') == $color->id ? 'selected' : '' }}>
                                    {{ ucfirst($color->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Filter by Price -->
                    <div class="mb-4 border p-3 rounded shadow-sm bg-white" style="color:#cd4b57">
                        <h6 class="fw-bold mb-3">FILTER BY PRICE</h6>
                        <input type="range" name="min_price" class="form-range" min="0" max="15000" value="{{ request('min_price', 0) }}">
                        <input type="range" name="max_price" class="form-range" min="0" max="15000" value="{{ request('max_price', 15000) }}">
                        <div class="d-flex justify-content-between small text-muted">
                            <span>৳{{ request('min_price', 0) }}</span>
                            <span>৳{{ request('max_price', 15000) }}</span>
                        </div>
                        <button type="submit" class="btn btn-danger w-100 mt-2 btn-sm">Apply Filter</button>
                    </div>
                </form>
            </div>

            <!-- Overlay for Mobile Sidebar -->
            <div class="sidebar-overlay"></div>

            <!-- Product Section -->
            <div class="col-lg-9">
                <!-- Mobile Filter + Sort -->
                <div class="d-flex justify-content-between align-items-center mb-3 d-lg-none">
                    <button type="button" class="btn btn-outline-danger btn-sm filter-toggle-btn">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <form method="GET" action="{{ route('category.show', $category->slug) }}">
                        <select name="sort" class="form-select form-select-sm" onchange="this.form.submit()">
                            <option value="">Sort</option>
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                            <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Low → High</option>
                            <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>High → Low</option>
                        </select>
                    </form>
                </div>

                <!-- Header (Desktop only) -->
                <div class="d-none d-lg-flex flex-wrap justify-content-between align-items-center mb-4">
                    <!-- Show -->
                    <div class="d-flex align-items-center gap-2 mb-2 show-count">
                        <span class="text-muted small">Show:</span>
                        <form method="GET" action="{{ route('category.show', $category->slug) }}">
                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                            <input type="hidden" name="color" value="{{ request('color') }}">
                            <input type="hidden" name="sort" value="{{ request('sort') }}">
                            <select name="show" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="9" {{ request('show') == 9 ? 'selected' : '' }}>9</option>
                                <option value="12" {{ request('show') == 12 ? 'selected' : '' }}>12</option>
                                <option value="24" {{ request('show') == 24 ? 'selected' : '' }}>24</option>
                            </select>
                        </form>
                    </div>

                    <!-- Grid Toggle -->
                    <div class="d-flex align-items-center gap-2 mb-2 grid-toggle-group">
                        <button class="btn btn-outline-secondary btn-sm grid-toggle" data-cols="2" title="2 Grid"><i class="bi bi-grid"></i></button>
                        <button class="btn btn-outline-secondary btn-sm grid-toggle" data-cols="3" title="3 Grid"><i class="bi bi-grid-3x3-gap"></i></button>
                        <button class="btn btn-outline-secondary btn-sm grid-toggle active" data-cols="4" title="4 Grid"><i class="bi bi-grid-fill"></i></button>
                    </div>

                    <!-- Sort -->
                    <div class="d-flex align-items-center gap-2 mb-2 sort-section">
                        <span class="text-muted small">Sort by:</span>
                        <form method="GET" action="{{ route('category.show', $category->slug) }}">
                            <input type="hidden" name="brand" value="{{ request('brand') }}">
                            <input type="hidden" name="color" value="{{ request('color') }}">
                            <input type="hidden" name="show" value="{{ request('show') }}">
                            <select name="sort" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
                                <option value="">Default</option>
                                <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest</option>
                                <option value="low_high" {{ request('sort') == 'low_high' ? 'selected' : '' }}>Low → High</option>
                                <option value="high_low" {{ request('sort') == 'high_low' ? 'selected' : '' }}>High → Low</option>
                            </select>
                        </form>
                    </div>
                </div>

                <!-- Product Grid -->
                <div id="productGrid" class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-2">
                    @forelse($products as $product)
                        <div class="col">
                            <div class="product-card border rounded bg-white shadow-sm p-1 text-center h-100 d-flex flex-column justify-content-between">
                                <a href="{{ route('product.details', $product->id) }}">
                                    <img src="{{ $product->mainImage ? asset('public/storage/' . $product->mainImage->image_path) : asset('public/assets/images/placeholder.png') }}"
                                        alt="{{ $product->name }}"
                                        class="img-fluid mb-3 mx-auto"
                                        style="height:200px; object-fit:cover; border-radius:8px;">
                                </a>
                                <div>
                                    <h6 class="fw-semibold small mb-1 product-name">{{ $product->name }}</h6>
                                    <p class="small mb-1">
                                        @if($product->discount_price)
                                            <span class="text-muted text-decoration-line-through">৳{{ $product->price }}</span><br>
                                            <span class="fw-bold" style="color: #cd4b57">৳{{ $product->discount_price }}</span>
                                        @else
                                            <span class="fw-bold " style="color: #cd4b57">৳{{ $product->price }}</span>
                                        @endif
                                    </p>
                                  
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12 text-center">
                            <p class="text-muted" >No products found for this category.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $products->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.product-card {
    transition: all 0.3s ease;
    cursor: pointer;
}
.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
}
.product-card h6.product-name {
    min-height: 38px;
    line-height: 1.3;
    overflow: hidden;
    text-overflow: ellipsis;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}
.grid-toggle i {
    font-size: 1.2rem;
}
.grid-toggle.active {
    background-color: #cd4b57;
    color: #fff;
    border-color: #cd4b57;
}
.grid-toggle:hover {
    color: #cd4b57;
    border-color: #cd4b57;
}

/* ✅ Desktop layout ঠিক রাখা */
.category-sidebar {
    position: static !important; /* Fixed করা বন্ধ */
    display: block;
    height: auto;
    background: transparent;
    box-shadow: none;
}

/* ✅ Sidebar overlay hidden by default */
.sidebar-overlay {
    display: none;
}

/* ✅ Mobile responsive design */
@media (max-width: 992px) {
    .category-sidebar {
        display: none;
        position: fixed !important;
        top: 0;
        left: 0;
        width: 80%;
        height: 100vh;
        background-color: #fff;
        z-index: 1050;
        overflow-y: auto;
        padding: 20px;
        box-shadow: 2px 0 10px rgba(0,0,0,0.2);
        transform: translateX(-100%);
        transition: transform 0.3s ease;
    }
    .category-sidebar.active {
        display: block;
        transform: translateX(0);
    }
    .sidebar-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
    }
    .sidebar-overlay.active {
        display: block;
    }

    /* Hide desktop-only filters */
    .grid-toggle-group,
    .show-count,
    .sort-section {
        display: none !important;
    }
    .product-card img {
        height: 160px !important;
        border-radius: 6px;
    }
}
</style>


<script>
document.addEventListener("DOMContentLoaded", function () {
    const gridButtons = document.querySelectorAll(".grid-toggle");
    const gridContainer = document.getElementById("productGrid");
    const filterBtn = document.querySelector(".filter-toggle-btn");
    const sidebar = document.querySelector(".category-sidebar");
    const overlay = document.querySelector(".sidebar-overlay");

    // Grid toggle (Desktop)
    gridButtons.forEach(button => {
        button.addEventListener("click", () => {
            gridButtons.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");
            const cols = button.getAttribute("data-cols");
            gridContainer.className = `row row-cols-${cols} g-3`;
        });
    });

    // Sidebar toggle (Mobile)
    filterBtn?.addEventListener("click", () => {
        sidebar.classList.toggle("active");
        overlay.classList.toggle("active");
        document.body.style.overflow = sidebar.classList.contains("active") ? 'hidden' : '';
    });

    overlay?.addEventListener("click", () => {
        sidebar.classList.remove("active");
        overlay.classList.remove("active");
        document.body.style.overflow = '';
    });
});
</script>
@endsection
