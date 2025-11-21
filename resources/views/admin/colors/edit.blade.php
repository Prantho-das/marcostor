@extends('layouts.admin.master')
@section('page_title','Edit Color')
@section('content')

<div class="container py-4">
    <h4 class="fw-bold mb-4"><i class="bi bi-brush me-2 text-primary"></i>Edit Color</h4>

    <div class="card shadow-sm p-4">
        <form action="{{ route('admin.colors.update', $color) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Color Name</label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $color->name) }}" required>
                @error('name') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Color Hex Code</label>
                <input type="color" name="hex" class="form-control form-control-color" value="{{ old('hex', $color->hex) }}">
                @error('hex') <small class="text-danger">{{ $message }}</small> @enderror
            </div>

            <button class="btn btn-primary"><i class="bi bi-save me-1"></i> Update Color</button>
            <a href="{{ route('admin.colors.index') }}" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</div>
@endsection
