<?php
    $payment_methods = (new \App\Model\ShopPaymentMethod)->getListActive();
    $payment_method = $cart_info['payment_method']??'';
    //dd($payment_method);
?>

<div class="your-payment">
    <h4 class="order-title mt-4 mb-3">Phương thức thanh toán</h4>
    <?php $__currentLoopData = $payment_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php
        $checked = '';
        if($payment_method == '' && $index == 0)
            $checked = 'checked';
        elseif($payment_method == $item->code)
            $checked = 'checked';

    ?>
    <div class="payment-item mb-3">
        <div class="custom-control custom-radio mr-2">
            <input type="radio" id="payment_<?php echo e($item->code); ?>" name="payment_method" value="<?php echo e($item->code); ?>" class="custom-control-input" <?php echo e($checked); ?>>
            <label class="custom-control-label" for="payment_<?php echo e($item->code); ?>">
                <img src="<?php echo e(asset($item->image)); ?>" alt="" width="50">
                <?php echo e($item->name); ?>

            </label>
        </div>

        <?php if($payment_method == $item->code && view()->exists($templatePath .'.payment.includes.'. $item->code)): ?>
            <?php echo $__env->make($templatePath .'.payment.includes.'. $item->code, \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php elseif($item->content): ?>
            <div class="payment-content <?php echo e($checked?'active':''); ?>">
                <?php echo htmlspecialchars_decode(htmlspecialchars_decode($item->content)); ?>

            </div>
        <?php endif; ?>
        <?php if($item->posts()->count()): ?>
            <div class="select-include" style="display: none;">
                <div class="banklist mt-3">
                    <label class="mb-2">Bạn hãy chọn ngân hàng <span class="redcolor">*</span></label>
                    <br>

                    <div class="d-flex flex-wrap">
                        <?php $__currentLoopData = $item->posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <label>
                            <input type="radio" name="bank_code" value="<?php echo e($item->code); ?>" <?php echo e(session("bank_code") == $item->code ? 'checked' : ''); ?>>
                            <div class="img">
                                <img src="<?php echo e(asset($item->image)); ?>" title="<?php echo e($item->name); ?>">
                            </div>
                        </label>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <div class="payment-method">                                    
        <div class="order-button-payment"></div>
    </div>
</div><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/includes/payment-method.blade.php ENDPATH**/ ?>