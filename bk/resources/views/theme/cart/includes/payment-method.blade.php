@php
    $payment_methods = \App\Model\ShopPaymentMethod::where('status', 1)->get();
    $payment_method = $payment_method ?? $cart_info['payment_method']??'';
@endphp

<div class="your-payment">
    <h4 class="order-title mt-4 mb-3">Phương thức thanh toán</h4>
    @foreach($payment_methods as $index => $item)
    @php
        $checked = '';
        if($payment_method == '' && $index == 0)
            $checked = 'checked';
        elseif($payment_method == $item->code)
            $checked = 'checked';

    @endphp
    <div class="payment-item mb-3">
        <div class="custom-control custom-radio mr-2">
            <input type="radio" id="payment_{{ $item->code }}" name="payment_method" value="{{ $item->code }}" class="custom-control-input" {{  $checked }}>
            <label class="custom-control-label" for="payment_{{ $item->code }}">
                <img src="{{ asset($item->image) }}" alt="" width="50">
                {{ $item->name }}
            </label>
        </div>

        @if($payment_method == $item->code && view()->exists($templatePath .'.payment.includes.'. $item->code))
            @include($templatePath .'.payment.includes.'. $item->code)
        @endif
        
    </div>
    @endforeach
    <div class="payment-method">                                    
        <div class="order-button-payment"></div>
    </div>
</div>