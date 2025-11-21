@extends('layouts.admin.master')

@section('content')
<div class="container py-4">

    <h3 class="fw-bold mb-4">
        <i class="bi bi-bag-check me-2 text-primary"></i> Orders Management
    </h3>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Order No</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Payment</th>
                        <th>Order Status</th>
                        <th>Courier</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($orders as $order)
                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td class="fw-bold text-primary">{{ $order->order_number }}</td>

                        <td>
                            {{ $order->name }} <br>
                            <small class="text-muted">{{ $order->mobile }}</small>
                        </td>

                        <td>{{ number_format($order->total, 2) }}৳</td>

                        <td>
                            <span class="badge 
                                {{ $order->payment_status === 'paid' ? 'bg-success' :
                                   ($order->payment_status === 'unpaid' ? 'bg-secondary' : 'bg-warning text-dark') }}">
                                {{ ucfirst($order->payment_status) }}
                            </span>
                            <br>
                            <small>{{ $order->payment_method }}</small>
                        </td>

                        <td>
                            <span class="badge bg-info">{{ ucfirst($order->status) }}</span>
                        </td>

                        <td>
                            <span class="badge bg-dark">{{ $order->courier_name ?? 'N/A' }}</span>
                            <br>
                            <span class="badge bg-warning text-dark">{{ $order->courier_status }}</span>
                        </td>

                        <td>{{ $order->created_at->format('d M, Y') }}</td>

                        <td>
                            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                View
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $orders->links() }}
    </div>
</div>
@endsection
