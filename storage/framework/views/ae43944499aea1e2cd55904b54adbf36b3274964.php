<?php
    $delivery = $shippingAddress['delivery']??'';
?>
<ul class="list-group mb-3">
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                <?php if($delivery == 'shipping'): ?>
                    <?php echo app('translator')->get('Giao hàng tận nơi'); ?>
                <?php else: ?>
                        <p><?php echo app('translator')->get('Nhận hàng tại cửa hàng'); ?></p>
                        <div>
                            <?php echo $shipping_detail; ?>

                        </div>
                <?php endif; ?>
            </div>
        </div>
    </li>
    <li class="list-group-item">
        <div class="row">
            <div class="col-10">
                <div class="d-flex">
                    <div style="width: 150px;">Người nhận</div>
                    <div style="flex: 1;">
                        <div>Họ tên: <?php echo e($shippingAddress['fullname']); ?></div>
                        <div>Điện thoại: <?php echo e($shippingAddress['phone']); ?></div>
                        <div>Email: <?php echo e($shippingAddress['email']); ?></div>
                        <?php if(!empty($shippingAddress['address_full'])): ?>
                        <div>Địa chỉ: <?php echo e($shippingAddress['address_full']); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-2 text-right">
                <?php if(isset($product)): ?>
                <a href="<?php echo e(route('shop.buyNow', $product->id)); ?>" title="">Thay đổi</a>
                <?php else: ?>
                <a href="<?php echo e(route('cart.checkout', ['edit' => 'checkout'])); ?>" title="">Thay đổi</a>
                <?php endif; ?>
            </div>
        </div>
    </li>
    
</ul><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/includes/comfirm_user.blade.php ENDPATH**/ ?>