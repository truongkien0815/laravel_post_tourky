@php
    $payment_methods = (new \App\Model\ShopPaymentMethod)->getListActive();
    $payment_method = $cart_info['payment_method']??'';
    //dd($payment_method);
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
        @elseif($item->content)
            <div class="payment-content {{  $checked?'active':'' }}">
                {!! htmlspecialchars_decode(htmlspecialchars_decode($item->content)) !!}
            </div>
        @endif
        @if($item->posts()->count())
            <div class="select-include" style="display: none;">
                <div class="banklist mt-3">
                    <label class="mb-2">Bạn hãy chọn ngân hàng <span class="redcolor">*</span></label>
                    <br>

                    <div class="d-flex flex-wrap">
                        @foreach($item->posts as $item)
                        <label>
                            <input type="radio" name="bank_code" value="{{ $item->code }}" {{ session("bank_code") == $item->code ? 'checked' : '' }}>
                            <div class="img">
                                <img src="{{ asset($item->image) }}" title="{{ $item->name }}">
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
    @endforeach
    <div class="payment-method">                                    
        <div class="order-button-payment"></div>
    </div>
</div>