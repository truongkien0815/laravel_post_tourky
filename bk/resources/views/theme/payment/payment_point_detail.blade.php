@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('body_class', 'user-page')
@section('content')
<section class="filmoja-pricing-area my-5">
   <div class="container">
      
      <div class="row justify-content-center my-5">
         <div class="col-lg-12">
            <div class="p-3 bg-white">
               <div class="text-center mb-4">
                  <h2>Bạn đã đặt mua</h2>
               </div>
               <div class=" mb-1">
                  Mã đơn: <b>{{ $payment->payment_code }}</b> 
                  <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code }}">Copy</button>
               </div>
               <div class=" mb-1">
                  Đơn hàng: <b>{{ $package->name }}</b>
               </div>
               <div class=" mb-1">
                  Thời gian: {{ date('H:i d-m-Y', strtotime($payment->created_at)) }}
               </div>
               <div class="mb-1">
                  Trạng thái: 
                  @if($payment->status == 1)
                  <span class="text-success">Đã thanh toán</span>
                  @else
                  <span class="text-danger">Chưa thanh toán</span>
                  @endif
               </div>
               @if($payment->status == 1)

               @else
               <div>Thời gian kích hoạt: Ngay lập tức khi chuyển khoản</div>
               <div class="row my-2">
                  <div class="col-md-12 text-end">
                     <a href="{{ route('purchase.cancel', $payment->id) }}" class="fs-sm btn btn-danger">Hủy đơn</a>
                  </div>
               </div>
               @endif
            </div> 
         </div>
      </div>
      @if($payment->status != 1)
      <div class="row justify-content-center my-5">
         <div class="col-lg-12">
            <div class="p-3 bg-white">
               <div class="text-center mb-4">
                  <h2>Thông tin chuyển khoản và thanh toán</h2>
               </div>
               {!! setting_option('thong-tin-chuyen-khoan') !!}
               <div>
                  Nội dung chuyển khoản: <b>{{ $payment->payment_code??'' }}</b>
                  <button class="btn btn-primary btn-copy" style="margin-left:5px;padding:1px 2px;vertical-align: middle;font-size: 12px;" data-clipboard-text="{{ $payment->payment_code??'' }}">Copy</button>
               </div>

            </div> 
         </div>
      </div>
      @endif
   </div>
</section>

<section class="filmoja-pricing-area my-5">
   <div class="container">
      <div class="text-left m-t-10 bg-white my-3 p-3">
         <div class="text-danger mb-2 text-center fw-bold" style="font-size: 15px;">BẢNG GIÁ VIP</div>
         <div class="mb-2 mt-2 text-center text-success fw-bold" style="font-size: 13px;">Chú ý: 1 lượt VIP = Tra cứu cho 1 người toàn bộ 26 chỉ số cùng luận giải chi tiết + file PDF báo cáo dài 60-70 trang lưu vĩnh viễn.</div>
         <table class="text-center table table-bordered font-weight-bold" style="font-size: 12px;">
            <tbody>
               <tr class="table-danger">
                  <th>Gói VIP</th>
                  <th>Giá</th>
                  <th></th>
               </tr>
               @foreach($packages as $package)
               <tr>
                  <td>{{ $package->name }}</td>
                  <td class="text-left">
                     @if($package->code == "VIPDB")
                        <div>Gặp trực tiếp chuyên gia luận giải và hỏi đáp 1-1.</div>
                     @endif
                     Giá gốc: 
                     @if($package->promotion != 0)
                        @php
                           $price_sale = $package->promotion * 100 / $package->price;
                        @endphp
                        <span style="text-decoration-line: line-through; font-size:14px; color: #999;">{{ number_format($package->price) }}đ</span> -{{ number_format($price_sale) }}%<br>
                        Chỉ còn: <span style="color:red;font-size:16px;">{{ number_format($package->promotion) }}đ</span>
                     @else
                        Giá: <span style="color:red;font-size:16px;">{{ number_format($package->price) }}đ</span>
                     @endif
                     @if($package->code == "VIPDB")
                        <div>Liên hệ hotline: <a href="tel:{{ setting_option('hotline') }}">{{ setting_option('hotline') }}</a> để đặt lịch.</div>
                     @endif
                  </td>
                  <td>
                     <a href="{{ route('purchase.detail', $package->id) }}" class="btn btn-danger">Mua ngay</a>
                  </td>
               </tr>
               @endforeach
            </tbody>
         </table>
      </div>
   </div>
</section>

@endsection

@push('styles')
   <style type="text/css">
      .filmoja-pricing-area{
         font-size: 14px;
         color: #000;
      }
      .filmoja-pricing-area .btn{
         font-size: 13px;
         border-radius: 3px;
      }
   </style>
@endpush
@push('scripts')
   <script src="{{ asset( $templateFile .'/js/clipboard.min.js' ) }}"></script>
<script>
   var clipboard = new ClipboardJS('.btn-copy', {
        target: function () {
          return document.querySelector('button');
        },
      });

   clipboard.on('success', function (e) {
     e.trigger.innerHTML = '<i class="fas fa-check"></i> Copied!';
     setTimeout(function() { 
        e.trigger.innerHTML = 'Copy';
    }, 1000);
   });

      clipboard.on('error', function (e) {
        console.info('Action:', e.action);
        console.info('Text:', e.text);
        console.info('Trigger:', e.trigger);
      });

	jQuery(document).ready(function($) {
      $('.select-package').click(function(){
         var id = $(this).attr('data');
         $('.single-pricing-box').removeClass('active');
         $(this).closest('.single-pricing-box').addClass('active');
         $('.payment-content').show();

         $('input[name="package_id"]').val(id);
      });

		var paymentCheckout = $('#paymentCheckout');
      if(paymentCheckout.length>0){
         paymentCheckout.validate({
          onfocusout: false,
          onkeyup: false,
          onclick: false,
          rules: {
              bank_code: "required",
              amount: "required",
          },
          messages: {
              bank_code: "Vui lòng chọn hình thức thanh toán",
              amount: "Vui lòng nhập số tiền bạn muốn nạp",
          },
          errorElement : 'div',
          errorLabelContainer: '.errorTxt',
          invalidHandler: function(event, validator) {
              $('html, body').animate({
                  scrollTop: 0
              }, 500);
          }
      });

      $(document).on('change', 'input[name="paypent-type"]', function(){
         var val = $(this).val();
         
         axios({
            method: 'get',
            url: '/payment-type?type='+val,
         }).then(res => {
            if(res.data.view != '')
               $('.select-include').html(res.data.view);
         }).catch(e => console.log(e));
      });

      $('input[name="amount"]').on('input', function(){
        $(this).val(POTENZA.number_format($(this).val()))
      })
      
      $('.btn-payment-checkout').click(function(){
        if(paymentCheckout.valid()){
          var bank_code = '';
          var bank_code_list = $('.select-include').find('input[type="radio"]');
          if(bank_code_list.length > 0)
           bank_code = $("input[type='radio'][name='bank_code']:checked").val();
            else
              bank_code = $('input[name="bank_code"]').val('');

            if(bank_code)
              paymentCheckout.submit();
            else{
              $('html,body').animate({
                  scrollTop: $(".select-include").offset().top
              }, 'slow');
            }
         
          
        }
      })
    }
	});
</script>
@endpush