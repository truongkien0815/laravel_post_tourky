<?php $__env->startSection('seo'); ?>
<?php echo $__env->make('admin.partials.seo', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="row">
      <div class="col-sm-6">
      </div><!-- /.col -->
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">Dashboard</a></li>
          <li class="breadcrumb-item active">Product</li>
        </ol>
      </div><!-- /.col -->
    </div><!-- /.row -->
</div>
<!-- /.content-header -->
<!-- Main content -->
<section class="content">
	<div class="card">
      	<div class="card-header">
        	<h3 class="card-title">Product</h3>
      	</div> <!-- /.card-header -->
      	<div class="card-body">
            <div class="clear">
                <ul class="nav fl">
                    <li class="nav-item">
                        <a class="btn btn-danger" onclick="delete_id('product')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="<?php echo e(route('admin.createProduct')); ?>" style="margin-left: 6px;"><i class="fas fa-plus"></i> Add New</a>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-primary" href="<?php echo e(route('admin.product.export', ['category_id' => request('category_id'), 'search_title' => request('search_title'), 'page' => request('page')])); ?>" style="margin-left: 6px;"><i class="fas fa-download"></i> Export</a>
                    </li>
                </ul>
                <div class="fr">
                    <form method="GET" action="" id="frm-filter-post" class="form-inline">
                        <?php 
                            $list_cate = App\Model\ShopCategory::where('parent', 0)->orderBy('id', 'ASC')
                                    ->select('id', 'name')->get();
                            $type_cate = App\Model\ShopType::where('parent', 0)->orderBy('id', 'ASC')
                                ->select('id', 'name')->get();
                        ?>
                        <select class="custom-select mr-2" name="category_id">
                            <option value="">Danh mục</option>
                            <?php $__currentLoopData = $list_cate; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($cate->id); ?>" <?php echo e(request('category_id') == $cate->id ? 'selected': ''); ?>><?php echo e($cate->name); ?></option>
                                <?php if(count($cate->children)>0): ?>
                                    <?php $__currentLoopData = $cate->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cate_child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($cate_child->id); ?>" <?php echo e(request('category_id') == $cate_child->id ? 'selected': ''); ?>>   &ensp;&ensp;<?php echo e($cate_child->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>






                        <input type="text" class="form-control" name="search_title" id="search_title" placeholder="Nhập tên hoặc mã SP" value="<?php echo e(request('search_title')); ?>">
                        <button type="submit" class="btn btn-primary ml-2">Search</button>
                    </form>
                </div>
            </div>
            <br/>
            <div class="clear">
                <div class="fl" style="font-size: 16px;">
                    <b>Tổng</b>: <span class="bold" style="color: red; font-weight: bold;"><?php echo e($total_item); ?></span> sản phẩm
                </div>
                <div class="fr">
                    <?php echo $products->withQueryString()->links(); ?>

                </div>
            </div>
            <br/>
            <div class="table-responsive">
                <table class="table table-striped projects" id="table_index">
                    <thead>
                        <tr>
                            <th width="70" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                            <th width="70" class="text-center">STT</th>
                            <th>Tên sản phẩm</th>
                            <th>Kho</th>
                            <th>Danh mục</th>
                            <th class="text-center">Hình ảnh</th>
                            <th class="text-center">Ngày và trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="<?php echo e($data->hot ? 'hot' : ''); ?>">
                            <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
                            <td class="text-center">
                                <?php echo e($data->sort); ?>

                            </td>
                            <td>
                                <a class="row-title" href="<?php echo e(route('admin.productDetail', array($data->id))); ?>">
                                    <b><?php echo e($data->name); ?></b>
                                    <?php if($data->hot): ?>
                                    <span class="badge badge-danger">Hot</span>
                                    <?php endif; ?>
                                </a>
                                <div>Mã: <?php echo e($data->sku); ?></div>
                            </td>
                            <td>
                                <div class="form-inline">
                                    <span class="d-inline mr-2">Số lượng:</span>
                                    <input type="number" name="stock" data-id="<?php echo e($data->id); ?>" min="1" class="form-control form-control-sm" value="<?php echo e($data->stock??0); ?>" style="width: 70px;">
                                </div>

                            </td>
                            <td>
                                <?php
                                    $categories = $data->categories;
                                    //dd($category);
                                ?>
                                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div>
                                        <a class="tag" target="_blank" href="#"><?php echo e($category->name); ?></a>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </td>
                            <td class="text-center">
                                <?php if($data->image != ''): ?>
                                    <img src="<?php echo e(asset($data->image)); ?>" style="height: 50px;">
                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <input type="checkbox" name="my-checkbox" data-id="<?php echo e($data->id); ?>" <?php echo e($data->status?'checked':''); ?> data-bootstrap-switch value="1">
                                <div>
                                    <?php echo e(date('d/m/Y H:i', strtotime($data->created_at))); ?>

                                </div>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
            <div class="fr">
                <?php echo $products->withQueryString()->links(); ?>

            </div>
    	</div> <!-- /.card-body -->
		</div><!-- /.card -->
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script type="text/javascript">
        jQuery(document).ready(function($) {
            $('input[name="stock"]').on('change', function(){
                var id = $(this).data('id'),
                    stock = $(this).val();
                axios({
                    method: 'post',
                    url: '<?php echo e(route("admin_product.updateStock")); ?>',
                    data: {id:id, stock:stock}
                }).then(res => {
                  alertMsg('success', res.data.message);
                }).catch(e => console.log(e));
            });
            $('input[name="my-checkbox"]').on('switchChange.bootstrapSwitch', function(e){
                var id = $(this).data('id'),
                    status = e.target.checked;
                axios({
                    method: 'post',
                    url: '<?php echo e(route("admin_product.updateStatus")); ?>',
                    data: {id:id, status:status}
                }).then(res => {
                  alertMsg('success', res.data.message);
                }).catch(e => console.log(e));
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/product/index.blade.php ENDPATH**/ ?>