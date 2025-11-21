@extends('layouts.admin.master')

@section('title', 'Section Settings')

@section('content')
<div class="container py-4">
    <h4 class="fw-bold mb-4">🛠️ Homepage Section Settings</h4>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST" class="card p-4 shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label">Bag Collection Category</label>
            <select name="bags" class="form-select">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($settings['bags'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Cover Cases Category</label>
            <select name="covers" class="form-select">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($settings['covers'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label">Sound Devices Category</label>
            <select name="sound" class="form-select">
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ ($settings['sound'] ?? '') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">💾 Save Changes</button>
    </form>
</div>
@endsection
