<?php
if(isset($data_slider)){
    $title = $data_slider->name;
    $post_title = $data_slider->name;
    $link = $data_slider->link;
    $src = $data_slider->src;
    $src_mobile = $data_slider->src_mobile;
    $order = $data_slider->order;
    $status = $data_slider->status;
    $target = $data_slider->target;
    $date_update = $data_slider->updated;
    $sid = $data_slider->id;
} else{
    $title = 'Create Slider';
    $post_title = "";
    $link = '';
    $src = "";
    $src_mobile = "";
    $order = 0;
    $status = 0;
    $target = "_top";
    $date_update = date('Y-m-d h:i:s');
    $sid = 0;
}
?>
<?php $__env->startSection('seo'); ?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active"><?php echo e($title); ?></li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div><!-- /.container-fluid -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
  	<div class="container-fluid">
        <form action="<?php echo e(route('admin.postSliderDetail')); ?>" method="POST" id="frm-slider" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="sid" value="<?php echo e($sid); ?>">
    	    <div class="row">
    	      	<div class="col-lg-9">
    	        	<div class="card">
    		          	<div class="card-header">
    		            	<h3><?php echo e($title); ?></h3>                            
    		          	</div> <!-- /.card-header -->
    		          	<div class="card-body">
                            <?php if($sid): ?>
                            <p>Shortcode: <span style="background: #f1f1f1; display: inline-block; padding: 3px">[slider id="<?php echo e($sid); ?>" items="4"]</span></p>
                            <?php endif; ?>
                            <!-- show error form -->
                            <div class="errorTxt"></div>
                            <div class="form-group">
                                <label for="post_title">Tiêu đề</label>
                                <input type="text" class="form-control title_slugify" id="post_title" name="post_title" placeholder="Tiêu đề" value="<?php echo e($post_title); ?>">
                            </div>
                            <div class="form-group ">
                                <label>Upload Images</label>
                                <div class="row">
                                    <div class="col-9">
                                         <input type="text" name="slishow_upload" class="form-control" id="csv_upload_slishow" value="<?php echo e($src); ?>" autocomplete="off" />
                                    </div>
                                       
                                    <div class="col-3">
                                        <!-- <input type="file" id="csv_slishow" name="csv_slishow" onchange="loadFileSlishow_pc(event)"/>Choose File -->
                                        <button type="button" id="img-slider" class="btn btn-primary ckfinder-popup" data-show="output_slishow_pc" data="csv_upload_slishow">Select IMG</button>
                                    </div>
                                </div>
                                <div class="clear mt-1">
                                    <?php if($src!=''): ?>
                                    <img id="output_slishow_pc" class="output_slishow_pc" src="<?php echo e(asset('storage/'.$src)); ?>"/>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group" style="display: none;">
                                <label>Upload Images Mobile</label>
                                <div class="clear">
                                    <div class="file_csv_up" id="text_input_file_mobile">
                                        <input type="text" name="slishow_upload_mobile" class="form-control" id="csv_upload_slishow_mobile" value="<?php echo $src_mobile; ?>" autocomplete="off" />
                                    </div>
                                    <div id="csv_upload_mobile" class="csv_tbl_submit_body">
                                        <input type="file" id="csv_slishow_mobile" name="csv_slishow_mobile" onchange="loadFileSlishow_mobile(event)"/>Choose File
                                    </div>
                                </div>
                                <div class="clear mt-1">
                                    <img id="output_slishow_mobile" src="<?php echo $src_mobile; ?>"/>
                                </div>
                            </div>
                            
                            <!-- <div class="form-group">
                                <label for="link">Link</label>
                                <input id="link" type="text" name="link" class="form-control" value="<?php echo e($link); ?>">
                            </div> -->
                            <div class="form-group">
                                <label for="target">Target</label>
                                <select name="target" id="target" class="selectbox form-control">
                                    <option value="_top" <?php if($target == "_top"): ?> selected <?php endif; ?>>_top</option>
                                    <option value="_blank" <?php if($target == "_blank"): ?> selected <?php endif; ?>>_blank</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <h4 class="border-bottom mt-4 mb-2">Slider item</h4>
                                <?php if($sid==0): ?>
                                    <p style="color: #f00;">Vui lòng bấm cập nhật để thêm Slider con</p>
                                <?php else: ?>
                                    <div class="text-right">
                                        <button type="button" class="btn btn-info edit-slider" data="0" data-parent="<?php echo e($sid); ?>">Thêm slider con</button>
                                    </div>
                                    <div class="col-lg-12 slider-items mt-3">
                                        <div class="form-group row border py-2">
                                            <div class="col-1">ID</div>
                                            <div class="col-2">Hình ảnh</div>
                                            <div class="col-3">Tên</div>
                                            <div class="col-3">Link</div>
                                            <div class="col-1">Type</div>
                                            <div class="col-2">Action</div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 slider-list">
                                        <?php echo $__env->make('admin.slider.includes.slider-items', ['sliders'=>$sliders], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>    
                                    </div>
                                    
                                <?php endif; ?>
                            </div>
    		        	</div> <!-- /.card-body -->
    	      		</div><!-- /.card -->
    	    	</div> <!-- /.col-9 -->
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Publish</h3>
                        </div> <!-- /.card-header -->
                        <div class="card-body">
                            <div class="form-group clearfix">
                                <div class="icheck-primary d-inline">
                                    <input type="radio" id="radioDraft" name="status" value="1" <?php if($status == 1): ?> checked <?php endif; ?>>
                                    <label for="radioDraft">Draft</label>
                                </div>
                                <div class="icheck-primary d-inline" style="margin-left: 15px;">
                                    <input type="radio" id="radioPublic" name="status" value="0" <?php if($status == 0): ?> checked <?php endif; ?>>
                                    <label for="radioPublic">Public</label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>Date:</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="created" class="form-control datetimepicker-input" data-target="#reservationdate" value="<?php echo e($date_update); ?>">
                                    <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                        <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </div> <!-- /.card-body -->
                    </div><!-- /.card -->
                </div> <!-- /.col-9 -->
    	  	</div> <!-- /.row -->
        </form>
  	</div> <!-- /.container-fluid -->
</section>
<div class="content-html">

</div>
<!-- Modal -->
<div class="modal fade" id="sliderModal" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Thêm Slider</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <div class="errorTxtModal col-lg-12" style="color: #f00;"></div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info post-slider">Save changes</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    jQuery(document).ready(function ($){
        $(".slider-list").sortable({
            update: function(event, ui) {
                console.log('fdfd');
                var form = document.getElementById('frm-slider');
                var fdnew = new FormData(form);
                axios({
                    method: 'POST',
                    url: '/admin/slider/sort',
                    data: fdnew,
                }).then(res => {
                    
                }).catch(e => console.log(e));
            }            
        });


        $('.slug_slugify').slugify('.title_slugify');

        //Date range picker
        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD hh:mm:ss'
        });

        $('#csv_slishow').change(function(evt) {
            $("#csv_upload_slishow").val($(this).val());
            $("#csv_upload_slishow").attr("value",$(this).val());
        });
        $('#csv_slishow_mobile').change(function(evt) {
           $("#csv_upload_slishow_mobile").val($(this).val());
           $("#csv_upload_slishow_mobile").attr("value",$(this).val());
        });
    });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/slider/single.blade.php ENDPATH**/ ?>