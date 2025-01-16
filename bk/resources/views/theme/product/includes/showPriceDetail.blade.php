@if($priceFinal > 0)
    @php
    if($price)
    {
        $price_sale = $price - $priceFinal;
        $price_percent = round($price_sale * 100 / $price);
    }
    @endphp
    
    
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money">{!! render_price($priceFinal) !!}</span></span>
        @if(isset($unit) && $unit != '')
        <span>/ {!! $unit !!}</span>
        @endif
    </span>

    @if($price)
    <s id="ComparePrice-product-template"><span class="money">{!! render_price($price) !!}</span></s>
    @endif

@else
    @if($price > 0)
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money">{!! render_price($price) !!}</span></span>
        @if(isset($unit) && $unit != '')
        <span>/ {!! $unit !!}</span>
        @endif
    </span>

    @else
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money">Liên hệ</span></span>
    </span>
    @endif
@endif