<div class="your-order">
    <h4 class="order-title mb-3">Đơn hàng</h4>
    @php $weight = 0; @endphp
    <div>
        @foreach($carts as $cart)
        @php 

            $product = \App\Product::find($cart->id); 
            $product_weight = $product->attrs()->where('name', 'weight')->first();
            if($product_weight && $product_weight->content !='')
                $weight = $weight + ($product_weight->content * $cart->qty ) ;

            
            if($cart->options)
            {
                $option_key_first = array_key_first($cart->options->toArray());
                $item_id = explode('__', $option_key_first)[1]??0;
                $product_item = \App\Model\ShopProductItem::find($item_id);
                $img = $product_item->getGallery()[0]??'';
            }

            $disabled = '';
            if($product->stock < $cart->qty)
                $disabled = 'disabled';
        @endphp
        <div class="cart__row_item {{ $disabled }}">
            <a href="{{ route('shop.detail', $product->slug) }}">
                <img src="{{ asset($img??$product->image) }}" alt="{{ $product->name }}" onerror="if (this.src != '{{ asset('assets/images/no-image.jpg') }}') this.src = '{{ asset('assets/images/no-image.jpg') }}';" width="120">
            </a>
            <div class="info_right">
                <div class=" product-title"><a href="{{ route('shop.detail', $product->slug) }}">{{ $product->name }}</a></div>
                @if($product->unit)
                <div class="fs-sm"><span class="text-muted me-2">Đơn vị:</span>{{ $product->unit }}</div>
                @endif
                @include($templatePath .'.cart.includes.render-attr-item', ['options' => $cart->options])
                <div class="d-flex cart__meta-text">
                    <div class="w-100">Số lượng: {{ $cart->qty }}</div>
                    <div class="w-100 fs-6 text-danger text-end">{!! render_price($cart->price * $cart->qty) !!}</div>
                </div>
                
            </div>
        </div>
    @endforeach
    </div>

    <input type="hidden" name="weight" value="{{ $weight }}">
    {{--
    @if(!empty($shippingAddress['delivery']) && $shippingAddress['delivery'] == 'shipping')
    <div class="shipping justify-content-end py-2 border-bottom">
        <div class="text-info">Đơn vị vận chuyển:</div>
    </div>
    @endif
    --}}
    <!-- <div class="text-end py-2">
        <div>
            <span>Tổng số tiền</span>
            <span class="ps-5 fs-5 text-danger cart_total_text" data="{!! render_price(Cart::total(2)) !!}">{!! render_price(Cart::total(2)) !!}</span>
        </div>
    </div> -->
    <div class="text-end py-2">
        @foreach ($totalMethod as $key => $plugin)
            @includeIf($plugin['pathPlugin'].'::render')
        @endforeach

        @include($templatePath.'.cart.render_total')
    </div>
</div>
