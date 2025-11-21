@extends('layouts.admin.master')
@section('page_title', 'Edit Brand')
@section('content')

<div class="container py-4">
    <h4 class="fw-bold mb-4">Edit Brand</h4>

    <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')

        <div class="mb-3">
            <label class="form-label">Brand Name</label>
            <input type="text" name="name" value="{{ old('name', $brand->name) }}" class="form-control" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Slug (optional)</label>
            <input type="text" name="slug" value="{{ old('slug', $brand->slug) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label">Brand Image</label><br>
            @if($brand->image)
                <img src="{{ asset('storage/'.$brand->image) }}" width="80" class="rounded mb-2">
            @endif
            <input type="file" name="image" accept="image/*" class="form-control">
        </div>

        <button class="btn btn-primary"><i class="bi bi-save"></i> Update Brand</button>
        <a href="{{ route('admin.brands.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
