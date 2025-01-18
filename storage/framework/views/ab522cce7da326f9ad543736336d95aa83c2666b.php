<?php $__env->startSection('seo'); ?>
    <?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <?php
        if(isset($post)){
            extract($post->toArray());
        }
        $input_type = $input_type??'color';
    ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
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
	    <div class="row">
	      	<div class="col-lg-6">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title"><?php echo e($title_head); ?></h3>
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
                                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="">
                                            <a class="row-title" href="<?php echo e(route('admin_variable.edit', $data->id)); ?>">
                                                <b><?php echo e($data->name); ?></b>
                                                <br>
                                                <b style="color:#c76805;"><?php echo e($data->slug); ?></b>                                
                                            </a>
                                        </td>
                                        <td class="text-center"><?php echo e($data->input_type); ?></td>
                                        <td class="text-center">
                                            <?php echo e($data->created_at); ?>

                                            <br>
                                            <?php echo e($data->status == 0 ? 'Draft' : 'Public'); ?>

                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $posts->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
            <div class="col-lg-6">
                <form action="<?php echo e($url_action); ?>" method="POST" id="frm-create-post" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="id" value="<?php echo e($id?? 0); ?>">
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4><?php echo e($title_head); ?></h4>
                                </div> <!-- /.card-header -->
                                <div class="card-body">
                                    <!-- show error form -->
                                    <div class="errorTxt"></div>
                                    <div class="form-group">
                                        <label for="name">Tiêu đề</label>
                                        <input type="text" class="form-control title_slugify" id="name" name="name" placeholder="Tiêu đề" value="<?php echo e($name ?? ''); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Slug</label>
                                        <input type="text" class="form-control title_slugify" id="slug" name="slug" placeholder="slug" value="<?php echo e($slug ?? ''); ?>">
                                    </div>

                                    <input type="hidden" name="input_type" value="<?php echo e($input_type??''); ?>">
                                    

                                    <div class="form-group">
                                        <label for="sort" class="title_txt">Sắp xếp (Tăng dần)</label>
                                        <input type="text" name="sort" id="sort" value="<?php echo e($sort ?? 0); ?>" class="form-control">
                                    </div>
                                    <!--SEO-->
                                    
                                </div> <!-- /.card-body -->
                            </div><!-- /.card -->

                        </div> <!-- /.col-9 -->
                        <div class="col-12">
                            <?php echo $__env->make('admin.partials.action_button', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div> <!-- /.col-9 -->
                    </div> <!-- /.row -->
                </form>
            </div>  
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/shop-variable/index.blade.php ENDPATH**/ ?>