@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')

@php
    if(!empty($post))
        extract($post->toArray());
    $id = $id??0;
@endphp

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title }}</li>
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
	      	<div class="col-lg-12">
	        	<div class="card">
		          	<div class="card-header d-flex justify-content-between">
		            	<h3 class="card-title">{{ $title }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">

                        <ul class="nav fl mb-3">
                            <li class="nav-item">
                                <a class="btn btn-danger" onclick="delete_post('{{ $url_delete_list }}')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ $url_action }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th>Title</th>
                                        <th class="text-center">Giá trị</th>
                                        <th class="text-center">Loại</th>
                                        <th>Thông tin</th>
                                        <th class="text-center">Đã dùng</th>
                                        <th>Hết hạn</th>
                                        <th class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                    <tr class="item-{{ $data->id }} {{ $data->id == $id ?'table-active':'' }}">
                                        <td class="text-center"><input type="checkbox" id="{{$data->id}}" name="post_list[]" value="{{$data->id}}"></td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin_discount.edit', array($data->id))}}">
                                                <b>{{$data->code}}</b>
                                                <br>
                                                <b style="color:#c76805;">{{$data->slug}}</b>                                
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $data->reward }}</td>
                                        <td class="text-center">{{ $data->type == 'point'?'Point':'%' }}</td>
                                        <td>{{ $data->data }}</td>
                                        <td class="text-center">{{ $data->used }}/{{ $data->limit }}</td>
                                        <td>{{ $data->expires_at }}</td>
                                        <td class="text-center">
                                            @if($data->status)
                                                <span class="badge badge-success">ON</span>
                                            @else
                                                <span class="badge badge-danger">OFF</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $posts->links() !!}
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
            
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
@endpush