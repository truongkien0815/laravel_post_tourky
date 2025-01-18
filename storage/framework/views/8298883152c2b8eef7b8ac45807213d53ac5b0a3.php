<?php $__env->startSection('seo'); ?>
    <?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    
    <?php
        if(isset($post)){
            extract($post->toArray());
        }
    ?>

<!-- Content Header (Page header) -->
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2 justify-content-end">
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          
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
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('type')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="<?php echo e(route('admin_type')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Từ khoá" value="<?php echo e(request('search_title')); ?>">
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
                                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php echo $__env->make('admin.shop-type.item', ['data' => $data], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></tr>
                                        <?php if($data->getChild()->count()): ?>
                                            <?php $__currentLoopData = $data->getChild; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr><?php echo $__env->make('admin.shop-type.item', ['data' => $item, 'child' => 1], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?></tr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
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
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/shop-type/index.blade.php ENDPATH**/ ?>