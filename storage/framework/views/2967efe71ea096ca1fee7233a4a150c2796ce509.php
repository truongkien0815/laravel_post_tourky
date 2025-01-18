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
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0 text-dark">List Category Post</h1>
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">List Category Post</li>
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
		            	<h3 class="card-title">List Category Post</h3>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <ul class="nav">
                            
                            <li class="nav-item">
                                <a class="btn btn-primary" href="<?php echo e(route('admin.createCategoryPost')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                            </li>
                        </ul>
                        <br/>

                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col">id</th>
                                        <th scope="col">Tiêu đề</th>
                                        <th scope="col">Số bài viết</th>
                                        <th scope="col">Số view</th>
                                        <th scope="col">Ngày tạo</th>
                                        <th scope="col">Thao tác</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $data_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td class="text-center"><?php echo e($data->id); ?></td>
                                        <td class="">
                                            <a class="row-title" href="<?php echo e(route('admin.categoryPostDetail', array($data->id))); ?>">
                                                <b><?php echo e($data->name); ?></b>
                                                <br>
                                                
                                            </a>
                                            <div>
                                                <?php if($data->slug): ?>
                                                <a href="<?php echo e(route('news.single', $data->slug)); ?>" title="">
                                                    <b style="color:#c76805;"><?php echo e(route('news.single', $data->slug)); ?></b>
                                                </a>
                                                <?php else: ?>
                                                0
                                                <?php endif; ?>
                                            </div>
                                        </td>
                                        <td class="text-right">
                                           <?php echo e($data->post()->count()); ?>


                                           
                                        </td>
                                        <td class="text-right">
                                            <?php
                                            $totals = 0;  // Khởi tạo biến tổng
                                        ?>
                                        
                                        <?php $__currentLoopData = $data->post; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $totals += (int)$item->description;  // Cộng dồn giá trị description (ép kiểu thành số nguyên)
                                            ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                         <?php echo e($totals); ?>

                                        
                                            
                                           
                                          
                                        </td>
                                        <td class="text-center">
                                            <?php echo e($data->created_at); ?>

                                            <br>
                                            <?php echo e($data->status == 0 ? 'Draft' : 'Public'); ?>

                                        </td>
                                        <td>
                                            <li class="nav-item">
                                                <a class="btn btn-danger"  href="<?php echo e(route('admin.category_postDelete', $data->id)); ?>"><i class="fas fa-trash"></i> Delete</a>     
                                            </li>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $data_category->links(); ?>

                        </div>

		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/admin/category/index.blade.php ENDPATH**/ ?>