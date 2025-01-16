@extends('admin.layouts.app')
<?php
if(isset($page_data))
    extract($page_data->toArray());
// dd($page);
?>

@section('seo')
    @include('admin.partials.seo')
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
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
        <form action="{{ $url_action }}" method="POST" id="frm-create-page" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id??0 }}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3 class="card-title">Post Page</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <ul class="nav nav-tabs hidden" id="tabLang" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="vi-tab" data-toggle="tab" href="#vi" role="tab" aria-controls="vi" aria-selected="true">Tiếng việt</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="en-tab" data-toggle="tab" href="#en" role="tab" aria-controls="en" aria-selected="false">Tiếng Anh</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="vi" role="tabpanel" aria-labelledby="vi-tab">
                                <div class="form-group">
                                    <label for="post_title">Tiêu đề</label>
                                    <input type="text" class="form-control title_slugify" id="post_title" name="name" placeholder="Tiêu đề" value="{{ $name??'' }}">
                                </div>
                                <div class="form-group">
                                    <label for="post_description">Trích dẫn</label>
                                    <textarea class="form-control" id="post_description" name="description">{!! $description??'' !!}</textarea>
                                </div>
                            </div>

                            <div class="form-group {{ $errors->has('position') ? ' text-red' : '' }}">
                                <label for="position" class="col-form-label">Vị trí</label>
                                
                                    <select class="form-control position" style="width: 100%;" name="position" >
                                        <option value=""></option>
                                        @foreach ($layoutPosition as $k => $v)
                                            <option value="{{ $k }}" {{ (old('position',$position??'') ==$k) ? 'selected':'' }}>{{ $v }}</option>
                                        @endforeach
                                    </select>
                            </div>

                            <div class="form-group {{ $errors->has('page') ? ' text-red' : '' }}">
                                <label for="page" class="col-form-label">Chọn trang</label>
                                <div>
                                    @php
                                        $arrPage = [];
                                        if(isset($page))
                                            $arrPage = explode(',', $page);
                                    @endphp
                                    <select class="form-control page select2" multiple="multiple" style="width: 100%;" name="page[]" >
                                        <option value="*" {{ in_array('*',old('page',$arrPage)) ? 'selected':'' }}>Tất cả các trang</option>
                                        {{--
                                        <option value="audio_category" {{ in_array('audio_category',old('page',$arrPage)) ? 'selected':'' }}>Danh mục Audio</option>
                                        <option value="audio_detail" {{ in_array('audio_detail',old('page',$arrPage)) ? 'selected':'' }}>Chi tiết Audio</option>
                                        --}}
                                        <option value="home" {{ in_array('home',old('page',$arrPage)) ? 'selected':'' }}>Trang chủ</option>
                                    </select>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label for="sort" class="title_txt">Nội dung</label>
                                    <select name="text" class="form-control text">
                                        @foreach ($listViewBlock as $view)
                                            <option value="{!! $view !!}" {{ (old('text',$text??'') == $view)?'selected':'' }} >{{ $view }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="sort" class="title_txt">Sắp xếp (Tăng dần)</label>
                                    <input type="text" name="sort" id="sort" value="{{$sort ?? 0}}" class="form-control">
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=> ($image ?? '')])
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
@endsection

@push('scripts')
    <script type="text/javascript">
        jQuery(document).ready(function ($){
            // $('.slug_slugify').slugify('.title_slugify');

            //Date range picker
            $('#reservationdate').datetimepicker({
                format: 'YYYY-MM-DD hh:mm:ss'
            });
            
            //xử lý validate
            $("#frm-create-page").validate({
                rules: {
                    name: "required",
                },
                messages: {
                    name: "Nhập tiêu đề trang",
                },
                errorElement : 'div',
                errorLabelContainer: '.errorTxt',
                invalidHandler: function(event, validator) {
                    $('html, body').animate({
                        scrollTop: 0
                    }, 500);
                }
            });
        });
    </script>
@endpush