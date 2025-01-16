@extends('admin.layouts.app')

@section('seo')
    <title>Thành viên</title>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">{{ $title }}</h1>
      </div><!-- /.col -->
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
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title">{{ $title }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <ul class="nav">
                            <li class="nav-item">
                                <a class="btn btn-danger" onclick="delete_id('client-category')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                            </li>
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{ $url_create }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Email</th>
                                        <th scope="col">Hình ảnh</th>
                                        <th scope="col">Date</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $user)
                                    <tr>
                                        <td>
                                            <a href="{{ route('admin_user.edit', $user->id) }}" title="">{{ $user->fullname }}</a>
                                                @php
                                                $label_user = "";
                                                if($user->expert>=1 && $user->status_package_doc==1){
                                                    $label_user = 'Tác giả, đăng ký gói trả phí';
                                                }
                                                elseif($user->expert>=1 && $user->status_package_doc==2){
                                                    $label_user = 'Tác giả, đăng ký gói trả phí';
                                                }
                                                elseif($user->expert>=1){
                                                  $label_user = 'Tác giả';  
                                                }
                                                elseif($user->status_package_doc==1 || $user->status_package_doc==2){
                                                    $label_user = 'Đăng ký gói trả phí';  
                                                }
                                                @endphp
                                               
                                                <span class="badge badge-primary">{{$label_user}}</span>
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td class="text-center">
                                            @if($user->avatar)
                                            <img src="{{ asset($user->avatar) }}" alt="" height="70" style="height: 70px;">
                                            @endif
                                        </td>
                                        <td>
                                            @if($user->status == 0)
                                            <span class="badge badge-danger">Ngưng hoạt động</span>
                                            @else
                                            <span class="badge badge-success">Hoạt động</span>
                                            @endif
                                            <br>
                                            {!! $user->created_at !!}
                                        </td>
                                        <td>
                                            <a href="{{ route('admin_user.edit', $user->id) }}" class="btn btn-outline-primary btn-sm"><i class="fa fa-pen"></i> Edit</a><a href="" title=""></a>
                                            <a href="{{ route('admin_user.delete', $user->id) }}" class="btn btn-outline-danger btn-sm btn_deletes"><i class="fa fa-trash"></i> Remove</a><a href="" title=""></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $('#deleteBtn').click(function() {
            if(confirm('Bạn có chắc muốn xóa tài khoản này?')){
                return true;
            }
            return false;
        });
        
    });
</script>
@endsection