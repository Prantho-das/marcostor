@extends('layouts.app')

@section('content')
<div class="container py-5 px-2">
    <div class="mx-auto bg-white shadow-lg rounded-lg p-4 p-md-5 text-center border-top border-success" style="max-width: 500px;">
        <!-- Success Icon using Bootstrap Icon -->
        <div class="mb-3">
            <i class="bi bi-check-circle-fill " style="font-size: 3rem; color: #cd4b57;"></i>
        </div>

        <!-- Thank You Message -->
        <h2 class="h4 h-md-3 font-weight-bold  mb-2" style="color: #cd4b57;">Thank You for Your Order!</h2>
        <p class="text-muted mb-4">Your order has been placed successfully.</p>

        <!-- Order Info -->
        <div class="bg-light p-3 rounded mb-4 text-left">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <strong>Order Number : </strong><span id="orderNumber" class="bg-white px-2 py-1 border rounded text-truncate" style="max-width: 200px; display:inline-block; cursor:pointer;"> {{ $order->order_number }}</span>
                <button onclick="copyOrderNumber()" class="btn btn-outline-primary btn-sm" title="Copy Order Number">
                    <i class="bi bi-clipboard"></i>
                </button>
            </div>
            <p class="mb-0"><strong>Total Amount:</strong> BDT {{ number_format($order->total, 2) }}</p>
        </div>

        <!-- Continue Shopping Button -->
        <a href="{{ route('home') }}" class="btn  btn-lg d-flex align-items-center justify-content-center mx-auto" style="background-color: #cd4b57; color: #fff; ">
            <i class="bi bi-cart3 me-2"></i>
            Continue Shopping
        </a>
    </div>
</div>

<script>
function copyOrderNumber() {
    const orderNum = document.getElementById('orderNumber').innerText;
    navigator.clipboard.writeText(orderNum).then(() => {
        alert('Order number copied to clipboard!');
    });
}
</script>
@endsection
