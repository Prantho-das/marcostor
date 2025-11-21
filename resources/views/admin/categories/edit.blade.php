@extends('layouts.admin.master')

@section('page_title', 'Edit Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h4 class="mb-0 fw-semibold text-primary">
        <i class="bi bi-pencil-square me-1"></i> Edit Category
    </h4>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary btn-sm">
        ← Back to Categories
    </a>
</div>

<div class="card shadow-sm border-0 rounded-3">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Category Name --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" 
                       value="{{ old('name', $category->name) }}" required>
                @error('name')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Slug (optional)</label>
                <input type="text" name="slug" class="form-control" 
                       value="{{ old('slug', $category->slug) }}">
                <small class="text-muted">If left empty, it will be generated automatically.</small>
                @error('slug')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Parent Category --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Parent Category (optional)</label>
                <select name="parent_id" class="form-select">
                    <option value="">-- None --</option>
                    @foreach($parents as $id => $name)
                        <option value="{{ $id }}" 
                            {{ old('parent_id', $category->parent_id) == $id ? 'selected' : '' }}>
                            {{ $name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

            {{-- Description --}}
            <div class="mb-3">
                <label class="form-label fw-semibold">Description</label>
                <textarea name="description" rows="3" class="form-control">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="text-danger small mt-1">{{ $message }}</div>
                @enderror
            </div>

{{-- Image Upload --}}
<div class="mb-3">
    <label class="form-label fw-semibold">Category Image (optional)</label>
    <input type="file" name="image" class="form-control">
    <small class="text-muted">If you upload a new image, it will replace the current one.</small>
</div>

{{-- Show current image --}}
@if($category->image)
    <div class="mb-3">
        <label class="form-label">Current Image</label><br>
        <img src="{{ asset('storage/' . $category->image) }}" 
             alt="{{ $category->name }}" style="width:120px;height:auto;">
    </div>
@endif



            {{-- Submit --}}
            <div class="text-end">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="bi bi-check-circle me-1"></i> Update Category
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
