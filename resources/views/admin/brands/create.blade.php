@extends('layouts.admin.master')
@section('page_title', 'Create Brand')
@section('content')

<div class="container py-4">
    <h4 class="fw-bold mb-4">Add New Brand</h4>

    <form action="{{ route('admin.brands.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label class="form-label">Brand Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (optional)</label>
            <input type="text" name="slug" value="{{ old('slug') }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Brand Image</label>
            <input type="file" name="image" accept="image/*" class="form-control">
            <small class="text-muted">Max size: 2MB</small>
        </div>

        <button class="btn btn-success"><i class="bi bi-check-circle"></i> Save Brand</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
