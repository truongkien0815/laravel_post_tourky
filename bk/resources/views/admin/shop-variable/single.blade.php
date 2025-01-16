@extends('admin.layouts.app')
    @php
        if(isset($post)){
            extract($post->toArray());
        }
    @endphp
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
          <li class="breadcrumb-item active">{{$title_head}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{ $url_action }}" method="POST" id="frm-create-post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{$id?? 0}}">
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h4>{{$title_head}}</h4>
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
                                        <label for="name">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="name" name="name" placeholder="Tiêu đề" value="{{ $name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="name_en">Title</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Title" value="{{ $name_en ?? '' }}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="sort" class="title_txt">Input type</label>
                                <select name="input_type" class="form-control">
                                    <option value="color" {{ isset($input_type) && $input_type =='color'?'selected':'' }}>Color</option>
                                    <option value="text" {{ isset($input_type) && $input_type =='text'?'selected':'' }}>Text</option>
                                    <option value="number" {{ isset($input_type) && $input_type =='number'?'selected':'' }}>Number</option>
                                </select>
                            </div>

                            {{--
                            <div class="form-group">
                                <label for="template_checkID" class="title_txt">Parent variable</label>
                                <?php 
                                    $variables = App\Model\ShopVariable::where('status', 1)->where('id', '<>', $id)->get();
                                ?>
                                <select class="custom-select mr-2" name="category_parent">
                                    <option value="0" >== N/A ==</option>
                                    @if(count($variables)>0)
                                        @foreach ($variables as $variable)
                                            @if( ($variable->id) != 0)
                                                <option value="{{ $variable->id }}">{{ $variable->name }}</option>
                                            @endif
                                        @endforeach
                                    @endif
                                </select>
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
                <div class="col-3">
                    @include('admin.partials.action_button')
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        $('#thumbnail_file').change(function(evt) {
            $("#thumbnail_file_link").val($(this).val());
            $("#thumbnail_file_link").attr("value",$(this).val());
        });
        
        //xử lý validate
        $("#frm-create-post").validate({
            rules: {
                name: "required",
                'category[]': { required: true, minlength: 1 }
            },
            messages: {
                name: "Nhập tiêu đề tin",
                'category[]': "Chọn thể loại tin",
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
@endsection