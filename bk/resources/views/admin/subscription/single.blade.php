@extends('admin.layouts.app')
<?php
if(isset($single)){
    extract($single);
    // $date_start = date('Y-m-d', strtotime($date_start));
    // $time_start = date('H:i', strtotime($date_start));
}
?>
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{$title}}</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="{{ $url_action }}" method="POST" id="frm-create-category" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $id ?? 0 }}">
    	    <div class="row">
    	      	<div class="col-9">
                    
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h5>{{$title}}</h5>
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
                                        <label for="sub_name">Tiêu đề phụ</label>
                                        <input type="text" class="form-control title_slugify" id="sub_name" name="sub_name" placeholder="Tiêu đề phụ" value="{{ $sub_name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="chiso">Chỉ số tra cứu</label>
                                        <input type="number" class="form-control title_slugify" id="chiso" name="chiso" placeholder="Chỉ số tra cứu" value="{{ $chiso ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description">Nội dung</label>
                                        <textarea id="description" name="description">{!! $description ?? '' !!}</textarea>
                                    </div>
                                    <div class="form-group mb-0">
                                        <label for="content">Lời khuyên</label>
                                        <textarea id="description" name="content">{!! $content ?? '' !!}</textarea>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="name_en">Title category</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Title" value="{{ $name_en ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="description_en">Description category</label>
                                        <textarea id="description_en" name="description_en">{!! $description_en ?? '' !!}</textarea>
                                    </div>
                                </div>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')

                    <div class="card">
                        <div class="card-header">
                            <h5>Danh mục chỉ số</h5>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="list_category">
                                @php
                                    $id = $id ?? 0;
                                    $data_checks = App\Model\ChiSoCategoryJoin::where('post_id', $id)->get();
                                    $array_checked = array();
                                    if($data_checks){
                                        foreach($data_checks as $data_check){
                                            array_push($array_checked,$data_check->category_id);
                                        }
                                    }
                                    
                                    $categories = App\Model\ChiSoCategory::where('status', 1)->orderByDESC('sort')->get();
                                @endphp
                                @foreach($categories as $category)
                                <p>
                                    <label for="category_{{ $category->id }}">
                                        <input type="checkbox" class="category_item_input" name="category[]" value="{{ $category->id }}" id="category_{{ $category->id }}" {{ in_array($category->id ,$array_checked) ? 'checked' : '' }} />
                                        {{ $category->name }}
                                    </label>
                                </p>
                                @endforeach
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                    @include('admin.partials.image', ['title'=>'Hình ảnh', 'id'=>'img', 'name'=>'image', 'image'=> ($image ?? '')])


                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>

@endsection

@push('styles')
<!-- add styles here -->
<link rel="stylesheet" href="{{ asset('assets/js/datetimepicker/jquery.datetimepicker.min.css')  }}">
<script src="{{ asset('assets/js/datetimepicker/jquery.datetimepicker.full.min.js') }}"></script>
@endpush

@push('scripts-footer')
<!-- add script here -->
<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('.slug_slugify').slugify('.title_slugify');
        $('#js-variable-products-select').select2();
        //Date range picker
        $('#date_start').datetimepicker({
            timepicker:false,
            minDate:0,
            format:'Y-m-d'
        });
        $('#time_start').datetimepicker({
            datepicker:false,
            format:'H:i'
        });
        

        //xử lý validate
        $("#frm-create-category").validate({
            rules: {
                name: "required",
                chiso: "required",
                'category[]': { required: true, minlength: 1 },
            },
            messages: {
                name: "Nhập tiêu đề",
                chiso: "Nhập chỉ số tra cứu",
                'category[]': "Chọn danh mục chỉ số",
            },
            errorElement : 'div',
            errorLabelContainer: '.errorTxt',
            invalidHandler: function(event, validator) {
                $('html, body').animate({
                    scrollTop: 0
                }, 500);
            }
        });

        
        // auto check parrent
        $('#muti_menu_post input').each(function(index, el) {
            if($(this).is(':checked')){
                // console.log($(this).val());
                $(this).closest('.sub-menu').parent().find('label').first().find('input').prop('checked', true);
            }
        });
    });
</script>
<script type="text/javascript">
    editor('description');
    editor('description_en');
    editorQuote('content');
</script>
@endpush