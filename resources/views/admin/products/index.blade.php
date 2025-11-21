@extends('layouts.admin.master')

@section('page_title', 'Products')

@section('content')
<section class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="fw-bold text-dark mb-0">
        <i class="bi bi-box-seam me-2 text-primary"></i> Products
    </h4>
    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle me-1"></i> Add Product
    </a>
</div>

{{-- Success message --}}
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

{{-- Table --}}
<div class="card shadow-sm border-0 rounded-4">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="text-center">#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Brand</th>
                        <th>Colors</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $p)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>

                            {{-- Product Image --}}
                            <td style="width:80px">
                                <div class="ratio ratio-1x1" style="width:60px;">
                                    @if($p->mainImage)
                                        <img src="{{ asset('public/storage/'.$p->mainImage->image_path) }}" 
                                             alt="{{ $p->name }}" class="img-fluid rounded shadow-sm object-fit-cover">
                                    @else
                                        <img src="{{ asset('assets/images/placeholder.png') }}" 
                                             class="img-fluid rounded shadow-sm">
                                    @endif
                                </div>
                            </td>

                            {{-- Product Info --}}
                            <td>
                                <div class="fw-semibold text-dark">{{ $p->name }}</div>
                                <small class="text-muted">Slug: {{ $p->slug }}</small>
                            </td>

                            <td>{{ $p->category->name ?? '-' }}</td>
                            <td>{{ $p->brand->name ?? '-' }}</td>

                            {{-- Colors --}}
                            <td>
                                @if($p->colors && $p->colors->count() > 0)
                                    @foreach($p->colors as $color)
                                        <span class="badge rounded-pill border" style="background-color: {{ $color->hex ?? '#ccc' }}">
                                            {{ $color->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <small class="text-muted">-</small>
                                @endif
                            </td>

                            {{-- Price --}}
                            <td>
                               <div class=" text-danger text-decoration-line-through">${{ number_format($p->price, 2) }}</div>
                                @if($p->price)
                                    <small class="fw-semibold text-dark">${{ number_format($p->discount_price, 2) }}</small>
                                @endif
                            </td>

                            <td>
                                @if($p->stock > 0)
                                    <span class="badge bg-success-subtle text-success px-3 py-2">
                                        {{ $p->stock }}
                                    </span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger px-3 py-2">Out of Stock</span>
                                @endif
                            </td>

                            {{-- Status --}}
                            <td>
                                @if($p->is_active)
                                    <span class="badge bg-success">Active</span>
                                @else
                                    <span class="badge bg-secondary">Inactive</span>
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="text-center">
                                <a href="{{ route('admin.products.edit', $p) }}" 
                                   class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form action="{{ route('admin.products.destroy', $p) }}" 
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                <i class="bi bi-inbox fs-4 d-block mb-2"></i>
                                No products found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- Pagination --}}
<div class="mt-3">
    {{ $products->links('pagination::bootstrap-5') }}
</div>
</section>
@endsection
