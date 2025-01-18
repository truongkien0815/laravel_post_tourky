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
<?php $__env->startSection('seo'); ?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active"><?php echo e($title_head); ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="<?php echo e(route('admin.postProductDetail')); ?>" method="POST" id="frm-create-product" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo e($id ?? 0); ?>">
            <?php echo csrf_field(); ?>
    	    <div class="row">
    	      	<div class="col-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3><?php echo e($title_head); ?></h3>
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
                                        <input type="text" class="form-control title_slugify" id="title" name="name" placeholder="Tiêu đề" value="<?php echo e($name ?? ''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Slug</label>
                                        <input type="text" class="form-control slug_slugify" id="slug" name="slug" placeholder="Slug" value="<?php echo e($slug ?? ''); ?>">
                                    </div>
                                    <?php echo $__env->make('admin.partials.quote', ['description'=> $description ?? '', 'name' => 'description' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('admin.partials.content', [
                                            'name' => 'content',
                                            'label' => 'Chi tiết sản phẩm',
                                            'content'=> $content ?? '' 
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <?php echo $__env->make('admin.partials.content', [
                                            'name' => 'body',
                                            'label' => 'Hướng dẫn sử dụng',
                                            'content'=> $body ?? ''
                                        ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    
                                </div>

                                <div class="tab-pane fade" id="en" role="tabpanel" aria-labelledby="en-tab">
                                    <div class="form-group">
                                        <label for="post_title_en">Title</label>
                                        <input type="text" class="form-control" id="name_en" name="name_en" placeholder="Title" value="<?php echo e($name_en ?? ''); ?>">
                                    </div>

                                    <?php echo $__env->make('admin.partials.quote', ['description'=> $description_en ?? '', 'name' => 'description_en' ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                                    <?php echo $__env->make('admin.partials.content', [
                                           'name' => 'content_en',
                                           'label' => 'Chi tiết sản phẩm',
                                           'content'=> $content_en ?? ''
                                       ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                                            <input type="text" name="price" id="price" value="<?php echo e($price ?? 0); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="unit" class="title_txt col-form-label col-md-4">Đơn vị tính</label>
                                        <div class="col-md-8">
                                            
                                            <input type="text" name="unit" id="unit" value="<?php echo e($unit ?? ''); ?>" class="form-control">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Giá khuyến mãi</label>
                                    <div class="col-md-8">
                                        <input type="text" name="promotion" id="promotion" value="<?php echo e($promotion ?? ''); ?>" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ngày bắt đầu</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_start" id="date_start" value="<?php echo e($date_start ?? ''); ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group col-lg-6">
                                <div class="row">
                                    <label for="price" class="title_txt col-form-label col-md-4 px-md-1">Ngày kết thúc</label>
                                    <div class="col-md-8">
                                        <input type="text" name="date_end" id="date_end" value="<?php echo e($date_end ?? ''); ?>" class="form-control" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="form-group col-lg-6">
                                    <label for="sku" class="title_txt">Mã SP</label>
                                    <input type="text" name="sku" id="sku" value="<?php echo e($sku ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="barcode" class="title_txt">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" value="<?php echo e($barcode ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="price" class="title_txt">Kho</label>
                                    <input type="text" name="stock" id="stock" value="<?php echo e($stock ?? ''); ?>" class="form-control">
                                </div>
                                <div class="form-group col-lg-6">
                                    <label for="stt" class="title_txt">Sắp xếp</label>
                                    <input type="text" name="stt" id="stt" value="<?php echo e($stt ?? ''); ?>" class="form-control">
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
                                    <input type="text" class="form-control" value="<?php echo e($attrs['weight']['content']??''); ?>" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['weight']['title']??''); ?>" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="length" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-8 col-xl-4">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['length']['content']??''); ?>" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['length']['title']??''); ?>" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="width" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['width']['content']??''); ?>" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['length']['title']??''); ?>" placeholder="Mô tả" name="attrs[title][]"  />
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-lg-4 col-xl-3">
                                    <input type="text" class="form-control" value="height" placeholder="Mã"  name="attrs[name][]" />
                                </div>
                                <div class="col-lg-4 col-xl-4">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['height']['content']??''); ?>" placeholder="Giá trị" name="attrs[content][]"  />
                                </div>
                                <div class="col-lg-4 col-xl-5">
                                    <input type="text" class="form-control" value="<?php echo e($attrs['height']['title']??''); ?>" placeholder="Mô tả" name="attrs[title][]"  />
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
                                <?php echo $__env->make('admin.partials.galleries', ['gallery_images'=> $gallery ?? ''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                            <!--End Post Gallery-->
                        </div>
                    </div>










                    <div class="card">
                        <div class="card-header">Variable</div> <!-- /.card-header -->
                        <div class="card-body">
                            <?php echo $__env->make('admin.product.includes.variables', ['product_id' => $id], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header">SEO</div> <!-- /.card-header -->
                        <div class="card-body">
                            <!--SEO-->
                            <?php echo $__env->make('admin.form-seo.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
    	    	</div> <!-- /.col-9 -->
                <div class="col-3">
                    <?php echo $__env->make('admin.partials.action_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('admin.partials.option', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

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
                                    <?php echo $__env->make('admin.product.includes.category-item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>













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
                                    <?php
                                        $array_checked = App\Model\ShopProductType::where('product_id', $id)->pluck('type_id')->toArray();
                                        $types = App\Model\ShopType::where('status', 1)->orderBy('sort','DESC')->get();
                                    ?>
                                    <ul id="muti_menu_post" class="muti_menu_right_category">
                                        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $checked_ = '';
                                                if(in_array($item->id, $array_checked))
                                                    $checked_ = 'checked';
                                            ?>
                                            <li class="category_menu_list">
                                                <label for="checkbox_type_<?php echo e($item->id); ?>" class="font-weight-normal">
                                                    <input type="checkbox" class="category_item_input" name="type_item[]" value="<?php echo e($item->id); ?>" id="checkbox_type_<?php echo e($item->id); ?>" <?php echo e($checked_); ?>>
                                                    <span><?php echo e($item->name); ?></span>
                                                </label>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
















































































                    <?php echo $__env->make('admin.partials.image', ['title'=>'Image', 'id'=>'img', 'name'=>'image', 'image'=>$image??''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                    
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>

<?php $__env->startPush('styles'); ?>
<!-- add styles here -->
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts-footer'); ?>
<!-- add script here -->
<?php $__env->stopPush(); ?>

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
<?php $__env->stopSection(); ?>



<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/product/single.blade.php ENDPATH**/ ?>