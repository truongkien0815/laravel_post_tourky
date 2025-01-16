@extends('admin.layouts.app')
@section('seo')
    @include('admin.partials.seo')
@endsection
@section('content')
    @php
        if(isset($post)){
            extract($post->toArray());
        }
        $input_type = $input_type??'color';
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
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col">Tên</th>
                                        <th scope="col">Input type</th>
                                        <th scope="col">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($posts as $data)
                                    <tr>
                                        <td class="">
                                            <a class="row-title" href="{{route('admin_variable.edit', $data->id)}}">
                                                <b>{{$data->name}}</b>
                                                <br>
                                                <b style="color:#c76805;">{{$data->slug}}</b>                                
                                            </a>
                                        </td>
                                        <td class="text-center">{{ $data->input_type }}</td>
                                        <td class="text-center">
                                            {{$data->created_at}}
                                            <br>
                                            {{ $data->status == 0 ? 'Draft' : 'Public' }}
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

                                    <input type="hidden" name="input_type" value="{{ $input_type??'' }}">
                                    {{--
                                    <div class="form-group">
                                        <div class="row">
                                            <legend class="col-form-label col-sm-2 pt-0">Input type</legend>
                                            <div class="col-lg-10">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="input_type" id="color" value="color" {{ $input_type == 'color'?'checked':'' }}>
                                                    <label class="form-check-label" for="color">Color</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="input_type" id="size" value="size" {{ $input_type == 'size'?'checked':'' }}>
                                                    <label class="form-check-label" for="size">Size</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="input_type" id="text" value="text" {{ $input_type == 'text'?'checked':'' }}>
                                                    <label class="form-check-label" for="text">Text</label>
                                                </div>
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="input_type" id="number" value="number" {{ $input_type == 'number'?'checked':'' }}>
                                                    <label class="form-check-label" for="number">Number</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    --}}

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