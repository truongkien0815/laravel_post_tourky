@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('body_class', 'user-page')
@section('content')

<section class="filmoja-pricing-area my-5">
   <div class="container">
      <div class="text-left m-t-10 bg-white my-3 p-3">
         <div class="text-danger mb-2 text-center fw-bold" style="font-size: 15px;">BẢNG GIÁ VIP</div>
         <!-- <div class="mb-2 mt-2 text-center text-success fw-bold" style="font-size: 13px;">Chú ý: 1 lượt VIP = Tra cứu cho 1 người toàn bộ 26 chỉ số cùng luận giải chi tiết + file PDF báo cáo dài 60-70 trang lưu vĩnh viễn.</div> -->
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
                  <td class="text-center">
                     <a href="{{ route('purchase.process', $package->id) }}" class="btn btn-danger">Mua ngay</a>
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
<style>
   table a{
      color: #007bff;
   }
   .btn{
       font-size: 13px;
   }
    .table td, .table th{
        vertical-align: middle;
        font-weight: 600;
        color: #000;
    }
    .table td{
      text-align: left;
    }
    .table tr:hover td{background: #f8f8f8}
    .blinker {animation: blinker 1s linear infinite;}
    @keyframes blinker { 50% { opacity: 0; }}

    .video-container {
        position: relative;
        padding-bottom: 60%; /* 16:9 */
        height: 0;
    }
    .video-container iframe {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
</style>
@endpush
@push('after-footer')
@endpush