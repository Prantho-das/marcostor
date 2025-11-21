@extends('layouts.admin.master')
@section('page_title', 'Brands')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold">Brand List</h4>
        <a href="{{ route('admin.brands.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Add New Brand
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form class="mb-3 d-flex" method="GET">
        <input type="text" name="q" value="{{ request('q') }}" placeholder="Search brand..." class="form-control me-2">
        <button class="btn btn-secondary">Search</button>
    </form>

    <div class="card shadow-sm">
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Created</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($brands as $key => $brand)
                    <tr>
                        <td>{{ $key + $brands->firstItem() }}</td>
                        <td>
                            @if($brand->image)
                                <img src="{{ asset('storage/'.$brand->image) }}" width="60" class="rounded shadow-sm">
                            @else
                                <span class="text-muted">No image</span>
                            @endif
                        </td>
                        <td>{{ $brand->name }}</td>
                        <td>{{ $brand->slug }}</td>
                        <td>{{ $brand->created_at->format('d M, Y') }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.brands.edit', $brand) }}" class="btn btn-sm btn-warning">
                                <i class="bi bi-pencil-square"></i>
                            </a>
                            <form action="{{ route('admin.brands.destroy', $brand) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure to delete this brand?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-muted py-3">No brands found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-3">
        {{ $brands->links() }}
    </div>
</div>
@endsection
