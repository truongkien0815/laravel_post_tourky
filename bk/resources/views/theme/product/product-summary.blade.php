@php
    $url_current = url()->current();
    $add_cart_disabled = 'disabled';
    if($product->stock != 0 && $product->getFinalPrice() != 0)
    {
       $add_cart_disabled = '';
    }
    $sale = 0;
    if($product->promotion && $product->price){
        $sale = round(100 - ($product->promotion * 100 / $product->price));
    }
@endphp
<div class="price price-sale">
   <div class="show-price">{!! $product->showPriceDetail() !!}</div>
    {!! $sale > 0 ? '<div class="sale-detail">-'.$sale.'%</div>' : '' !!}
</div>
<div class="product-single__addtocart">
    <form action="{{ route('cart.ajax.add') }}" id="product_form_addCart" accept-charset="UTF-8" enctype="multipart/form-data">
        <input type="hidden" name="product" value="{{ $product->id }}">

        <div class="product-single__options">
            <div class="product-attr-content">
                {!! $product->product_variables() !!}
            </div>
            @if(!$product_stock)
                <div class="outofstock">
                    <span>Hết hàng</span>
                </div>
            @endif
        </div>
        <div class="product-single__actions">
            <div class="product-single__quantity">
                <div class="quantity qtyField {{ $disabled }}" rel-script="quantity-change">
                    <a href="javascript:void(0);" class="quantity__reduce qtyBtn minus">-</a>
                    <input type="number" id="Quantity" name="qty" value="1" max="99" min="1" class="quantity__control product-form__input qty">
                    <a href="javascript:void(0);" class="quantity__augure qtyBtn plus">+</a>
{{--                    <span class="ms-2 product-stock">({{ $product->stock??0 }})</span>--}}
                </div>
            </div>
            <div class="product-single__button {{ $add_cart_disabled }}">
                <a href="javascript:;" class="btn product-form__cart-add {{ $add_cart_disabled }}">THÊM VÀO GIỎ HÀNG</a>
            </div>
        </div>
    </form>
</div>