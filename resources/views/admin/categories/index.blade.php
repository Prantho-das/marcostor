@extends('layouts.admin.master')

@section('page_title', 'Categories')

@section('content')
<section class="container py-3">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="mb-0 text-primary fw-semibold">
            <i class="bi bi-diagram-3 me-2"></i> Category Tree
        </h4>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary btn-sm shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Add Category
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success small mb-3 shadow-sm rounded-3">{{ session('success') }}</div>
    @endif

    {{-- Category Tree --}}
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-3">

            @forelse($categories as $category)
                @if(is_null($category->parent_id))
                <div class="border rounded-4 mb-2 overflow-hidden bg-light-subtle">
                    {{-- Main Category Header --}}
                    <div class="d-flex justify-content-between align-items-center bg-white px-3 py-2 border-bottom"
                         data-bs-toggle="collapse"
                         data-bs-target="#cat-{{ $category->id }}"
                         style="cursor:pointer; border-radius:8px;">

                        <div>
                            <i class="bi bi-folder2 text-warning me-1"></i>
                            <strong class="text-dark">{{ $category->name }}</strong>
                            <small class="text-muted">({{ $category->slug }})</small>
                        </div>

                        <div class="d-flex align-items-center">
                            @if($category->children->count())
                                <button class="btn btn-sm btn-light border me-2" data-bs-toggle="collapse" data-bs-target="#cat-{{ $category->id }}">
                                    <i class="bi bi-chevron-down toggle-icon"></i>
                                </button>
                            @endif
                            <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this category?')"
                                        class="btn btn-sm btn-outline-danger">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>

                    {{-- Subcategories --}}
                    @if($category->children->count())
                        <div class="collapse" id="cat-{{ $category->id }}">
                            <ul class="list-group list-group-flush bg-white">
                                @foreach($category->children as $child)
                                    <li class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <i class="bi bi-arrow-return-right text-secondary me-1"></i>
                                                <strong>{{ $child->name }}</strong>
                                                <small class="text-muted">({{ $child->slug }})</small>
                                            </div>

                                            <div class="d-flex align-items-center">
                                                @if($child->children->count())
                                                    <button class="btn btn-sm btn-light border me-2"
                                                            data-bs-toggle="collapse"
                                                            data-bs-target="#subcat-{{ $category->id }}-{{ $child->id }}">
                                                        <i class="bi bi-chevron-down"></i>
                                                    </button>
                                                @endif
                                                <a href="{{ route('admin.categories.edit', $child) }}" class="btn btn-sm btn-outline-primary me-1">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                                <form action="{{ route('admin.categories.destroy', $child) }}" method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" onclick="return confirm('Delete this subcategory?')"
                                                            class="btn btn-sm btn-outline-danger">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                        {{-- Sub-subcategories --}}
                                        @if($child->children->count())
                                            <div class="collapse mt-2" id="subcat-{{ $category->id }}-{{ $child->id }}">
                                                <ul class="list-group mt-2 ms-4">
                                                    @foreach($child->children as $sub)
                                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                                            <div>
                                                                <i class="bi bi-dash text-muted me-1"></i>
                                                                {{ $sub->name }}
                                                                <small class="text-muted">({{ $sub->slug }})</small>
                                                            </div>
                                                            <div>
                                                                <a href="{{ route('admin.categories.edit', $sub) }}" class="btn btn-sm btn-outline-primary me-1">
                                                                    <i class="bi bi-pencil"></i>
                                                                </a>
                                                                <form action="{{ route('admin.categories.destroy', $sub) }}" method="POST" class="d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button type="submit" onclick="return confirm('Delete this sub-subcategory?')"
                                                                            class="btn btn-sm btn-outline-danger">
                                                                        <i class="bi bi-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
                @endif
            @empty
                <p class="text-muted text-center py-4">No categories found.</p>
            @endforelse

        </div>
    </div>
</section>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Rotate arrow icon on toggle
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(trigger => {
            trigger.addEventListener('click', function () {
                const icon = this.querySelector('.toggle-icon, .bi-chevron-down');
                if (icon) icon.classList.toggle('rotate');
            });
        });
    });
</script>

<style>
    .rotate {
        transform: rotate(180deg);
        transition: transform 0.3s ease;
    }

    .list-group-item {
        border: none !important;
        border-bottom: 1px solid #f3f3f3 !important;
        background-color: #fff !important;
    }

    .list-group-item:last-child {
        border-bottom: none !important;
    }

    .list-group-item:hover {
        background-color: #f8f9fa !important;
        transition: background 0.3s ease;
    }

    .btn-outline-primary, .btn-outline-danger, .btn-light {
        border-radius: 6px !important;
    }

    .card {
        background-color: #fafafa;
    }
</style>
@endpush
@endsection
