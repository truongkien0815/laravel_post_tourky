@extends($templatePath .'.layouts.index')

@section('seo')
@include($templatePath .'.layouts.seo', $seo??[] )
@endsection

@section('content')
<section class="py-5 my-post bg-light  position-relative">
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-lg-3  col-12 mb-4">
                @include($templatePath .'.customer.includes.sidebar-customer')
            </div>
            <div class="col-lg-9 col-12">
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
                                <td class="td-title">{{ sc_language_render('order.first_name') }}:</td>
                                <td>{!! $order->first_name !!}</td>
                             </tr>
                             @if (sc_config('customer_lastname'))
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.last_name') }}:</td>
                                <td>{!! $order->last_name !!}</td>
                             </tr>
                             @endif
                             @if (sc_config('customer_phone'))
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.phone') }}:</td>
                                <td>{!! $order->phone !!}</td>
                             </tr>
                             @endif
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.email') }}:</td>
                                <td>{!! empty($order->email)?'N/A':$order->email!!}</td>
                             </tr>
                             @if (sc_config('customer_company'))
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.company') }}:</td>
                                <td>{!! $order->company !!}</td>
                             </tr>
                             @endif
                             @if (sc_config('customer_postcode'))
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.postcode') }}:</td>
                                <td>{!! $order->postcode !!}</td>
                             </tr>
                             @endif
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.address1') }}:</td>
                                <td>{!! $order->address1 !!}</td>
                             </tr>
                             
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.address2') }}:</td>
                                <td>{!! $order->address2 !!}</td>
                             </tr>
                             
                             
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.address3') }}:</td>
                                <td>{!! $order->address3 !!}</td>
                             </tr>
                             
                             @if (sc_config('customer_country'))
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.country') }}:</td>
                                <td>{!! $countries[$order->country] ?? $order->country !!}</td>
                             </tr>
                             @endif
                          </table>
                       </div>
                       <div class="col-sm-6">
                          <table  class="table table-bordered">
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.order_status') }}:</td>
                                <td>{{ $statusOrder[$order->status] }}</td>
                             </tr>
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.payment_status') }}:</td>
                                <td>{{ $statusPayment[$order->payment_status]??$order->payment_status }}</td>
                             </tr>
                             <tr>
                                <td>{{ sc_language_render('order.shipping_status') }}:</td>
                                <td>{{ $statusShipping[$order->shipping_status]??'' }}</td>
                             </tr>
                             <tr>
                                <td>{{ sc_language_render('order.shipping_method') }}:</td>
                                <td>{{ $order->getShippingOrder->name }}</td>
                             </tr>
                             <tr>
                                <td>{{ sc_language_render('order.payment_method') }}:</td>
                                <td>{{ $order->getPaymentMethodOrder->name??'' }}</td>
                             </tr>
                             @if($order->exchange_rate != 1)
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.currency') }}:</td>
                                <td>{{ $order->currency }}</td>
                             </tr>
                             <tr>
                                <td class="td-title">{{ sc_language_render('order.exchange_rate') }}:</td>
                                <td>{{ ($order->exchange_rate)??1 }}</td>
                             </tr>
                             @endif
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
            </div>
        </div>
    </div>
    </section>
@endsection