@php
    $delivery = $shippingAddress['delivery']??'';
@endphp
<ul class="list-group mb-3">
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                @if($delivery == 'shipping')
                    @lang('Giao hàng tận nơi')
                @else
                        <p>@lang('Nhận hàng tại cửa hàng')</p>
                        <div>
                            {!! $shipping_detail !!}
                        </div>
                @endif
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                <div class="d-flex">
                    <div style="width: 150px;">Người nhận</div>
                    <div style="flex: 1;">
                        <div>Họ tên: {{ $shippingAddress['fullname'] }}</div>
                        <div>Điện thoại: {{ $shippingAddress['phone'] }}</div>
                        <div>Email: {{ $shippingAddress['email'] }}</div>
                        @if(!empty($shippingAddress['address_full']))
                        <div>Địa chỉ: {{ $shippingAddress['address_full'] }}</div>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-2 text-right">
                @isset($product)
                <a href="{{ route('shop.buyNow', $product->id) }}" title="">Thay đổi</a>
                @else
                <a href="{{ route('cart.checkout', ['edit' => 'checkout']) }}" title="">Thay đổi</a>
                @endisset
            </div>
        </div>
    </li>
    
</ul>