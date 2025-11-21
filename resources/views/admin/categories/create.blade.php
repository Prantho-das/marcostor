@extends('layouts.admin.master')

@section('page_title', 'Add Category')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">Add New Category</h5>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary btn-sm">← Back</a>
</div>

<form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label class="form-label">Category Name <span class="text-danger">*</span></label>
        <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
        @error('name') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Slug (optional)</label>
        <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
        <small class="text-muted">If empty, slug will be auto-generated from name.</small>
        @error('slug') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <div class="mb-3">
        <label class="form-label">Parent Category (optional)</label>
        <select name="parent_id" class="form-select">
            <option value="">-- None --</option>
            @foreach($parents as $id => $name)
                <option value="{{ $id }}">{{ $name }}</option>
            @endforeach
        </select>
        @error('parent_id') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>


    <div class="mb-3">
        <label class="form-label">Description</label>
        <textarea name="description" rows="3" class="form-control">{{ old('description') }}</textarea>
        @error('description') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

     <div class="mb-3">
        <label class="form-label">Category Image (optional)</label>
        <input type="file" name="image" class="form-control" accept="image/*">
        <small class="text-muted">Allowed: jpeg, png, webp. Max 2MB. We'll optimize automatically.</small>
        @error('image') <div class="text-danger small">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save Category</button>
</form>
@endsection
