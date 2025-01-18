<?php $__env->startSection('content'); ?>
<div class="container pb-5 mb-sm-4">
    <div class="pt-5 text-center">
        <h2 class="h4"><?php echo e($title); ?></h2>
        <p class="fs-sm mb-2"><?php echo e(sc_language_render('checkout.order_success_msg')); ?></p>
    </div>
    <?php if(!empty($orderInfos)): ?>
    <div class="row g-3 justify-content-center">
        <?php $__currentLoopData = $orderInfos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $order): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-6 col-lg-4">
            <div class="card py-3 mt-sm-3">
            <div class="card-body text-center">
              <p class="fs-sm mb-2">Mã đơn hàng: <b class='fw-medium'><?php echo e($order['code']); ?></b></p>
              <p class="fs-sm mb-2">Tổng tiền: <b class='fw-medium'><?php echo sc_currency_render_symbol($order['total']); ?></b></p>
              <!-- <p class="fs-sm">You will be receiving an email shortly with confirmation of your order. <u>You can now:</u></p> -->
              <a class="btn btn-secondary mt-3 me-3" href="/">Tiếp tục mua sắm</a>
              <!-- <a class="btn btn-primary mt-3" href="order-tracking.html"><i class="ci-location"></i>&nbsp;Track order</a> -->
            </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
        
    <?php endif; ?>
    
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/shop_order_success.blade.php ENDPATH**/ ?>