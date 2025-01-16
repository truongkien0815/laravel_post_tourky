@extends('admin.layouts.app')
<?php
if(isset($product_detail)){
    $product_info = $product_detail->getInfo;
    $getPackage = $product_detail->getPackage;
    if($product_info != '')
        extract($product_info->toArray());

    extract($product_detail->toArray());
    
    $gallery = (isset($gallery) || $gallery != "") ? unserialize($gallery) : '';
    
    

} else{
    $title_head = 'Add new product';
}
    $id = $id ?? 0;
    $date_update = $updated_at??'';

    $title_head = $name ??'';
    $unit = $unit??'';

    $spec_short = $spec_short??'';
?>
@section('seo')
@include('admin.partials.seo')
@endsection
@section('content')
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
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
        <form action="{{route('admin.postProductDetail')}}" method="POST" id="frm-create-product" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{ $id ?? 0 }}">
            @csrf
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3>{{$title_head}}</h3>
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <!-- show error form -->
                            <div class="errorTxt"></div>

                            <ul class="nav nav-tabs hide" id="tabLang" role="tablist">
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
                                        <label for="title">Title</label>
                                        <input type="text" class="form-control title_slugify" id="title" name="name" placeholder="Tiêu đề" value="{{ $name ?? '' }}">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="{{ $slug ?? '' }}">
                                    </div>
                                    @include('admin.partials.quote', ['description'=> $description ?? '', 'name' => 'description' ])
                                    @include('admin.partials.content', [
                                            'name' => 'content',
                                            'label' => 'Chi tiết sản phẩm',
                                            'content'=> $content ?? '' 
                                        ])

                                    @include('admin.partials.content', [
                                            'name' => 'body',
                                            'label' => 'Hướng dẫn sử dụng',
                                            'content'=> $body ?? ''
                                        ])
                                    
                                </div>

                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="post_title_en">Title</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Title" value="{{ $name_en ?? '' }}">
                                    </div>

                                    @include('admin.partials.quote', ['description'=> $description_en ?? '', 'name' => 'description_en' ])

                                    @include('admin.partials.content', [
                                           'name' => 'content_en',
                                           'label' => 'Chi tiết sản phẩm',
                                           'content'=> $content_en ?? ''
                                       ])

                                </div>

                            </div>
                            
                            
                            
                            
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->

                    <div class="card">
                        <div class="card-header">Giá và kho</div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="price" class="title_txt col-form-label col-md-4">Giá</label>
                                        <div class="col-md-8">
                                            <input type="text" name="price" id="price" value="{{ $price ?? 0 }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="unit" class="title_txt col-form-label col-md-4">Đơn vị tính</label>
                                        <div class="col-md-8">
                                            {{--
                                            <select class="form-control" name="unit">
                                                <option value="">----</option>
                                                @foreach($listUnit as $unit_item )
                                                <option value="{{ $unit_item }}" {{ $unit == $unit_item ? 'selected' : '' }}>{{ $unit_item }}</option>
                                                @endforeach
                                            </select>
                                            --}}
                                            <input type="text" name="unit" id="unit" value="{{ $unit ?? '' }}" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Giá khuyến mãi</label>
                                    <div class="col-md-8">
                                        <input type="text" name="promotion" id="promotion" value="{{ $promotion ?? '' }}" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ngày bắt đầu</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_start" id="date_start" value="{{ $date_start ?? '' }}" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ngày kết thúc</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_end" id="date_end" value="{{ $date_end ?? '' }}" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="sku" class="title_txt">Mã SP</label>
                                    <input type="text" name="sku" id="sku" value="{{ $sku ?? '' }}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="barcode" class="title_txt">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" value="{{ $barcode ?? '' }}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="price" class="title_txt">Kho</label>
                                    <input type="text" name="stock" id="stock" value="{{ $stock ?? '' }}" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="stt" class="title_txt">Sắp xếp</label>
                                    <input type="text" name="stt" id="stt" value="{{ $stt ?? '' }}" class="form-control">
                                </div>
                            </div>
                            <hr>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Thông tin</div> <!-- /.card-header -->
                        <div class="card-body">
                            
                            <div class="d-lg-block d-none">
                                <div class="form-group row">
                                    <div class="col-lg-4 col-xl-3">
                                        Mã
                                    </div>
                                    <div class="col-lg-4 col-xl-4">
                                        Giá trị
                                    </div>
                                    <div class="col-lg-4 col-xl-5">
                                        Mô tả
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="weight" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <input type="text" class="form-control" value="{{ $attrs['weight']['content']??'' }}" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="{{ $attrs['weight']['title']??'' }}" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="length" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-8 col-xl-4">
                                    <input type="text" class="form-control" value="{{ $attrs['length']['content']??'' }}" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="{{ $attrs['length']['title']??'' }}" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="width" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <input type="text" class="form-control" value="{{ $attrs['width']['content']??'' }}" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="{{ $attrs['length']['title']??'' }}" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="height" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <input type="text" class="form-control" value="{{ $attrs['height']['content']??'' }}" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="{{ $attrs['height']['title']??'' }}" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">Gallery</div> <!-- /.card-header -->
                        <div class="card-body">
                            <!--********************************************Gallery**************************************************-->
                            <!--Post Gallery-->
                            <div class="form-group">
                                @include('admin.partials.galleries', ['gallery_images'=> $gallery ?? ''])
                            </div>
                            <!--End Post Gallery-->
                        </div>
                    </div>


