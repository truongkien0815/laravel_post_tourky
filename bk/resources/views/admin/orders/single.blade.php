@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')

<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="bg-white p-3">
         @if (!$order)
         <div class="text-danger">
            {{ sc_language_render('front.data_notfound') }}
         </div>
         @else
         <div class="row" id="order-body">
            <div class="col-sm-6">
               <table class="table table-bordered">
                  <tr>
                     <td class="td-title">{{ sc_language_render('order.first_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="first_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.first_name') }}" >{!! $order->first_name !!}</a></td>
                  </tr>

                  @if (sc_config_admin('customer_lastname'))
                  <tr>
                     <td class="td-title">{{ sc_language_render('order.last_name') }}:</td><td><a href="#" class="updateInfoRequired" data-name="last_name" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.last_name') }}" >{!! $order->last_name !!}</a></td>
                  </tr>
                  @endif

                  <tr>
                     <td class="td-title">{{ sc_language_render('order.phone') }}:</td>
                     <td>
                        <a href="#" class="updateInfoRequired" data-name="phone" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.phone') }}" >{!! $order->phone !!}</a>
                     </td>
                  </tr>

                  <tr>
                     <td class="td-title">{{ sc_language_render('order.email') }}:</td><td>{!! empty($order->email)?'N/A':$order->email!!}</td>
                  </tr>

                  @if (sc_config_admin('customer_company'))
                  <tr>
                     <td class="td-title">{{ sc_language_render('order.company') }}:</td><td><a href="#" class="updateInfoRequired" data-name="company" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.company') }}" >{!! $order->company !!}</a></td>
                  </tr>
                  @endif

                  @if (sc_config_admin('customer_postcode'))
                  <tr>
                     <td class="td-title">{{ sc_language_render('order.postcode') }}:</td><td><a href="#" class="updateInfoRequired" data-name="postcode" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.postcode') }}" >{!! $order->postcode !!}</a></td>
                  </tr>
                  @endif


                  <tr>
                     <td class="td-title">{{ sc_language_render('order.address1') }}:</td>
                     <td>
                        <a href="#" class="updateLocation" data-name="address1" data-type="select" 
                           data-source ="{{ json_encode($provinces) }}" 
                           data-pk="{{ $order->id }}" 
                           data-value="{!! $order->address1 !!}" 
                           data-url="{{ route("admin_order.update") }}" 
                           data-title="{{ $order->address1 }}">
                           {{ $order->address1 }}
                        </a>
                     </td>
                  </tr>

                  <tr>
                     <td class="td-title">{{ sc_language_render('order.address2') }}:</td>
                     <td>
                        <a href="#" class="updateLocation district_change" data-name="address2" data-type="select" 
                           data-source ="{{ json_encode($districts) }}" 
                           data-pk="{{ $order->id }}" 
                           data-value="{!! $order->address2 !!}" 
                           data-url="{{ route("admin_order.update") }}" 
                           data-title="{{ $order->address2 }}">
                           {{ $order->address2??'Chọn Quận/huyện' }}
                        </a>
                     </td>
                  </tr>
                  <tr>
                     <td class="td-title">{{ sc_language_render('order.address3') }}:</td>
                     <td>
                        <a href="#" class="updateInfoRequired" data-name="address3" data-type="text" data-pk="{{ $order->id }}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.address3') }}" >{!! $order->address3 !!}</a>
                     </td>
                  </tr>
               </table>
            </div>
            <div class="col-sm-6">
               <table  class="table table-bordered">
                  <tr>
                     <td  class="td-title">{{ sc_language_render('order.order_status') }}:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="status" data-type="select" data-source ="{{ json_encode($statusOrder) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.order_status') }}">{{ $statusOrder[$order->status] ?? $order->status }}</a>
                     </td>
                  </tr>
                  <tr>
                     <td>{{ sc_language_render('order.shipping_status') }}:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="shipping_status" data-type="select" data-source ="{{ json_encode($statusShipping) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_status') }}">{{ $statusShipping[$order->shipping_status]??$order->shipping_status }}</a>
                     </td>
                  </tr>
                  <tr>
                     <td>{{ sc_language_render('order.payment_status') }}:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="payment_status" data-type="select" data-source ="{{ json_encode($statusPayment) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_status !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_status') }}">{{ $statusPayment[$order->payment_status]??$order->payment_status }}</a>
                     </td>
                  </tr>
                  <tr>
                     <td>{{ sc_language_render('order.shipping_method') }}:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="shipping_method" data-type="select" data-source ="{{ json_encode($shippingMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->shipping_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.shipping_method') }}">{{ $order->getShippingOrder->name }}</a>
                     </td>
                  </tr>
                  <tr>
                     <td>{{ sc_language_render('order.payment_method') }}:</td>
                     <td>
                        <a href="#" class="updateStatus" data-name="payment_method" data-type="select" data-source ="{{ json_encode($paymentMethod) }}"  data-pk="{{ $order->id }}" data-value="{!! $order->payment_method !!}" data-url="{{ route("admin_order.update") }}" data-title="{{ sc_language_render('order.payment_method') }}">{{ $order->getPaymentMethodOrder->name??'' }}</a>
                     </td>
                  </tr>
                  <tr>
                     <td>{{ sc_language_render('order.domain') }}:</td>
                     <td>{{ $order->domain }}</td></tr>
                  <tr>
                     <td></i> {{ sc_language_render('admin.created_at') }}:</td>
                     <td>{{ $order->created_at }}</td></tr>
               </table>
               </div>
            </div>

                    <div class="row">
                       <div class="col-sm-12">
                          <div class="box collapsed-box">
                             <div class="table-responsive">
                                <table class="table table-bordered">
                                   <thead>
                                      <tr>
                                         <th>{{ sc_language_render('product.name') }}</th>
                                         <th>{{ sc_language_render('product.sku') }}</th>
                                         <th class="product_price">{{ sc_language_render('product.price') }}</th>
                                         <th class="product_qty">{{ sc_language_render('product.quantity') }}</th>
                                         <th class="product_total">{{ sc_language_render('order.totals.sub_total') }}</th>
                                         <th class="product_tax">{{ sc_language_render('product.tax') }}</th>
                                      </tr>
                                   </thead>
                                   <tbody>
                                      @foreach ($order->details as $item)
                                      <tr>
                                         <td>{{ $item->name }}
                                            {{--
                                            @php
                                               $html = '';
                                               if($item->attribute && is_array(json_decode($item->attribute,true))){
                                                  $array = json_decode($item->attribute,true);
                                                  foreach ($array as $key => $element){
                                                     $html .= '<br><b>'.$attributesGroup[$key].'</b> : <i>'.$element.'</i>';
                                                  }
                                               }
                                            @endphp
                                            {!! $html !!}
                                            --}}
                                         </td>
                                         <td>{{ $item->sku }}</td>
                                         <td class="product_price">{{ $item->price }}</td>
                                         <td class="product_qty">x  {{ $item->qty }}</td>
                                         <td class="product_total item_id_{{ $item->id }}">{{ sc_currency_render_symbol($item->total_price,$order->currency)}}</td>
                                         <td class="product_tax">{{ $item->tax }}</td>
                                      </tr>
                                      @endforeach
                                   </tbody>
                                </table>
                             </div>
                          </div>
                       </div>
                    </div>
                    @php
                    $dataTotal = \App\Model\ShopOrderTotal::where('order_id',$order->id)->get();
                    @endphp
                    <div class="row">
                       <div class="col-md-12">
                          <div class="box collapsed-box">
                             <table   class="table table-bordered">

                                @foreach ($dataTotal as $element)
                                   @if($element['value'] != 0)
                                      @if ($element['code'] =='subtotal')
                                         <tr>
                                            <td  class="td-title-normal">{!! $element['title'] !!}:</td>
                                            <td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td>
                                         </tr>
                                      @endif
                                      @if ($element['code'] =='tax')
                                      <tr>
                                         <td  class="td-title-normal">{!! $element['title'] !!}:</td>
                                         <td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td>
                                      </tr>
                                      @endif
                                      @if ($element['code'] =='shipping')
                                      <tr>
                                         <td>{!! $element['title'] !!}:</td>
                                         <td style="text-align:right">{{ sc_currency_format($element['value']) }}</td>
                                      </tr>
                                      @endif
                                      @if ($element['code'] =='discount')
                                      <tr>
                                         <td>{!! htmlspecialchars_decode($element['title']) !!}(-):</td>
                                         <td style="text-align:right">{{ sc_currency_format($element['value']) }}</td>
                                      </tr>
                                      @endif
                                      @if ($element['code'] =='total')
                                      <tr style="background:#f5f3f3;font-weight: bold;">
                                         <td>{!! $element['title'] !!}:</td>
                                         <td style="text-align:right" class="data-{{ $element['code'] }}">{{ sc_currency_format($element['value']) }}</td>
                                      </tr>
                                      @endif
                                      @if ($element['code'] =='received')
                                      <tr>
                                         <td>{!! $element['title'] !!}(-):</td>
                                         <td style="text-align:right">{{ sc_currency_format($element['value']) }}</td>
                                      </tr>
                                      @endif
                                   @endif
                                @endforeach
                                <tr class="data-balance">
                                   <td>{{ sc_language_render('order.totals.balance') }}:</td>
                                   <td style="text-align:right">{{ sc_currency_format($order->balance) }}</td>
                                </tr>
                             </table>
                          </div>
                       </div>
                    </div>
                    @endif
                </div>
   </div> <!-- /.container-fluid -->
