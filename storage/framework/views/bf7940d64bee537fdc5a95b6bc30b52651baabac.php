<div class="container cart_container pt-4 pb-3 py-sm-4">
    <?php if($carts->count()): ?>
    <div class="rounded-3 shadow-lg mt-4 mb-5">
        <ul class="nav nav-tabs nav-justified mb-4">
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4 active" href="<?php echo e(route('cart')); ?>">1. Giỏ hàng</a></li>
            <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4" href="<?php echo e(route('cart.checkout')); ?>">2. Thanh toán</a></li>
        </ul>
        <div class="px-3 px-sm-4 px-xl-5 pt-1 pb-4 pb-sm-5">
            <form action="#" method="post" class="cart style2">
                <div class="row">
                    <!-- Items in cart-->
                    <div class="col-lg-8 col-md-7 pt-sm-2">
                        <?php $__currentLoopData = $carts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php 
                            $product = \App\Product::find($cart->id);
                            $disabled = '';
                            if($product->stock < $cart->qty)
                                $disabled = 'disabled';

                            if($cart->options)
                            {
                                $option_key_first = array_key_first($cart->options->toArray());
                                $item_id = explode('__', $option_key_first)[1]??0;
                                $product_item = \App\Model\ShopProductItem::find($item_id);
                                // $img = $product_item->getGallery()[0]??'';
                            }
                        ?>
                            <!-- Item-->
                            <div class="">
                                <?php if($disabled!=''): ?>
                                <div class="text-danger"><i>Sản phẩm hết hàng</i></div>
                                <?php endif; ?>
                                <div class="cart__row_item d-sm-flex mt-3 mb-4 pb-3 border-bottom <?php echo e($disabled); ?>">
                                    <div class="d-block d-sm-flex text-center text-sm-start" style="flex: 1">
                                        <a class="d-inline-block flex-shrink-0 mx-auto me-sm-4" href="<?php echo e(route('shop.detail', $product->slug)); ?>">
                                            <img src="<?php echo e(asset($img??$product->image)); ?>" alt="<?php echo e($product->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/no-image.jpg')); ?>') this.src = '<?php echo e(asset('assets/images/no-image.jpg')); ?>';" width="120">
                                        </a>
                                        <div style="flex: 1">
                                            <div class=" product-title fs-base mb-2"><a href="<?php echo e(route('shop.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></div>
                                            <?php if($product->unit): ?>
                                            <div class="fs-sm"><span class="text-muted me-2">Đơn vị:</span><?php echo e($product->unit); ?></div>
                                            <?php endif; ?>
                                            <?php echo $__env->make($templatePath .'.cart.includes.render-attr-item', ['options' => $cart->options], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            <div class="fs-5 text-danger pt-2"><?php echo render_price($cart->price); ?></div>
                                        </div>
                                    </div>
                                    <div class="pt-2 pt-sm-0 ps-sm-3 mx-auto mx-sm-0 text-center text-sm-start" style="max-width: 9rem;">
                                        <label class="form-label" for="quantity1">Số lượng</label>
                                        <input class="form-control cart__qty-input" type="number"name="updates[]" id="quantity1" value="<?php echo e($cart->qty); ?>" min="1" data-rowid="<?php echo e($cart->rowId); ?>">
                                        <button class="btn btn-link px-0 text-danger cart__remove" type="button" data="<?php echo e($cart->rowId); ?>"><i class="ci-close-circle me-2"></i><span class="fs-sm">Xóa</span></button>
                                    </div>
                                    <div class="px-2 text-center" style="min-width: 9rem;">
                                        <div class="mb-3">Thành tiền</div>
                                        <h5><?php echo render_price($cart->price * $cart->qty); ?></h5>
                                    </div>
                                </div>
                            </div>
                            <!-- Item-->
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <!-- Sidebar-->
                    <div class="col-lg-4 col-md-5 pt-3 pt-sm-4">
                        <div class="rounded-3 bg-light px-3 px-sm-4 py-4">
                            <div class="text-center mb-4 pb-3 border-bottom">
                                <h3 class="h5 mb-3 pb-1">Thành tiền</h3>
                                <h4 class="fw-normal cart_total"><?php echo render_price(Cart::total(2)); ?></h4>
                            </div>
                            
                            <a class="btn-main text-center d-block w-100 mt-4 mb-3" href="<?php echo e(route('cart.checkout')); ?>"><i class="ci-card fs-lg me-2"></i>Thanh toán</a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php else: ?>
    <div class="alert alert-danger text-uppercase mt-5" role="alert">
        <i class="ci-loudspeaker"></i> &nbsp;<?php echo app('translator')->get('Cart is empty!'); ?>
    </div>
    <?php endif; ?>

</div><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/cart-list.blade.php ENDPATH**/ ?>