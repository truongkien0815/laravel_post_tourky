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
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title_head }}</li>
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
		            	<h3 class="card-title">{{ $title_head }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                
                                {{-- <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('post')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li> --}}
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{route('admin.createPost')}}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\Category::orderBy('name', 'ASC')->select('id', 'name')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category">
                                        <option value="">Thể loại tin tức</option>
                                        @foreach($list_cate as $cate)
                                            <option value="{{$cate->id}}" {{ request('category') == $cate->id ? 'selected' : ''  }}>{{$cate->name}}</option>
                                        @endforeach
                                    </select>
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá" value="{{ request('search_title') }}">
                                    <button type="submit" class="btn btn-primary ml-2">Tìm kiếm</button>
                                </form>
                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Số view</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                    <tr>
                                        <td class="text-right">
                                            {{ $data->id}}
                                        </td>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin.postDetail', array($data->id))}}">
                                                <b>{{$data->name}}</b>
                                                <br>
                                                <b style="color:#c76805;">{{$data->slug}}</b>                                
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            @if($data->category_post->count())
                                                @foreach($data->category_post as $category)
                                                    <a href="{{ route('admin.categoryPostDetail', $category->id) }}" target="_blank">- {{ $category->name }}</a>
                                                    <br>
                                                @endforeach
                                            @endif
                                        </td>
                                           <td class="text-right">
                                            {{$data->description}}
                                        </td>
                                      
                                        <td class="text-center">
                                            {{$data->created_at}}
                                            <br>
                                            {{ $data->status == 0 ? 'Draft' : 'Public' }}
                                        </td>
                                        <td>
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="{{route('admin.postDelete', $data->id)}}"><i class="fas fa-trash"></i> Delete</a>
                                            </li>
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

<script type="text/javascript">
	// Default Configuration
		$(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '1000',
				'hideDuration': '1000',
				'timeOut': '3000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		});

	



	
	</script>
@endsection