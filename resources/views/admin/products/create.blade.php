@extends('layouts.admin.master')
@section('page_title','Add Product')
@section('content')

@php
    // Create page-এ product null হবে, তাই safe fallback
    $productColors = isset($product) ? $product->colors->pluck('id')->toArray() : [];
@endphp

<section class="container">

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="name" class="form-label">Product Name</label>
        <input name="name" id="name" class="form-control" value="{{ old('name') }}" required>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select">
            <option value="">--none--</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="brand_id" class="form-label">Brand</label>
        <select name="brand_id" id="brand_id" class="form-select">
            <option value="">--none--</option>
            @foreach($brands as $b)
                <option value="{{ $b->id }}" {{ old('brand_id') == $b->id ? 'selected' : '' }}>{{ $b->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="colors" class="form-label">Colors</label>
        <select name="colors[]" id="colors" class="form-select" multiple>
            @foreach($colors as $c)
                <option value="{{ $c->id }}"
                    {{ in_array($c->id, old('colors', $productColors)) ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">Hold Ctrl (Windows) or Cmd (Mac) to select multiple colors.</small>
    </div>

    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input name="price" id="price" class="form-control" type="number" step="0.01" value="{{ old('price') }}" required>
    </div>

    <div class="mb-3">
        <label for="discount_price" class="form-label">Discount Price</label>
        <input name="discount_price" id="discount_price" class="form-control" type="number" step="0.01" value="{{ old('discount_price') }}">
    </div>

    <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input name="stock" id="stock" class="form-control" type="number" value="{{ old('stock') }}" required>
    </div>

    <div class="mb-3">
        <label for="images" class="form-label">Product Images</label>
        <input type="file" name="images[]" id="images" multiple accept="image/*" class="form-control">
        <small class="text-muted">You can upload multiple images. First image will be primary.</small>
    </div>

    <div class="mb-3 form-check form-switch">
    <input type="checkbox" name="is_active" id="is_active" class="form-check-input"
        {{ old('is_active', $product->is_active ?? true) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_active">Active</label>
</div>


    <div class="mb-3">
        <label for="description" class="form-label">Description</label>
        <textarea name="description" id="description" class="form-control" rows="6">{!! old('description') !!}</textarea>
    </div>

    <button type="submit" class="btn btn-primary">Save Product</button>
</form>

</section>
@endsection

@push('scripts')
<script src="https://cdn.tiny.cloud/1/s770msnyf4byufylmlq4o67ddko5917eoal7lgqq1huw73qb/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

<script>
tinymce.init({
    selector: '#description',
    plugins: 'table lists link image media code',
    toolbar: 'undo redo | formatselect | bold italic underline | alignleft aligncenter alignright | bullist numlist outdent indent | table | link image media | code',
    menubar: 'file edit insert format tools table help',
    height: 450,
    paste_as_text: false,
    paste_data_images: true,          // allow pasting inline images
    images_upload_url: '{{ route("admin.tinymce.upload") }}', // optional: server upload endpoint
    automatic_uploads: true,
    images_upload_handler: function (blobInfo, success, failure) {
        // optional JS fallback if you want to handle upload; otherwise TinyMCE will POST to images_upload_url
        var xhr, formData;
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route("admin.tinymce.upload") }}');
        xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
        xhr.onload = function() {
            var json;
            if (xhr.status != 200) {
                failure('HTTP Error: ' + xhr.status);
                return;
            }
            json = JSON.parse(xhr.responseText);
            if (!json || typeof json.location != 'string') {
                failure('Invalid JSON: ' + xhr.responseText);
                return;
            }
            success(json.location);
        };
        formData = new FormData();
        formData.append('file', blobInfo.blob(), blobInfo.filename());
        xhr.send(formData);
    },
    valid_elements: '*[*]' // very permissive on client — server will sanitize
});
</script>
@endpush
