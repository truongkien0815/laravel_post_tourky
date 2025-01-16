@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')
    
    @php
        if(isset($post)){
            extract($post->toArray());
        }
    @endphp

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
	      	<div class="col-lg-6">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title">{{ $title_head }}</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('type')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="{{ $url_action }}" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
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
                                        <th class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th>Title</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                        @include('admin.shop-type.item', ['data' => $data])</tr>
                                        @if($data->getChild()->count())
                                            @foreach($data->getChild as $item)
                                                <tr>@include('admin.shop-type.item', ['data' => $item, 'child' => 1])</tr>
                                            @endforeach
                                        @endif
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

            <div class="col-lg-6">
                <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" value="{{$id?? 0}}">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>{{$title_head}}</h4>
                                </div> <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- show error form -->
                                    <div class="errorTxt"></div>
                                    
                                    <div class="form-group">
                                        <label for="name">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="name" name="name" placeholder="Tiêu đề" value="{{ $name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Slug</label>
                                        <input type="text" class="form-control title_slugify" id="slug" name="slug" placeholder="slug" value="{{ $slug ?? '' }}">
                                    </div>

                                    <div class="form-group">
                                        <label for="sort" class="title_txt">Sắp xếp (Tăng dần)</label>
                                        <input type="text" name="sort" id="sort" value="{{$sort ?? 0}}" class="form-control">
                                    </div>
                                    <!--SEO-->
                                    
                                </div> <!-- /.card-body -->
                            </div><!-- /.card -->

                        </div> <!-- /.col-9 -->
                        <div class="col-12">
                            @include('admin.partials.action_button')
                        </div> <!-- /.col-9 -->
                    </div> <!-- /.row -->
                </form>
            </div>  
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
@endsection