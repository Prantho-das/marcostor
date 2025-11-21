@extends('layouts.app')

@section('content')
<section class="pt-5 pb-5 mb-4" style="background-color: #f8f9fa;">
    <div class="container">
        <h4 class="fw-bold mb-4 text-uppercase">Your Shopping Cart</h4>

        @if(count($cartItems) > 0)
        <div class="row g-4">
            <!-- Cart Items -->
            <div class="col-lg-8">
                <div class="table-responsive bg-white shadow-sm rounded">
                    <table class="table align-middle mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="cart-body">
                            @php
                                $subtotal = 0;
                            @endphp

                            @foreach($cartItems as $item)
                                @php
                                    $subtotal += $item['subtotal'];
                                @endphp
                                <tr data-product-id="{{ $item['product_id'] }}">
                                    <td class="d-flex align-items-center">
                                        <img src="{{ $item['image'] }}" class="rounded me-3" width="70" alt="Product">
                                        <div>
                                            <h6 class="fw-semibold mb-0">{{ $item['name'] }}</h6>
                                        </div>
                                    </td>
                                    <td>৳{{ number_format($item['price'], 2) }}</td>
                                    <td>
                                        <div class="input-group input-group-sm" style="max-width: 110px;">
                                            <button class="btn btn-outline-secondary decrease">-</button>
                                            <input type="text" class="form-control text-center quantity-input"
                                                   value="{{ $item['quantity'] }}" readonly>
                                            <button class="btn btn-outline-secondary increase">+</button>
                                        </div>
                                    </td>
                                    <td class="subtotal">৳{{ number_format($item['subtotal'], 2) }}</td>
                                    <td>
                                        <button class="btn btn-link text-danger p-0 remove-item">
                                            <i class="bi bi-x-circle fs-5"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cart Totals -->
            <div class="col-lg-4">
                <div class="bg-white shadow-sm rounded p-4" id="cart-summary">
                    <h5 class="fw-bold mb-4">Cart Totals</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span class="fw-semibold" id="subtotal">৳{{ number_format($subtotal, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Delivery Charge:</span>
                        <span class="fw-semibold" id="delivery">৳120</span>
                    </div>
                    <div class="d-flex justify-content-between border-top pt-2 mt-2">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold fs-5" style="color: #cd4b57" id="total">
                            ৳{{ number_format($subtotal + 120, 2) }}
                        </span>
                    </div>
                   <a href="{{ route('checkout.index') }}" class="btn btn-danger w-100 mt-4 py-2">
                        Proceed To Checkout
                    </a>

                </div>
            </div>
        </div>

        @else
            <div class="text-center bg-white p-5 shadow-sm rounded">
                <img src="{{ asset('public/assets/images/empty-cart.png') }}" alt="Empty Cart" class="mb-3" width="120">
                <h5>Your cart is empty</h5>
                <p class="text-muted">Looks like you haven’t added anything to your cart yet.</p>
                <a href="{{ url('/') }}" class="btn btn-danger mt-3">Continue Shopping</a>
            </div>
        @endif
    </div>
</section>

<style>
.table th {
    font-size: 14px;
    font-weight: 600;
    color: #555;
}
.table td {
    vertical-align: middle;
}
.btn-outline-secondary {
    padding: 0.25rem 0.5rem;
}
@media (max-width: 768px) {
    .table thead {
        display: none;
    }
    .table tbody tr {
        display: block;
        margin-bottom: 1rem;
        background: #fff;
        border-radius: 10px;
        padding: 15px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.05);
    }
    .table td {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border: none !important;
    }
    .table td::before {
        content: attr(data-label);
        font-weight: 600;
        color: #555;
    }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const csrfToken = '{{ csrf_token() }}';

    // quantity increase/decrease
    document.querySelectorAll('.increase, .decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const row = this.closest('tr');
            const productId = row.dataset.productId;
            const qtyInput = row.querySelector('.quantity-input');
            let qty = parseInt(qtyInput.value);

            if (this.classList.contains('increase')) qty++;
            if (this.classList.contains('decrease') && qty > 1) qty--;

            // update locally
            qtyInput.value = qty;

            // send update to server
            fetch('{{ route('cart.update') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: qty })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    const price = parseFloat(row.querySelector('td:nth-child(2)').innerText.replace(/[৳,]/g,''));
                    const subtotal = price * qty;
                    row.querySelector('.subtotal').innerText = '৳' + subtotal.toFixed(2);
                    updateTotals();
                }
            });
        });
    });

    // remove item
    document.querySelectorAll('.remove-item').forEach(btn => {
        btn.addEventListener('click', function() {
            if (!confirm('Remove this item from cart?')) return;
            const row = this.closest('tr');
            const productId = row.dataset.productId;

            fetch('{{ route('cart.remove') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId })
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    row.remove();
                    updateTotals();
                    if (document.querySelectorAll('#cart-body tr').length === 0) {
                        location.reload();
                    }
                }
            });
        });
    });

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.subtotal').forEach(el => {
            subtotal += parseFloat(el.innerText.replace(/[৳,]/g,''));
        });
        document.getElementById('subtotal').innerText = '৳' + subtotal.toFixed(2);
        const delivery = 120;
        document.getElementById('total').innerText = '৳' + (subtotal + delivery).toFixed(2);
    }
});
</script>
@endsection
