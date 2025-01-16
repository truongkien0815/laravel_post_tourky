@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<div class="container">
   <div class="row justify-content-end">
      <div class="col-lg-3  col-12 mb-4">
          @include($templatePath .'.customer.includes.sidebar-customer')
      </div>
      <div class="col-lg-9 col-12">
         @if (count($orders) ==0)
            <div class="text-danger">
               {{ sc_language_render('front.data_notfound') }}
            </div>
         @else
            <div class="section-title mb-3 text-center">
               <h4>Đơn hàng của bạn</h4>
            </div>
            <div class="table-responsive fs-md mb-4">
               <table class="table table-hover mb-0">
                  <thead>
                     <tr>
                        <th style="width: 50px;">No.</th>
                        <th style="width: 200px;">ID</th>
                        <th>{{ sc_language_render('order.total') }}</th>
                        <th>{{ sc_language_render('order.order_status') }}</th>
                        <th>{{ sc_language_render('common.created_at') }}</th>
                        <th></th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($orders as $order)
                     @php
                     $n = (isset($n)?$n:0);
                     $n++;
                     @endphp
                     <tr>
                        <td><span class="item_21_id">{{ $n }}</span></td>
                        <td><span class="item_21_sku">#{{ $order->id }}</span></td>
                        <td align="right">
                           {{ number_format($order->total) }}
                        </td>
                        <td class="text-center">
                           <span class="badge bg-info m-0">{{ $statusOrder[$order->status]}}</span>
                        </td>
                        <td>{{ $order->created_at }}</td>
                        <td>
                           <a href="{{ route('customer.order_detail', ['id' => $order->id ]) }}"><i class="fa fa-indent" aria-hidden="true"></i> {{ sc_language_render('order.detail') }}</a>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         @endif
      </div>
   </div>
</div>
@endsection
<style type="text/css">
    .cart-status-1{
        color: #fff !important;
        background-color: #007bff!important;
    }
    .cart-status-2{
        color: #fff !important;
        background-color: #17a2b8!important;
    }
    .cart-status-3{
        color: #fff !important;
        background-color: #dc3545!important;
    }
    .cart-status-4{
        background-color: #ffc107!important;
    }
    .cart-status-5{
        background-color: #28a745!important;
    }

</style>