{{--                    <div class="card">--}}
{{--                        <div class="card-header">Thành phần</div> <!-- /.card-header -->--}}
{{--                        <div class="card-body">--}}
{{--                            @include('admin.product.includes.spec-short', compact('spec_short'))--}}
{{--                        </div>--}}
{{--                    </div>--}}


                    <div class="card">
                        <div class="card-header">Variable</div> <!-- /.card-header -->
                        <div class="card-body">
                            @include('admin.product.includes.variables', ['product_id' => $id])
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">SEO</div> <!-- /.card-header -->
                        <div class="card-body">
                            <!--SEO-->
                            @include('admin.form-seo.seo')
                        </div>
                    </div>
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    @include('admin.partials.action_button')
                    @include('admin.partials.option')

                    <div class="card widget-category">
                        <div class="card-header">
                            <h4>Category</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    <?php
                                    $data_checks=App\Model\ShopProductCategory::where('product_id', $id)->get();
                                    $array_checked=array();
                                    if($data_checks):
                                        foreach($data_checks as $data_check):
                                            array_push($array_checked, $data_check->category_id);
                                        endforeach;
                                    endif;
                                    $categories = App\Model\ShopCategory::where('parent', 0)->orderBy('priority','DESC')->get();
                                    ?>
                                    @include('admin.product.includes.category-item')

{{--                                    <ul id="muti_menu_post" class="muti_menu_right_category">--}}
{{--                                        @foreach($categories as $category)--}}
{{--                                        @php--}}
{{--                                            $checked = '';--}}
{{--                                            if(in_array($category->id, $array_checked))--}}
{{--                                                $checked = 'checked';--}}
{{--                                        @endphp--}}
{{--                                        <li class="category_menu_list">--}}
{{--                                            <label for="checkbox_cmc_{{ $category->id }}">--}}
{{--                                                <input type="checkbox" class="category_item_input" name="category_item[]" value="{{ $category->id }}" id="checkbox_cmc_{{ $category->id }}" {{ $checked }}>--}}
{{--                                                <span>{{ $category->name }}</span>--}}
{{--                                            </label>--}}
{{--                                        </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                    --}}
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

                    <div class="card widget-category">
                        <div class="card-header">
                            <h4>Loại sản phẩm</h4>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="inside clear">
                                <div class="clear">
                                    @php
                                        $array_checked = App\Model\ShopProductType::where('product_id', $id)->pluck('type_id')->toArray();
                                        $types = App\Model\ShopType::where('status', 1)->orderBy('sort','DESC')->get();
                                    @endphp
                                    <ul id="muti_menu_post" class="muti_menu_right_category">
                                        @foreach($types as $item)
                                            @php
                                                $checked_ = '';
                                                if(in_array($item->id, $array_checked))
                                                    $checked_ = 'checked';
                                            @endphp
                                            <li class="category_menu_list">
                                                <label for="checkbox_type_{{ $item->id }}" class="font-weight-normal">
                                                    <input type="checkbox" class="category_item_input" name="type_item[]" value="{{ $item->id }}" id="checkbox_type_{{ $item->id }}" {{ $checked_ }}>
                                                    <span>{{ $item->name }}</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->

{{--                    <div class="card widget-category">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4>Cấp học</h4>--}}
{{--                        </div> <!-- /.card-header -->--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="inside clear">--}}
{{--                                <div class="clear">--}}
{{--                                    <?php--}}
{{--                                    $data_checks = App\Model\ShopProductBrand::where('product_id', $id)->get();--}}
{{--                                    $array_checked = [];--}}
{{--                                    if($data_checks)--}}
{{--                                        foreach($data_checks as $data_check){--}}
{{--                                            array_push($array_checked, $data_check->brand_id);--}}
{{--                                        }--}}
{{--                                    --}}
{{--                                    $brands = App\Model\ShopBrand::where('status', 1)->orderBy('sort','DESC')->get();--}}
{{--                                    ?>--}}
{{--                                    <ul id="muti_menu_post" class="muti_menu_right_category">--}}
{{--                                        @foreach($brands as $brand)--}}
{{--                                        @php--}}
{{--                                            $checked = '';--}}
{{--                                            if(in_array($brand->id, $array_checked))--}}
{{--                                                $checked = 'checked';--}}
{{--                                        @endphp--}}
{{--                                        <li class="category_menu_list">--}}
{{--                                            <label for="checkbox_br_{{ $brand->id }}" class="font-weight-normal">--}}
{{--                                                <input type="checkbox" class="category_item_input" name="brand_item[]" value="{{ $brand->id }}" id="checkbox_br_{{ $brand->id }}" {{ $checked }}>--}}
{{--                                                <span>{{ $brand->name }}</span>--}}
{{--                                            </label>--}}
{{--                                        </li>--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="clearfix"></div>--}}
{{--                            </div>--}}
{{--                        </div> <!-- /.card-body -->--}}
{{--                    </div><!-- /.card -->--}}

