@php
    $sale = 0;
    if($product->promotion && $product->price){
        $sale = round(100 - ($product->promotion * 100 / $product->price));
    }
    $color_first = $product->getColor();
@endphp
<div class="item">
    <div class="thumb">
        {!! $product->renderSize(count($color_first)?$color_first->first()->value:'') !!}

        <a href="{{ route('shop.detail', $product->slug) }}">
            <img class="item-img" src="{{ asset($product->image) }}" title="{{ $product->name }} {{ $product->sku }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/placeholder.png') }}') this.src = '{{ asset('assets/images/placeholder.png') }}';">
        </a>
        {!! $sale > 0 ? '<div class="sale">-'.$sale.'%</div>' : '' !!}
    </div>
    <div class="down-content">
        {!! $product->renderColor() !!}

        <h4><a href="{{ route('shop.detail', $product->slug) }}">{{ $product->name }} {{ $product->sku }}</a></h4>
        <div class="price">
            {!! $product->showPrice() !!}
        </div>

        <form action="{{ route('cart.ajax.add') }}" method="post">
            <input type="hidden" name="product" value="{{ $product->id }}">
            <input type="hidden" name="product_item_id" value="0">
        </form>
    </div>
</div>