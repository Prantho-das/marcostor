<!-- Shopping Cart Sidebar -->
<div id="cartSidebar" class="cart-sidebar">
    <div class="cart-header d-flex justify-content-between align-items-center border-bottom px-3 py-2">
        <h5 class="mb-0 fw-semibold">Shopping Cart</h5>
        <button class="btn btn-sm btn-outline-secondary" id="closeCart">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <div class="cart-body p-3">
        <!-- Example Product Item -->
        <div class="cart-item d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
            <div class="d-flex align-items-center gap-2">
                <img src="{{ asset('public/assets/images/placeholder.png') }}" alt="Product"
                     class="rounded border" style="width:60px; height:60px; object-fit:contain;">
                <div>
                    <h6 class="mb-0 fw-semibold small">Sample Product Name</h6>
                    <div class="text-muted small">৳1200</div>
                </div>
            </div>
            <button class="btn btn-sm btn-outline-danger p-1">
                <i class="bi bi-x"></i>
            </button>
        </div>

        <!-- Repeat above block for more products -->
    </div>

    <div class="cart-footer border-top p-3 bg-light">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="fw-semibold">Subtotal:</span>
            <span class="fw-bold text-primary" style="color: #cd4b57">৳2400</span>
        </div>
        <div class="d-grid gap-2">
            <button class="btn btn-outline-dark" onclick="window.location.href='{{ route('cart.index') }}'">View Cart</button>

            <a href="{{ route('checkout.index') }}" class="btn btn-danger">
                Proceed to Checkout
            </a>
        </div>
    </div>
</div>

<!-- Overlay -->
<div id="cartOverlay" class="cart-overlay"></div>

<!-- Styles -->
<style>
.cart-sidebar {
    position: fixed;
    top: 0;
    right: -400px;
    width: 380px;
    height: 100%;
    background: #fff;
    box-shadow: -2px 0 8px rgba(0,0,0,0.1);
    z-index: 1050;
    display: flex;
    flex-direction: column;
    transition: right 0.3s ease-in-out;
}
.cart-sidebar.active {
    right: 0;
}

.cart-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0,0,0,0.4);
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease-in-out;
    z-index: 1049;
}
.cart-overlay.active {
    opacity: 1;
    visibility: visible;
}

.cart-body {
    flex: 1;
    overflow-y: auto;
}
.cart-body::-webkit-scrollbar {
    width: 6px;
}
.cart-body::-webkit-scrollbar-thumb {
    background: #ccc;
    border-radius: 4px;
}
@media (max-width: 768px) {
    .cart-sidebar {
        width: 100%;
    }
}
</style>

<!-- Bootstrap Icons (if not already included) -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<!-- Script -->
<script>
function openCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');

    if (sidebar && overlay) {
        sidebar.classList.add('active');
        overlay.classList.add('active');
        document.body.style.overflow = 'hidden'; // optional UX lock scroll
    }
}

function closeCartSidebar() {
    const sidebar = document.getElementById('cartSidebar');
    const overlay = document.getElementById('cartOverlay');

    if (sidebar && overlay) {
        sidebar.classList.remove('active');
        overlay.classList.remove('active');
        document.body.style.overflow = '';
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const openCartBtn = document.getElementById('openCart');
    const closeCartBtn = document.getElementById('closeCart');
    const cartOverlay = document.getElementById('cartOverlay');

    if (openCartBtn) openCartBtn.addEventListener('click', openCartSidebar);
    if (closeCartBtn) closeCartBtn.addEventListener('click', closeCartSidebar);
    if (cartOverlay) cartOverlay.addEventListener('click', closeCartSidebar);
});

// 🔥 Cart Sidebar Load Function
function loadCartSidebar() {
    fetch("{{ route('cart.fetch') }}", {
        method: 'GET',
        credentials: 'same-origin',
    })
    .then(res => res.json())
    .then(data => {
        const cartBody = document.querySelector('#cartSidebar .cart-body');
        const cartFooter = document.querySelector('#cartSidebar .cart-footer');

        if (!data.items.length) {
            cartBody.innerHTML = `<div class="text-center text-muted py-5">Your cart is empty</div>`;
            cartFooter.style.display = 'none';
            return;
        }

        cartFooter.style.display = 'block';

        let html = '';
        data.items.forEach(item => {
            html += `
                <div class="cart-item d-flex align-items-center justify-content-between mb-3 border-bottom pb-2">
                    <div class="d-flex align-items-center gap-2">
                        <img src="${item.image}" alt="${item.name}"
                             class="rounded border" style="width:60px; height:60px; object-fit:contain;">
                        <div>
                            <h6 class="mb-0 fw-semibold small">${item.name}</h6>
                            <div class="text-muted small">৳${item.price} × ${item.quantity}</div>
                        </div>
                    </div>
                    <button class="btn btn-sm btn-outline-danger p-1" onclick="removeCartItem(${item.id})">
                        <i class="bi bi-x"></i>
                    </button>
                </div>`;
        });

        cartBody.innerHTML = html;

        cartFooter.querySelector('span.text-primary').textContent = '৳' + data.subtotal;
    })
    .catch(() => {
        console.error('Cart fetch failed');
    });
}

// Remove single item
function removeCartItem(id) {
    fetch("{{ route('cart.remove') }}", {
        method: 'POST',
        credentials: 'same-origin',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: id })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) loadCartSidebar();
    });
}


</script>

