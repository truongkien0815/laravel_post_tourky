@php
	$bank_code = $bank_code??'';
@endphp

<div class="select-include">
	<div class="banklist banklist-visa text-start mt-3">
		<label class="mb-2">Bạn hãy chọn loại thẻ <span class="redcolor">*</span> </label>
		<div class="d-flex flex-wrap">
			<label>
				<input type="radio" name="bank_code" value="VISA" class="d-none" {{ $bank_code == 'VISA' ? 'checked' : '' }}>
				<div class="img py-1">
					<img src="{{ asset('assets/images/visa/visa_logo.png') }}" rel="VISA" title="Thẻ quốc tế Visa">
				</div>
			</label>
			<label>
				<input type="radio" name="bank_code" value="MASTERCARD" class="d-none" {{ $bank_code == 'MASTERCARD' ? 'checked' : '' }}>
				<div class="img py-1">
					<img src="{{ asset('assets/images/visa/mastercard_logo.png') }}" rel="MASTERCARD" title="Thẻ quốc tế MasterCard">
				</div>
			</label>
			<label>
				<input type="radio" name="bank_code" value="JCB" class="d-none" {{ $bank_code == 'JCB' ? 'checked' : '' }}>
				<div class="img py-1">
					<img src="{{ asset('assets/images/visa/jcb_logo.png') }}" rel="JCB" title="Thẻ quốc tế JCB">
				</div>
			</label>
			
			<label>
				<input type="radio" name="bank_code" value="UPI" class="d-none" {{ $bank_code == 'UPI' ? 'checked' : '' }}>
				<div class="img py-1">
					<img src="{{ asset('assets/images/visa/upi_logo.png') }}" rel="UPI" title="UnionPay International">
				</div>
			</label>
		
		</div>
	</div>
</div>