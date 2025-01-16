@php
    $data_search = [
        'limit'	=> 5,
        'sort_order'	=> "id__desc"
    ];
    $products = (new \App\Product)->getList($data_search);
@endphp
@if($products->count())
    <div class="product-relate py-5">
        <div class="container">
            <div class="title-device">
                <h1>Có thể bạn sẽ Quan Tâm</h1>
                <a href="{{ route('shop') }}">Xem tất cả <i class="fas fa-arrow-right"></i></a>
            </div>
            <div class="product-slider owl-carousel">
                @foreach($products as $key => $product)
                    @include($templatePath .'.product.product-item', compact('product'))
                @endforeach
            </div>
        </div>
    </div>
@endif