{{--                    <div class="card widget-category">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4>Lớp</h4>--}}
{{--                        </div> <!-- /.card-header -->--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="inside clear">--}}
{{--                                <div class="clear">--}}
{{--                                    <?php--}}
{{--                                        $elements_checks = App\Model\ShopProductLevel::where('product_id', $id)->get();--}}
{{--                                        $elements_check = [];--}}
{{--                                        if($elements_checks)--}}
{{--                                            foreach($elements_checks as $data_check){--}}
{{--                                                array_push($elements_check, $data_check->level_id);--}}
{{--                                            }--}}

{{--                                        $elements = App\Model\ShopLevel::where('parent', 0)->where('status', 1)->orderBy('sort','DESC')->get();--}}
{{--                                    ?>--}}
{{--                                    <ul id="muti_menu_post" class="muti_menu_right_category">--}}
{{--                                        @foreach($elements as $item)--}}
{{--                                            @php--}}
{{--                                                $checked = '';--}}
{{--                                                if(in_array($item->id, $elements_check))--}}
{{--                                                    $checked = 'checked';--}}

{{--                                            @endphp--}}
{{--                                            <li class="category_menu_list">--}}
{{--                                                <label for="checkbox_el_{{ $item->id }}" class="font-weight-normal">--}}
{{--                                                    <input type="checkbox" class="category_item_input" name="level_item[]" value="{{ $item->id }}" id="checkbox_el_{{ $item->id }}" {{ $checked }}>--}}
{{--                                                    <span>{{ $item->name }}</span>--}}
{{--                                                </label>--}}
{{--                                            </li>--}}
{{--                                            @if($item->getChild()->count())--}}
{{--                                                @foreach($item->getChild as $value)--}}
{{--                                                    @php--}}
{{--                                                        $checked_child = '';--}}
{{--                                                        if(in_array($value->id, $elements_check))--}}
{{--                                                            $checked_child = 'checked';--}}
{{--                                                    @endphp--}}
{{--                                                    <li class="category_menu_list pl-3">--}}
{{--                                                        <label for="checkbox_el_{{ $value->id }}" class="font-weight-normal">--}}
{{--                                                            <input type="checkbox" class="category_item_input" name="level_item[]" value="{{ $value->id }}" id="checkbox_el_{{ $value->id }}" {{ $checked_child }}>--}}
{{--                                                            <span>{{ $value->name }}</span>--}}
{{--                                                        </label>--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            @endif--}}
{{--                                        @endforeach--}}
{{--                                    </ul>--}}
{{--                                </div>--}}
{{--                                <div class="clearfix"></div>--}}
{{--                            </div>--}}
{{--                        </div> <!-- /.card-body -->--}}
{{--                    </div><!-- /.card -->--}}

                    @include('admin.partials.image', ['title'=>'Image', 'id'=>'img', 'name'=>'image', 'image'=>$image??''])
{{--                    @include('admin.partials.image', ['title'=>'Hình ảnh Banner', 'id'=>'cover-img', 'name'=>'cover', 'image'=> ($cover ?? '')])--}}
                    
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>

@push('styles')
<!-- add styles here -->
@endpush

@push('scripts-footer')
<!-- add script here -->
@endpush

<script type="text/javascript">
    jQuery(document).ready(function ($){
        // $('.slug_slugify').slugify('.title_slugify');
        $('#js-variable-products-select').select2();
        //Date range picker
        $('#date_start').datetimepicker({
            minDate:0,
            format:'Y-m-d H:i'
        });
        $('#date_end').datetimepicker({
            minDate:0,
            format:'Y-m-d H:i'
        });
        

        //xử lý validate
        $("#frm-create-product").validate({
            rules: {
                title: "required",
                'category_item[]': { required: true, minlength: 1 },
                price: "required",
                weight: {
                    required:true
                },
            },
            messages: {
                title: "Enter title",
                'category_item[]': "Select category",
                price: "Enter price",
                weight: {
                    required:"Enter weight"
                },
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
    editorQuote('description');
</script>
@endsection


