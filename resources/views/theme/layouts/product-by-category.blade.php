@php
    $category = \App\ProductCategory::where('id', $id)->first();
    $products = (new \App\Product)->setCategory($id)->getList(['limit' => 20]);
@endphp
@if($products->count())
    <div class="product-shirt py-5">
        <div class="container">
            <div class="title-box">
                <div class="section-heading">
                    <h5>{{ $category->name }}</h5>
                </div>
                <a href="{{ route('shop.detail', ['slug' => $category->slug]) }}">Xem thêm</a>
            </div>
            <div class="product-slider owl-carousel">
                @foreach($products as $key => $product)
                    @include($templatePath .'.product.product-item', compact('product'))
                @endforeach
            </div>
        </div>
    </div>
@endif