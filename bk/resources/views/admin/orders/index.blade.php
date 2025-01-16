@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Orders</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h4>List Orders</h4>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('order')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Mã đơn hàng" value="{{ request('keyword')??'' }}">
                                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <a class="btn {{ request('status')!='' ? 'btn-outline-primary' : 'btn-primary' }}" href="{{ url()->current() }}">Tất cả</a>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                {!! $orders->appends(request()->input())->links() !!}
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Tên khách hàng</th>
                                        <th scope="col" class="text-center">Thời gian đặt</th>
                                        <th scope="col" class="text-center">Tổng tiền</th>
                                        <th scope="col" class="text-center">Vận chuyển</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($orders as $data)
                                    @php
                                        $payment = \App\Model\PaymentRequest::where('cart_id', $data->cart_id)->first();
                                        $shipping_order = $data->getShippingOrder;
                                    @endphp
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->cart_id}}" name="seq_list[]" value="{{$data->cart_id}}"></td>
                                        <td class="text-center">
                                            <a class="row-title" href="{{route('admin.orderDetail', array($data->id))}}">
                                                <b>{{$data->code}}</b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-danger">{{ $data->first_name }}</div>
                                            {{ $data->email }}
                                        </td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                        </td>
                                        <td class="text-center">
                                            <span class='b text-danger'>{!! sc_currency_render_symbol($data->total ?? 0, $data->currency) !!}</span>
                                        </td>
                                        <td class="text-center">
                                            {{ sc_currency_render_symbol($data->shipping ?? 0, $data->currency) }}
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info cart-status-{{ $data->cart_status }}">{{ $statusOrder[$data->status]??'' }}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $orders->appends(request()->input())->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
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
        color: #fff !important;
    }

</style>