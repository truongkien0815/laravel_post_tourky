@extends($templatePath .'.layout')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
	<section class="payment-success py-lg-5 py-4">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-lg-5">
					<div class="text-center mb-4">
				     <p><img src="{{ asset('theme/images/icons/cancel.png') }}" alt=""></p>
				     <h2>Thanh toán không thành công</h2>
				  </div>
				  <div class="row mb-1">
				  	<div class="col-md-6">Hình thức thanh toán</div>
				  	@if(in_array($payment->payment_method, ['qrcode', 'VNPay QR']))
				  		<div class="col-md-6 text-md-end">Thanh toán quét mã QR code VNPay</div>
				  	@elseif($payment->payment_method == 'banks')
				  		<div class="col-md-6 text-md-end">Thanh toán qua thẻ nội địa và tài khoản ngân hàng</div>
				  	@elseif($payment->vnp_CardType == 'visa')
				  		<div class="col-md-6 text-md-end">Thanh toán qua thẻ thanh toán quốc tế</div>
				  	@elseif($payment->vnp_CardType == 'vnpay')
				  		<div class="col-md-6 text-md-end">Thanh toán qua Ví điện tử VNPay</div>
				  	@endif
				  </div>
				  @if(!empty($package))
				  <div class="row mb-1">
				     	<div class="col-md-6">Gói tin</div>
				     	<div class="col-md-6 text-md-end">{{ $package->name }}</div>
				  </div>
				  @endif
				  @if(!empty($payment->vnp_BankCode))
				  <div class="row mb-1">
				  	<div class="col-md-6">Ngân hàng</div>
				  	<div class="col-md-6 text-md-end">{{ $payment->vnp_BankCode }}</div>
				  </div>
				  @endif
				  <div class="row my-2 fw-bold">
				  	<div class="col-md-6">Tổng tiền thanh toán</div>
				  	<div class="col-md-6 text-md-end">{{ number_format($payment->amount) }} vnđ</div>
				  </div>
				  @if(!empty($payment->vnp_TxnRef))
				  <div class="row mb-4">
				  	<div class="col-md-6">Mã thanh toán</div>
				  	<div class="col-md-6 text-md-end">{{ $payment->vnp_TxnRef }}</div>
				  </div>
				  @endif
				  @if(!empty($cart->cart_code))
				  <div class="row mb-4">
				  	<div class="col-md-6">Mã đơn hàng</div>
				  	<div class="col-md-6 text-md-end fw-bold">{{ $cart->cart_code }}</div>
				  </div>
				  @endif
				  <div class="text-center">
				      <a class="btn btn-secondary" href="{{url('/')}}">Trang chủ</a>
				      @if(!empty($payment->payment_url))
				      <a class="btn btn-primary" href="{{ $payment->payment_url }}">Thanh toán lại</a>
				      @endif
				  </div>
				</div>
			</div>
		</div>
	</section>
@push('after-footer')
	<script>
		jQuery(document).ready(function($) {
			$('#notifyModal').modal('show');
			$('#notifyModal').on('hidden.bs.modal', function (e) {
                window.location.href="/";
            })
		})
	</script>
@endpush
@endsection