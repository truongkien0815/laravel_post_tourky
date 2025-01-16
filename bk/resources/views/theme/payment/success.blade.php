@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
	<section class="payment-success">
    	<div class="payment-success-bg">
    		<!-- <img src="{{ asset('/images/bg-payment-success.jpg') }}" class="img-fluid" alt=""> -->
    	</div>
    	<div class="container">
    		<div class="row justify-content-center my-5">
	    		<div class="col-lg-6">
	    			<div class="p-3 bg-light">
			        	<div class="text-center mb-4">
			                <p><img src="{{ asset('assets/images/circle-icon.png') }}" width="100" alt=""></p>
			                <h2>{{ $title }} thành công</h2>
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
			            <div class="row mb-1">
			            	<div class="col-md-6">Ngân hàng</div>
			            	<div class="col-md-6 text-md-end">{{ $payment->bank_code }}</div>
			            </div>
			            <div class="row mb-1">
			            	<div class="col-md-6">Họ tên</div>
			            	<div class="col-md-6 text-md-end">{{ $cart->name }}</div>
			            </div>
			            <div class="row mb-1">
			            	<div class="col-md-6">Số điện thoại</div>
			            	<div class="col-md-6 text-md-end">{{ $cart->cart_phone }}</div>
			            </div>
			            <div class="row">
			            	<div class="col-md-6">Email</div>
			            	<div class="col-md-6 text-md-end">{{ $cart->cart_email }}</div>
			            </div>
			            <div class="row my-2 fw-bold">
			            	<div class="col-md-6">Tổng tiền thanh toán</div>
			            	<div class="col-md-6 text-md-end">{!! render_price($payment->amount ) !!} vnđ</div>
			            </div>
			            <div class="row mb-4">
			            	<div class="col-md-6">Mã thanh toán</div>
			            	<div class="col-md-6 text-md-end">{{ $payment->payment_code }}</div>
			            </div>
			            <div class="text-center">
			                <a class="btn btn-main" href="{{url('/')}}">Trang chủ</a>
			            </div>
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