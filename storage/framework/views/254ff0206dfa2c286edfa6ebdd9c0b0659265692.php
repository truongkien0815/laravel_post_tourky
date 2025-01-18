<div class="your-order">
    <h4 class="order-title mb-3">Đơn hàng</h4>
    <?php $weight = 0; ?>
    <div>
        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php 

            $product = \App\Product::find($cart->id); 
            $product_weight = $product->attrs()->where('name', 'weight')->first();
            if($product_weight && $product_weight->content !='')
                $weight = $weight + ($product_weight->content * $cart->qty ) ;

            
            if($cart->options)
            {
                $option_key_first = array_key_first($cart->options->toArray());
                $item_id = explode('__', $option_key_first)[1]??0;
                $product_item = \App\Model\ShopProductItem::find($item_id);
                // $img = $product_item->getGallery()[0]??'';
            }

            $disabled = '';
            if($product->stock < $cart->qty)
                $disabled = 'disabled';
        ?>
        <div class="cart__row_item <?php echo e($disabled); ?>">
            <a href="<?php echo e(route('shop.detail', $product->slug)); ?>">
                <img src="<?php echo e(asset($img??$product->image)); ?>" alt="<?php echo e($product->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';" width="120">
            </a>
            <div class="info_right">
                <div class=" product-title"><a href="<?php echo e(route('shop.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></div>
                <?php if($product->unit): ?>
                <div class="fs-sm"><span class="text-muted me-2">Đơn vị:</span><?php echo e($product->unit); ?></div>
                <?php endif; ?>
                <?php echo $__env->make($templatePath .'.cart.includes.render-attr-item', ['options' => $cart->options], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="d-flex cart__meta-text">
                    <div class="w-100">Số lượng: <?php echo e($cart->qty); ?></div>
                    <div class="w-100 fs-6 text-danger text-end"><?php echo render_price($cart->price * $cart->qty); ?></div>
                </div>
                
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>

    <input type="hidden" name="weight" value="<?php echo e($weight); ?>">
    
    <!-- <div class="text-end py-2">
        <div>
            <span>Tổng số tiền</span>
            <span class="ps-5 fs-5 text-danger cart_total_text" data="<?php echo render_price(Cart::total(2)); ?>"><?php echo render_price(Cart::total(2)); ?></span>
        </div>
    </div> -->
    <div class="text-end py-2">
        <?php $__currentLoopData = $totalMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if ($__env->exists($plugin['pathPlugin'].'::render')) echo $__env->make($plugin['pathPlugin'].'::render', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <?php echo $__env->make($templatePath.'.cart.render_total', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    </div>
</div>
<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/includes/checkout_cart_item.blade.php ENDPATH**/ ?>