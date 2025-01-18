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
          <li class="breadcrumb-item active">List Orders</li>
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
		            	<h4>List Orders</h4>
		          	</div> <!-- /.card-header -->
		          	<div class="card-body">
                        <div class="clear">
                            <ul class="nav fl">
                                <li class="nav-item">
                                    <a class="btn btn-danger" onclick="delete_id('order')" href="javascript:void(0)"><i class="fas fa-trash"></i> Delete</a>
                                </li>
                            </ul>
                            <div class="fr">
                                <form method="GET" action="" id="frm-filter-post" class="form-inline">
                                    <input type="text" class="form-control" name="keyword" id="keyword" placeholder="Mã đơn hàng" value="<?php echo e(request('keyword')??''); ?>">
                                    <button type="submit" class="btn btn-primary ml-2">Search</button>
                                </form>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <a class="btn <?php echo e(request('status')!='' ? 'btn-outline-primary' : 'btn-primary'); ?>" href="<?php echo e(url()->current()); ?>">Tất cả</a>
                            </div>
                        </div>
                        <br/>
                        <div class="clear">
                            <div class="fr">
                                <?php echo $orders->appends(request()->input())->links(); ?>

                            </div>
                        </div>
                        <br/>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="table_index">
                                <thead>
                                    <tr>
                                        <th scope="col" class="text-center"><input type="checkbox" id="selectall" onclick="select_all()"></th>
                                        <th scope="col" class="text-center">Mã đơn hàng</th>
                                        <th scope="col" class="text-center">Tên khách hàng</th>
                                        <th scope="col" class="text-center">Thời gian đặt</th>
                                        <th scope="col" class="text-center">Tổng tiền</th>
                                        <th scope="col" class="text-center">Vận chuyển</th>
                                        <th scope="col" class="text-center">Thanh toán</th>
                                        <th scope="col" class="text-center">Trạng thái</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $orders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $payment = \App\Model\PaymentRequest::where('cart_id', $data->cart_id)->first();
                                        $shipping_order = $data->getShippingOrder;
                                    ?>
                                    <tr>
                                        <td class="text-center"><input type="checkbox" id="<?php echo e($data->id); ?>" name="seq_list[]" value="<?php echo e($data->id); ?>"></td>
                                        <td class="text-center">
                                            <a class="row-title" href="<?php echo e(route('admin.orderDetail', array($data->id))); ?>">
                                                <b><?php echo e($data->code); ?></b>
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            <div class="text-danger"><?php echo e($data->first_name); ?></div>
                                            <?php echo e($data->email); ?>

                                        </td>
                                        <td class="text-center">
                                            <?php echo e($data->created_at); ?>

                                        </td>
                                        <td class="text-center">
                                            <span class='b text-danger'><?php echo sc_currency_render_symbol($data->total ?? 0, $data->currency); ?></span>
                                        </td>
                                        <td class="text-center">
                                            <?php echo e(sc_currency_render_symbol($data->shipping ?? 0, $data->currency)); ?>

                                        </td>
                                        <td class="text-center">
                                            <?php if($data->payment_status == 3): ?>
                                            <span class="badge badge-success cart-status-<?php echo e($data->cart_status); ?>"><?php echo e($statusPayment[$data->payment_status]??$data->payment_status); ?></span>
                                            <?php else: ?>
                                            <span class="badge badge-info cart-status-<?php echo e($data->cart_status); ?>"><?php echo e($statusPayment[$data->payment_status]??$data->payment_status); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-info cart-status-<?php echo e($data->cart_status); ?>"><?php echo e($statusOrder[$data->status]??''); ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <div class="fr">
                            <?php echo $orders->appends(request()->input())->links(); ?>

                        </div>
		        	</div> <!-- /.card-body -->
	      		</div><!-- /.card -->
	    	</div> <!-- /.col -->
	  	</div> <!-- /.row -->
  	</div> <!-- /.container-fluid -->
</section>
<?php $__env->stopSection(); ?>

<style type="text/css">
    .cart-status-1{
        color: #fff !important;
        background-color: #007bff!important;
    }
    .cart-status-2{
        color: #fff !important;
        background-color: #17a2b8!important;
    }
    .cart-status-3{
        color: #fff !important;
        background-color: #dc3545!important;
    }
    .cart-status-4{
        background-color: #ffc107!important;
    }
    .cart-status-5{
        background-color: #28a745!important;
        color: #fff !important;
    }

</style>
<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/admin/orders/index.blade.php ENDPATH**/ ?>