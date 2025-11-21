
@foreach($products as $product)
<div class="col-6 col-md-4 col-lg-3 mb-3">
    <div class="product-card text-center">
        <a href="{{ route('product.details', $product->id) }}" class="text-decoration-none text-dark">
            @php
                $image = $product->mainImage->image_path ?? null;
            @endphp
            <img src="{{ $image ? asset('public/storage/'.$image) : asset('public/assets/images/shop.webp') }}" alt="{{ $product->name }}">
            <h6 class="mt-2 fw-semibold">{{ $product->name }}</h6>
        </a>
        <p class="mb-0">
              @if($product->price && $product->discount_price)
                <span class="text-muted text-decoration-line-through">৳{{ $product->price }}</span>
                <span class="text-danger fw-bold">৳{{ $product->discount_price }}</span>
            @else
                <span class="text-danger fw-bold">৳{{ $product->price }}</span>
            @endif
        </p>
    </div>
</div>
@endforeach
