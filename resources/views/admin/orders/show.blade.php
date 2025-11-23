@extends('layouts.admin.master')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold mb-0 text-uppercase">
            <i class="bi bi-receipt-cutoff text-primary me-2"></i> Order Details
        </h3>
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="bi bi-arrow-left me-1"></i> Back
        </a>
    </div>

    <!-- ===== TOP SUMMARY SECTIONS ===== -->
    <div class="row g-4">

        <!-- Customer Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-primary text-white fw-semibold">
                    <i class="bi bi-person-circle me-2"></i> Customer Information
                </div>
                <div class="card-body p-3">

                    <div class="small text-muted mb-1">Order Number</div>
                    <div class="fw-bold text-primary fs-6 mb-3">{{ $order->order_number }}</div>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Name:</span>
                        <span class="fw-semibold" id="orderName">{{ $order->name }}</span>
                    </div>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Mobile:</span>
                        <span class="fw-semibold" id="orderPhone">{{ $order->mobile }}</span>
                    </div>

                    <div class="d-flex justify-content-between small mb-2">
                        <span class="text-muted">Area:</span>
                        <span class="fw-semibold">{{ $order->area }}</span>
                    </div>

                    <div class="small text-muted mt-3">Address</div>
                    <div class="fw-semibold" id="orderAddress">{{ $order->address }}</div>
                </div>
            </div>
        </div>

        <!-- Order Summary -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-dark text-white fw-semibold">
                    <i class="bi bi-cash-coin me-2"></i> Order Summary
                </div>
                <div class="card-body p-3">

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Subtotal:</span>
                        <span>{{ number_format($order->subtotal, 2) }}৳</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Delivery Charge:</span>
                        <span>{{ number_format($order->delivery_charge, 2) }}৳</span>
                    </div>

                    <div class="d-flex justify-content-between py-2 border-top border-bottom mb-3">
                        <span class="fw-bold">Total:</span>
                        <span class="fw-bold text-success fs-5">{{ number_format($order->total, 2) }}৳</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Payment Method:</span>
                        <span class="badge bg-info text-dark">{{ $order->payment_method }}</span>
                    </div>

                    <div class="d-flex justify-content-between mb-2 small">
                        <span class="text-muted">Payment Status:</span>
                        <span class="badge
                            @if($order->payment_status == 'paid') bg-success
                            @elseif($order->payment_status == 'unpaid') bg-secondary
                            @elseif($order->payment_status == 'refunded') bg-warning text-dark
                            @endif">
                            {{ ucfirst($order->payment_status) }}
                        </span>
                    </div>

                    <div class="d-flex justify-content-between small">
                        <span class="text-muted">Order Status:</span>
                        <span class="badge
                            @if($order->status == 'pending') bg-warning text-dark
                            @elseif($order->status == 'processing') bg-primary
                            @elseif($order->status == 'shipped') bg-info text-dark
                            @elseif($order->status == 'delivered') bg-success
                            @elseif($order->status == 'cancelled') bg-danger
                            @endif">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>

                </div>
            </div>
        </div>

        <!-- Courier Info -->
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 rounded-3 h-100">
                <div class="card-header bg-info text-white fw-semibold">
                    <i class="bi bi-truck me-2"></i> Courier Information
                </div>

                <div class="card-body p-3">

                    <div class="small text-muted mb-1">Courier Name</div>
                    <div class="fw-semibold">{{ $order->courier_name ?? 'Not Assigned' }}</div>

                    <div class="small text-muted mt-3 mb-1">Tracking ID</div>
                    <div class="fw-semibold">{{ $order->courier_tracking_id ?? '-' }}</div>

                    <div class="small text-muted mt-3 mb-1">Courier Status</div>
                    <span class="badge
                        @if($order->courier_status == 'pending') bg-warning text-dark
                        @elseif($order->courier_status == 'shipped') bg-info text-dark
                        @elseif($order->courier_status == 'delivered') bg-success
                        @elseif($order->courier_status == 'cancelled') bg-danger
                        @endif">
                        {{ ucfirst($order->courier_status) }}
                    </span>

                    <hr>

                    <!-- Action Buttons -->
                    <div class="d-flex flex-wrap gap-2">


                        <button type="button"  data-bs-toggle="modal"
                        data-bs-target="#pathaoOrderModal" class="btn btn-primary btn-sm"><i class="bi bi-send me-1"></i> Send to Pathao</button>

                       
                        <button class="btn btn-dark btn-sm">
                            <i class="bi bi-send-check me-1"></i> Send to RedX
                        </button>
                        <button class="btn btn-success btn-sm">
                            <i class="bi bi-binoculars me-1"></i> Track
                        </button>
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-x-circle me-1"></i> Cancel
                        </button>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- ===== ORDER ITEMS ===== -->
    <div class="card shadow-sm border-0 rounded-3 my-4">
        <div class="card-header bg-light fw-semibold">
            <i class="bi bi-bag-check me-2"></i> Ordered Items
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-secondary">
                    <tr>
                        <th>#</th>
                        <th>Product</th>
                        <th>Qty</th>
                        <th>Price</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product->name ?? 'Deleted Product' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->price, 2) }}৳</td>
                        <td>{{ number_format($item->price * $item->quantity, 2) }}৳</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- ===== UPDATE ORDER FORM ===== -->
    <div class="card shadow-sm border-0 rounded-3 mb-5">
        <div class="card-header bg-success text-white fw-semibold">
            <i class="bi bi-pencil-square me-2"></i> Update Order
        </div>
        <div class="card-body">
            <form method="POST" action="{{ route('admin.orders.update', $order->id) }}" class="row g-3">
                @csrf
                @method('PUT')

                <div class="col-md-4">
                    <label class="form-label">Order Status</label>
                    <select name="status" class="form-select">
                        @foreach(['pending','processing','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->status == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        @foreach(['unpaid','paid','refunded'] as $s)
                        <option value="{{ $s }}" {{ $order->payment_status == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Courier Status</label>
                    <select name="courier_status" class="form-select">
                        @foreach(['pending','shipped','delivered','cancelled'] as $s)
                        <option value="{{ $s }}" {{ $order->courier_status == $s ? 'selected' : '' }}>
                            {{ ucfirst($s) }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-12">
                    <label class="form-label">Admin Note</label>
                    <textarea name="admin_note" class="form-control" rows="3">{{ $order->admin_note }}</textarea>
                </div>

                <div class="col-12 text-end">
                    <button class="btn btn-success px-4">
                        <i class="bi bi-check-circle me-2"></i> Save Changes
                    </button>
                </div>

            </form>
        </div>
    </div>
    @include('partials.pathao-modal')
</div>

<style>
    .card-header {
        letter-spacing: 0.4px;
        font-size: 0.95rem;
    }

    .table td,
    .table th {
        font-size: 0.9rem;
    }
</style>


@endsection