</section>
<script>
   $(function () {
    editorQuote('admin_note');
   })
</script>
@endsection
@push('styles')
   <link rel="stylesheet" href="{{ asset('assets/plugin/bootstrap-editable.css')}}">
   <style type="text/css" media="screen">
      .shipping_log .active{
         color: #2784f7;
      }
   </style>
@endpush
@push('scripts')
<!-- Ediable -->
<script src="{{ asset('assets/plugin/bootstrap-editable.min.js')}}"></script>

<script src="{{ asset('/js/ghn.js?ver='. time()) }}"></script>
<script>
   jQuery(document).ready(function($) {
      const showLoading = function() {
         Swal.fire({
            title: 'Đang xử lý',
             allowEscapeKey: false,
             allowOutsideClick: false,
             timer: 15000,
             didOpen: () => {
               swal.showLoading();
             }
         })
         .then(
          () => {},
          (dismiss) => {
            if (dismiss === 'timer') {
              console.log('closed by timer!!!!');
              swal({ 
                title: 'Finished!',
                type: 'success',
                timer: 2000,
                showConfirmButton: false
              })
            }
          }
         )
      };
      $('#shipping_create_order').click(function(event) {
         Swal.fire({
            title: "TẠO ĐƠN VẬN CHUYỂN GHN",
            text: 'Bạn có chắc tạo đơn vận chuyển với đơn vị vận chuyển GHN',
            showCancelButton: true,
            confirmButtonText: 'Xác nhận',
            imageUrl: '{{ asset("assets/images/ghn-icon.png") }}',
            imageHeight: 50
         }).then((result) => {
            
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
               showLoading();
               var form = document.getElementById('frm-order-detail'),
                   fdnew = new FormData(form);
               axios({
                   method: 'post',
                   url: '{{ route("ghn.create_order") }}',
                   data: fdnew
               }).then(res => {
                  if(res.data.error==0)
                  {
                     $('#shipping_create_order').remove();
                     Swal.fire('Tạo đơn hàng thành công', '', 'success');
                  }
                  else
                     Swal.fire(res.data.message, '', 'error');
   
               }).catch(e => console.log(e));
   
            }
         })
      });
   
      //shipping 
      $('select[name="shipping_company"]').change(function(){
         var cart_id = $('input[name="cart_id"]').val(),
            company = $(this).val();

         $('#shipping_create_order').hide();
         if(company == 'ghn')
         {
            $('#shipping_create_order').show();
            getShippingCart(cart_id);
         }
      });
      //shipping 

      $.fn.editable.defaults.params = function (params) {
        params._token = "{{ csrf_token() }}";
        return params;
      };
      $('.updateLocation').editable({
         validate: function(value) {
            if (value == '') {
               return 'Not empty';
            }
         },
         success: function(response) {
            if(response.error ==0){
                if(response.data)
                {
                  if(typeof(response.data.districts) != 'undefined')
                  {
                     $('.district_change').editable('setValue', null).editable("option", "source", JSON.stringify(response.data.districts));
                     $('.district_change').editable("enable");
                  }
                  if(typeof(response.data.wards) != 'undefined')
                  {
                     $('.ward_change').editable('setValue', null).editable("option", "source", JSON.stringify(response.data.wards));
                     $('.ward_change').editable("enable");
                  }
               }
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });

      $('.updateStatus').editable({
         validate: function(value) {
            if (value == '') {
               return '{{  sc_language_render('admin.not_empty') }}';
            }
         },
         success: function(response) {
            if(response.error ==0){
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });

      $('.updateInfoRequired').editable({
         validate: function(value) {
            if (value == '') {
                return 'Not empty';
            }
         },
         success: function(response,newValue) {
            console.log(response.msg);
            if(response.error == 0){
               alertJs('success', response.msg);
            } else {
               alertJs('error', response.msg);
            }
         }
      });
   });
</script>
@endpush