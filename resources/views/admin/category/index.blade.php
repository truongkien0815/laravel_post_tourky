@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')
<div id="success" ></div>
@if (session('success'))

    <script>
         toastr.success("{{ session('success') }}");
    </script>
@endif
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Category Post</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">List Category Post</li>
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
		            	<h3 class="card-title">List Category Post</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <ul class="nav">
                            {{-- <li class="nav-item">
                                <a class="btn btn-danger"  href="{{route('admin.category_postDelete', $data->id)}}"><i class="fas fa-trash"></i> Delete</a>     
                            </li> --}}
                            <li class="nav-item">
                                <a class="btn btn-primary" href="{{route('admin.createCategoryPost')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Số bài viết</th>
                                        <th scope="col">Số view</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Thao tác</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($data_category as $data)
                                    <tr>
                                        <td class="text-center">{{$data->id}}</td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin.categoryPostDetail', array($data->id))}}">
                                                <b>{{$data->name}}</b>
                                                <br>
                                                
                                            </a>
                                            <div>
                                                @if($data->slug)
                                                <a href="{{ route('news.single', $data->slug) }}" title="">
                                                    <b style="color:#c76805;">{{ route('news.single', $data->slug) }}</b>
                                                </a>
                                                @else
                                                0
                                                @endif
                                            </div>
                                        </td>
                                        <td class="text-right">
                                           {{ $data->post()->count()}}

                                           
                                        </td>
                                        <td class="text-right">
                                            @php
                                            $totals = 0;  // Khởi tạo biến tổng
                                        @endphp
                                        
                                        @foreach($data->post as $item)
                                            @php
                                                $totals += (int)$item->description;  // Cộng dồn giá trị description (ép kiểu thành số nguyên)
                                            @endphp
                                        @endforeach
                                        
                                         {{ $totals }}
                                        
                                            
                                           
                                          
                                        </td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                            <br>
                                            {{ $data->status == 0 ? 'Draft' : 'Public' }}
                                        </td>
                                        <td>
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="{{route('admin.category_postDelete', $data->id)}}"><i class="fas fa-trash"></i> Delete</a>     
                                            </li>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            {!! $data_category->links() !!}
                        </div>

		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection