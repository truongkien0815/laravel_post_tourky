<?php $__env->startSection('seo'); ?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<div id="success" ></div>
<?php if(session('success')): ?>

    <script>
         toastr.success("<?php echo e(session('success')); ?>");
    </script>
<?php endif; ?>


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
	      	<div class="col-12">
	        	<div class="card">
		          	<div class="card-header">
		            	<h3 class="card-title"><?php echo e($title_head); ?></h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                
                                
                                <li class="nav-item">
                                    <a class="btn btn-primary" href="<?php echo e(route('admin.createPost')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <?php 
                                        $list_cate = App\Model\Category::orderBy('name', 'ASC')->select('id', 'name')->get();
                                    ?>
                                    <select class="custom-select mr-2" name="category">
                                        <option value="">Thể loại tin tức</option>
                                        <?php $__currentLoopData = $list_cate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($cate->id); ?>" <?php echo e(request('category') == $cate->id ? 'selected' : ''); ?>><?php echo e($cate->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
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
                                        <th scope="col">id</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Danh mục</th>
                                        <th scope="col">Số view</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-right">
                                            <?php echo e($data->id); ?>

                                        </td>
                                        <td class="">
                                            <a class="row-title" href="<?php echo e(route('admin.postDetail', array($data->id))); ?>">
                                                <b><?php echo e($data->name); ?></b>
                                                <br>
                                                <b style="color:#c76805;"><?php echo e($data->slug); ?></b>                                
                                            </a>
                                        </td>
                                        <td class="text-left">
                                            <?php if($data->category_post->count()): ?>
                                                <?php $__currentLoopData = $data->category_post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('admin.categoryPostDetail', $category->id)); ?>" target="_blank">- <?php echo e($category->name); ?></a>
                                                    <br>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endif; ?>
                                        </td>
                                           <td class="text-right">
                                            <?php echo e($data->description); ?>

                                        </td>
                                      
                                        <td class="text-center">
                                            <?php echo e($data->created_at); ?>

                                            <br>
                                            <?php echo e($data->status == 0 ? 'Draft' : 'Public'); ?>

                                        </td>
                                        <td>
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="<?php echo e(route('admin.postDelete', $data->id)); ?>"><i class="fas fa-trash"></i> Delete</a>
                                            </li>
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
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>

<script type="text/javascript">
	// Default Configuration
		$(document).ready(function() {
			toastr.options = {
				'closeButton': true,
				'debug': false,
				'newestOnTop': false,
				'progressBar': false,
				'positionClass': 'toast-top-right',
				'preventDuplicates': false,
				'showDuration': '1000',
				'hideDuration': '1000',
				'timeOut': '3000',
				'extendedTimeOut': '1000',
				'showEasing': 'swing',
				'hideEasing': 'linear',
				'showMethod': 'fadeIn',
				'hideMethod': 'fadeOut',
			}
		});

	



	
	</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/admin/post/index.blade.php ENDPATH**/ ?>