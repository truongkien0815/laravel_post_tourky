<?php
    $carts = Cart::content();
    $states = \App\Model\LocationProvince::get();

    if(Auth::check())
        extract(auth()->user()->toArray());
?>
<?php $__env->startSection('content'); ?>
    <div class="container pt-4 pb-3 py-sm-4">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb flex-lg-nowrap justify-content-center justify-content-lg-start">
                <li class="breadcrumb-item"><a class="text-nowrap" href="/"><i class="ci-home"></i>Home</a></li>
                <li class="breadcrumb-item text-nowrap"><a href="<?php echo e(route('cart')); ?>">Giỏ hàng</a>
                </li>
                <li class="breadcrumb-item text-nowrap active" aria-current="page">Đặt hàng</li>
            </ol>
        </nav>
        <div class="rounded-3 shadow-lg mt-4 mb-5">
            <ul class="nav nav-tabs nav-justified mb-sm-4">
                <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4" href="<?php echo e(route('cart')); ?>">1. Giỏ hàng</a></li>
                <li class="nav-item"><a class="nav-link fs-lg fw-medium py-4 active" href="<?php echo e(route('cart.checkout')); ?>">2. Đặt hàng</a></li>
            </ul>
            
            <form class="needs-validation px-3 px-sm-4 px-xl-5 pt-sm-1 pb-4 pb-sm-5" action="<?php echo e(route('cart.checkout.confirm')); ?>" method="post" id="form-checkout">
                <?php echo csrf_field(); ?>
                <input type="hidden" name="shipping_cost" value="0">
                <input type="hidden" name="cart_total" value="<?php echo e(Cart::total(2)); ?>" data-origin="<?php echo e(Cart::total(2)); ?>">
                <input type="hidden" name="res_token" id="res_token" value="">
                <input type="hidden" name="edit" value="<?php echo e(request('edit')); ?>">

                <div class="row billing-fields">
                    <div class="col-lg-7 order-md-1 order-3 sm-margin-30px-bottom">
                        <?php if(!auth()->check()): ?>
                        <div class="box_member_sale">
                            <p>Đăng nhập hoặc đăng ký để nhận nhiều ưu đãi từ chúng tôi</p>
                            <a href="<?php echo e(route('user.login')); ?>" class="text-dark">Đăng nhập</a> / 
                            <a href="<?php echo e(route('user.register')); ?>" class="text-danger">Đăng ký thành viên</a>
                        </div>
                        <?php endif; ?>

                        <ul class="list-group mb-3">
                            <?php $__currentLoopData = $shipping_methods; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="list-group-item">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="delivery_<?php echo e($item->code); ?>" name="delivery" value="<?php echo e($item->code); ?>" class="custom-control-input" <?php echo e($key == 0 ?'checked' : ''); ?>>
                                    <label class="custom-control-label" for="delivery_<?php echo e($item->code); ?>"><?php echo e($item->name); ?></label>
                                    <?php if($item->content): ?>
                                    <div class="ship-content" style="display: none;">
                                        <?php echo $item->content; ?>

                                    </div>
                                    <?php endif; ?>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                        <div class="create-ac-content bg-light-gray padding-20px-all">
                            <div class="shipping_content delivery_content">
                                <fieldset>
                                    <h4 class="order-title mb-4 h4">Địa chỉ nhận hàng</h4>
                                        <div class="mb-3 required">
                                            <label class="form-label" for="input-firstname">Họ & tên <span class="required-f">*</span></label>
                                            <input name="name" value="<?php echo e($shippingAddress['fullname']); ?>" id="input-firstname" type="text" class="form-control">
                                        </div>
                                    <div class="row">
                                        <div class="col-lg-6 mb-3 required">
                                            <label class="form-label" for="input-email">E-Mail <span class="required-f">*</span></label>
                                            <input name="email" value="<?php echo e($shippingAddress['email']); ?>" id="input-email" type="email" class="form-control">
                                        </div>
                                        <div class="col-lg-6 mb-3 required">
                                            <label class="form-label" for="input-telephone">Số điện thoại <span class="required-f">*</span></label>
                                            <input name="phone" value="<?php echo e($shippingAddress['phone']); ?>" id="input-telephone" type="tel" class="form-control">
                                        </div>
                                    </div>
                                </fieldset>

                                <fieldset>
                                    <div class="mb-3 required">
                                        <label class="form-label" for="province">Tỉnh / Thành phố <span class="required-f">*</span></label>
                                        <select name="province" id="province" class="form-select">
                                            <option value=""> --- Chọn Tỉnh / Thành phố --- </option>
                                            <?php $__currentLoopData = $states; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $state): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($state->name); ?>" <?php echo e($shippingAddress['province'] == $state->id || $shippingAddress['province'] == $state->name ? 'selected' : ''); ?>><?php echo e($state->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>

                                    <div class="mb-3 required">
                                        <label class="form-label" for="district">Quận/Huyện <span class="required-f">*</span></label>
                                        <select name="district" id="district" class="form-select" 
                                            data-province="<?php echo e($shippingAddress['province']); ?>" 
                                            data="<?php echo e($shippingAddress['district']); ?>"
                                        >
                                            <option value=""> --- Chọn Quận/Huyện --- </option>
                                        </select>
                                    </div>
                                    <div class="mb-3 required">
                                        <label class="form-label" for="ward">Phường/xã <span class="required-f">*</span></label>
                                        <select name="ward" id="ward" class="form-select" 
                                            data-district="<?php echo e($shippingAddress['district']); ?>" 
                                            data="<?php echo e($shippingAddress['ward']); ?>"
                                        >
                                            <option value=""> --- Chọn Phường/xã --- </option>
                                        </select>
                                    </div>

                                    <div class="mb-3 required">
                                        <label class="form-label" for="input-address-1">Địa chỉ <span class="required-f">*</span></label>
                                        <input name="address_line1" value="<?php echo e($shippingAddress['address_line1']??''); ?>" id="input-address-1" type="text" class="form-control">
                                    </div>
                                </fieldset>
                            </div>

                            <div class="pick_up_content delivery_content" style="display: none;">
                                <h2 class="login-title mb-3 h4">Thông tin nhận hàng</h2>
                                <div class="mb-3">
                                    <label class="form-label" for="input-name">Họ và tên <span class="required-f">*</span></label>
                                    <input name="pick_up-name" value="<?php echo e($fullname ?? ''); ?>" id="input-name" type="text" class="form-control">
                                </div>
                                <div class="mb-3 required">
                                    <label class="form-label" for="input-phone">Số điện thoại <span class="required-f">*</span></label>
                                    <input name="pick_up-phone" value="<?php echo e($phone ?? ''); ?>" id="input-phone" type="tel" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label" for="pick_up-email">E-Mail</label>
                                    <input name="pick_up-email" value="<?php echo e($email ?? ''); ?>" id="pick_up-email" type="email" placeholder="Your Email" class="form-control">
                                </div>
                                <ul class="list-group my-3 shop-address-list">
                                    <li class="list-group-item">
                                        <div class="custom-control custom-radio d-flex">
                                            <input type="radio" id="shop_address" name="shop_address" value="shop_address" class="custom-control-input mt-2 me-3" checked>
                                            <label class="custom-control-label" for="shop_address">
                                                <div><?php echo htmlspecialchars_decode(setting_option('pickup_address')); ?></div>
                                            </label>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            
                            <fieldset>
                                <div class="">
                                    <label class="form-label" for="input-company">Ghi chú đơn hàng</label>
                                    <textarea class="form-control resize-both" rows="3" name="cart_note"><?php echo e($shippingAddress['comment']??''); ?></textarea>
                                </div>
                            </fieldset>

                            <div class="msg-error mb-3" style="display: none;"></div>
                            <div class="cart-btn text-center">
                                <button class="btn-main mt-3  submit-confirm" value="Place order" type="button" >Xác nhận đơn hàng</button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 ps-xl-4 order-2">
                        <div class="your-order-payment h-100 border-start ps-lg-3">
                            <?php echo $__env->make($templatePath .'.cart.includes.checkout_cart_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php echo $__env->make($templatePath .'.cart.includes.payment-method', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-style'); ?>
<link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/cart.css?ver=1.01')); ?>">
<style>
    .msg-error{
        color: #f00;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-footer'); ?>
    
    <?php $__currentLoopData = $totalMethod; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $plugin): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if ($__env->exists($plugin['pathPlugin'].'::script')) echo $__env->make($plugin['pathPlugin'].'::script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    <script type="application/javascript" src = "https://checkout.stripe.com/checkout.js" > </script> 
    <script src="<?php echo e(asset('/js/jquery.validate.min.js')); ?>"></script>
    <script src="<?php echo e(asset($templateFile .'/js/cart.js?ver='. time())); ?>"></script>
    <?php if(env('GHN_ACTIVE')): ?>
    <script src="<?php echo e(asset('/js/ghn.js?ver='. time())); ?>"></script>
    <?php endif; ?>

    <?php echo $__env->make($templatePath .'.cart.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/checkout.blade.php ENDPATH**/ ?>