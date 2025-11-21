@extends('layouts.app')

@section('content')
<section class="py-5 mb-5" >
    <div class="container" style="max-width: 760px;">
        <div class="bg-white shadow rounded-4 p-4 p-md-5">
            <h3 class="fw-bold text-center text-uppercase mb-4">Checkout</h3>

           
            <form action="{{ route('checkout.payment') }}" method="POST" id="checkout-form">
               @csrf
                

                <!-- 🛒 Cart Items -->
                <h5 class="fw-bold border-bottom pb-2 mb-3">Your Cart</h5>

                @if(count($cartItems) === 0)
                    <div class="alert alert-warning text-center">
                        Your cart is empty. <a href="{{ route('home') }}" class="fw-semibold">Continue shopping →</a>
                    </div>
                @else
                    <ul class="list-group mb-4" id="cart-list">
                        @foreach($cartItems as $item)
                            <li class="list-group-item border-0 border-bottom py-3" data-id="{{ $item['product_id'] }}">
                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                    <div class="d-flex align-items-center flex-grow-1">
                                        <img src="{{ $item['image'] }}" 
                                             class="rounded me-3 border" width="60" height="60" 
                                             alt="{{ $item['name'] }}">
                                        <div>
                                            <span class="fw-semibold">{{ $item['name'] }}</span><br>
                                            <small class="text-muted">৳{{ number_format($item['price'],2) }} each</small>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-sm decrease">−</button>
                                        <input type="text" 
                                               class="form-control form-control-sm text-center mx-1" 
                                               name="quantity[{{ $item['product_id'] }}]" 
                                               value="{{ $item['quantity'] }}" 
                                               style="width:55px;" readonly>
                                        <button type="button" class="btn btn-outline-secondary btn-sm increase">+</button>
                                        <span class="fw-semibold ms-3 item-total">
                                            ৳{{ number_format($item['subtotal'],2) }}
                                        </span>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif

                <!-- 🚚 Shipping Info -->
                <h5 class="fw-bold border-bottom pb-2 mb-3 mt-4">Shipping Information</h5>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Mobile Number <span class="text-danger">*</span></label>
                        <input type="text" name="mobile" class="form-control" placeholder="01XXXXXXXXX" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Delivery Area <span class="text-danger">*</span></label>
                        <select class="form-select" name="area" required>
                            <option selected disabled>Select Area</option>
                            <option>Dhaka</option>
                            <option>Chattogram</option>
                            <option>Thakurgaon - Haripur</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Delivery Address <span class="text-danger">*</span></label>
                        <textarea class="form-control" name="address" rows="2" placeholder="House number, street name" required></textarea>
                    </div>
                </div>

                <!-- 💰 Order Summary -->
                <h5 class="fw-bold border-bottom pb-2 mb-3 mt-4">Order Summary</h5>
                @php
                    $subtotal = collect($cartItems)->sum('subtotal');
                    $delivery = 120;
                    $total = $subtotal + $delivery;
                @endphp
                <ul class="list-unstyled mb-3 small">
                    <li class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">৳{{ number_format($subtotal,2) }}</span>
                    </li>
                    <li class="d-flex justify-content-between mb-2">
                        <span>Delivery Charge:</span>
                        <span id="delivery">৳{{ number_format($delivery,2) }}</span>
                    </li>
                    <li class="d-flex justify-content-between border-top pt-2 fw-bold">
                        <span>Total:</span>
                        <span id="total">৳{{ number_format($total,2) }}</span>
                    </li>
                </ul>

                <!-- 💳 Payment Method -->
                <h5 class="fw-bold border-bottom pb-2 mb-3 mt-4">Payment Method</h5>
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="COD" id="cod" checked>
                            <label class="form-check-label fw-semibold" for="cod">Cash On Delivery</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="sslcommerz" id="ssl">
                            <label class="form-check-label fw-semibold" for="ssl">SSLCommerz</label>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-check border rounded p-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="bkash" id="bkash" disabled>
                            <label class="form-check-label fw-semibold" for="bkash">bKash / Nagad</label>
                        </div>
                    </div>
                </div>
                <div class="alert alert-info small mt-3">
                    ⚠️ Currently only <strong>Cash on Delivery</strong> is available.<br>
                    💡 SSLCommerz / bKash integration coming soon — design is ready.
                </div>

                <!-- ✅ Confirm Order -->
                <button class="btn btn-danger w-100 py-2 fw-semibold mt-3" type="submit">Confirm Order</button>
            </form>
        </div>
    </div>
</section>

<!-- 🔧 Quantity Update Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const deliveryCharge = 120;

    function updateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-total').forEach(el => {
            subtotal += parseFloat(el.textContent.replace(/[৳,]/g,''));
        });
        document.getElementById('subtotal').textContent = '৳' + subtotal.toFixed(2);
        document.getElementById('total').textContent = '৳' + (subtotal + deliveryCharge).toFixed(2);
    }

    document.querySelectorAll('.increase').forEach(btn => {
        btn.addEventListener('click', function() {
            const li = this.closest('li');
            const qtyInput = li.querySelector('input[name^="quantity"]');
            const pricePerUnit = parseFloat(li.querySelector('.text-muted').textContent.replace(/[৳,]/g,'').replace('each',''));
            let qty = parseInt(qtyInput.value);
            qtyInput.value = ++qty;
            li.querySelector('.item-total').textContent = '৳' + (pricePerUnit * qty).toFixed(2);
            updateTotals();
        });
    });

    document.querySelectorAll('.decrease').forEach(btn => {
        btn.addEventListener('click', function() {
            const li = this.closest('li');
            const qtyInput = li.querySelector('input[name^="quantity"]');
            const pricePerUnit = parseFloat(li.querySelector('.text-muted').textContent.replace(/[৳,]/g,'').replace('each',''));
            let qty = parseInt(qtyInput.value);
            if (qty > 1) {
                qtyInput.value = --qty;
                li.querySelector('.item-total').textContent = '৳' + (pricePerUnit * qty).toFixed(2);
                updateTotals();
            }
        });
    });
});
</script>
@endsection
