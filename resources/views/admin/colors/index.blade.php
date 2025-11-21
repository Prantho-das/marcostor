@extends('layouts.admin.master')
@section('page_title','Colors')
@section('content')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="fw-bold"><i class="bi bi-palette me-2 text-primary"></i>Colors</h4>
        <a href="{{ route('admin.colors.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i> Add New
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Preview</th>
                        <th>Hex Code</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($colors as $key => $color)
                        <tr>
                            <td>{{ $colors->firstItem() + $key }}</td>
                            <td>{{ $color->name }}</td>
                            <td>
                                @if($color->hex)
                                    <span class="d-inline-block rounded" style="width:25px; height:25px; background:{{ $color->hex }}; border:1px solid #ddd;"></span>
                                @endif
                            </td>
                            <td><code>{{ $color->hex ?? '--' }}</code></td>
                            <td>
                                <a href="{{ route('admin.colors.edit', $color) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.colors.destroy', $color) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete this color?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No colors found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $colors->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
