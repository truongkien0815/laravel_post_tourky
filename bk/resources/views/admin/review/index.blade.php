@extends('admin.layouts.app')
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Ratings</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Ratings</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	    <div class="row">
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title">List Ratings</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('rating')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-striped projects" id="table_index">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th>Khách hàng/Link sản phẩm</th>
                                        <th>Point</th>
                                        <th>Nội dung</th>
                                        <th class="text-center">Thời gian</th>
                                        <th class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reviews as $data)
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="seq_list[]" value="{{$data->id}}"></td>
                                        <td>
                                            <a class="row-title" href="#">
                                                <b>{{$data->name}}</b>
                                            </a> <br>
                                            <a class="row-title" href="{{ route('shop.detail', $data->product->slug) }}" target="_blank">
                                                <b>{{ $data->product->name }}</b>
                                            </a>
                                        </td>
                                        <td>
                                            {!! $data->point !!} Sao
                                        </td>
                                        <td>
                                            {!! $data->comment !!}
                                        </td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                        </td>
                                        <td>
                                            <div class="form-group">
                                                <div class="custom-control custom-switch">
                                                    <input type="checkbox" class="custom-control-input" id="status_{{ $data->id }}" data-id="{{ $data->id }}" name="status" value="1" {{ $data->status ?'checked':'' }}>
                                                    <label class="custom-control-label" for="status_{{ $data->id }}">{{ $data->status ?'Hiển thị':'Ẩn' }}</label>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $reviews->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input[name="status"]').on('change', function(){
                var status = 0,
                    id = $(this).data('id');
                if ($(this).is(':checked')) {
                    $(this).attr('value', 'true');
                    $(this).next('label').text('Hiển thị');
                    status = 1;
                } else {
                    $(this).attr('value', 'false');
                    $(this).next('label').text('Ẩn');
                }

                axios({
                    method: 'post',
                    url: "{{ route('admin_review.updateStatus') }}",
                    data: {id:id, status:status}
                }).then(res => {
                    alertMsg('success', res.data.msg);
                }).catch(e => console.log(e));

            })
        });
    </script>
@endpush