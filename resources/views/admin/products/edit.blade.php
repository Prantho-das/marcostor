@extends('layouts.admin.master')
@section('page_title', 'Edit Product')
@section('content')

<section class="container py-4">
    <div class="card shadow-lg border-0 rounded-4">
        <div class="card-header bg-primary text-white py-3 rounded-top-4">
            <h4 class="mb-0"><i class="bi bi-pencil-square me-2"></i>Edit Product</h4>
        </div>
        <div class="card-body p-4">

           <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="_method" value="PUT">

    {{-- Product Name --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Product Name</label>
        <input name="name" class="form-control form-control-lg" value="{{ old('name', $product->name) }}" required>
    </div>

    {{-- Category --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Category</label>
        <select name="category_id" class="form-select form-select-lg">
            <option value="">-- Select Category --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" @selected(old('category_id', $product->category_id) == $c->id)>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Brand --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Brand</label>
        <select name="brand_id" class="form-select form-select-lg">
            <option value="">-- Select Brand --</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" @selected(old('brand_id', $product->brand_id) == $b->id)>{{ $b->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Colors --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Colors</label>
        <select name="colors[]" class="form-select form-select-lg" multiple>
            @foreach($colors as $c)
                <option value="{{ $c->id }}" 
                    {{ in_array($c->id, old('colors', $product->colors->pluck('id')->toArray())) ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple colors.</small>
    </div>

    {{-- Price --}}
    <div class="row">
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Price</label>
            <input name="price" class="form-control form-control-lg" type="number" step="0.01" 
                   value="{{ old('price', $product->price) }}" required>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label fw-semibold">Discount Price</label>
            <input name="discount_price" class="form-control form-control-lg" type="number" step="0.01" 
                   value="{{ old('discount_price', $product->discount_price) }}">
        </div>
    </div>

    {{-- Stock --}}
    <div class="mb-3">
        <label class="form-label fw-semibold">Stock</label>
        <input name="stock" class="form-control form-control-lg" type="number" 
               value="{{ old('stock', $product->stock) }}" required>
    </div>

    {{-- Active --}}
    <div class="form-check form-switch mb-4">
        <input type="checkbox" name="is_active" class="form-check-input" id="is_active"
            {{ old('is_active', $product->is_active) ? 'checked' : '' }}>
        <label class="form-check-label fw-semibold" for="is_active">Active</label>
    </div>

    {{-- Existing Images --}}
    <div class="mb-4">
        <label class="form-label fw-semibold">Existing Images</label>
        <div class="d-flex flex-wrap gap-3">
            @foreach($product->images as $img)
                <div class="position-relative shadow-sm border rounded-3 overflow-hidden" 
                     style="width: 120px; height: 120px;" id="img-{{ $img->id }}">
                    <img src="{{ asset('storage/'.$img->image_path) }}" 
                         class="img-fluid w-100 h-100 object-fit-cover">
                    <button type="button" 
                            class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1 rounded-circle delete-image-btn" 
                            data-id="{{ $img->id }}" title="Delete Image">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Add New Images --}}
    <div class="mb-4">
        <label class="form-label fw-semibold">Add More Images</label>
        <input type="file" name="images[]" multiple accept="image/*" class="form-control form-control-lg">
        <small class="text-muted">First image will remain primary.</small>
    </div>

    {{-- Description --}}
    <div class="mb-4">
        <label class="form-label fw-semibold">Description</label>
        <textarea name="description" id="description" class="form-control" rows="6">{{ old('description', $product->description) }}</textarea>
    </div>

    <div class="text-end">
        <button type="submit" class="btn btn-lg btn-success px-4">
            <i class="bi bi-save me-2"></i> Update Product
        </button>
    </div>
</form>

        </div>
    </div>
</section>

@endsection

@push('scripts')
{{-- TinyMCE --}}
<script src="https://cdn.tiny.cloud/1/s770msnyf4byufylmlq4o67ddko5917eoal7lgqq1huw73qb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector:'#description',
    plugins: 'table lists link image paste media code',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | table | link image media | code',
    menubar: 'file edit insert format tools table help',
    height: 450,
    paste_as_text: false,
    paste_data_images: true,
    images_upload_url: '{{ route("admin.tinymce.upload") }}',
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, success, failure) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', '{{ route("admin.tinymce.upload") }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onload = function() {
            if (xhr.status != 200) return failure('HTTP Error: ' + xhr.status);
            var json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') return failure('Invalid JSON: ' + xhr.responseText);
            success(json.location);
        };
        var formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    },
    valid_elements: '*[*]'
});
</script>

{{-- AJAX Image Delete --}}
<script>
document.querySelectorAll('.delete-image-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        if (!confirm('Delete this image?')) return;
        let id = this.dataset.id;
        fetch(`/admin/products/image/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        }).then(res => {
            if (res.ok) {
                document.getElementById('img-' + id).remove();
            } else {
                alert('Failed to delete image.');
            }
        }).catch(() => alert('Something went wrong.'));
    });
});
</script>
@endpush
