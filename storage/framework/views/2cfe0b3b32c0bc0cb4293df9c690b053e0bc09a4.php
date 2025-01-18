<?php $__env->startSection('seo'); ?>
<?php echo $__env->make($templatePath .'.layouts.seo', $seo??[] , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>

<?php
    $carts = Cart::content();
    //$variable_group = App\Model\Variable::where('status', 0)->where('parent', 0)->orderBy('stt','asc')->pluck('name', 'id');

    $states = \App\Model\LocationProvince::get();

    if(Auth::check())
        extract(auth()->user()->toArray()); 

    //get shipping detail
    if(!empty($delivery) && $delivery == 'shipping')
    {
        //$shipping_detail = implode(', ', array_filter([$address_line1??'', $customer_ward??'', $customer_district??'', $customer_province??'']));
        $shipping_detail = sc_render_address($shippingAddress);
    }
    else
        $shipping_detail = htmlspecialchars_decode(setting_option('pickup_address'));
    
    //get shipping detail

?>
<?php $__env->startSection('content'); ?>
    <div id="page-content" class="page-template page-checkout">
        <div class="container pt-4 pb-3 py-sm-4">
        <!--Page Title-->
        <div class="page section-header text-center">
            <div class="page-title">
                <div class="wrapper">
                    <h3 class="page-width mb-5">Xác nhận đơn hàng</h3>
                </div>
            </div>
        </div>
        <!--End Page Title-->
        <form action="<?php echo e(route('cart_checkout.process')); ?>" method="post" id="form-checkout">
            <?php echo csrf_field(); ?>
            <input type="hidden" name="res_token" id="res_token" value="">

            <div class="container">
                <div class="row billing-fields">

                    <div class="col-lg-7 sm-margin-30px-bottom">
                        <?php echo $__env->make($templatePath .'.cart.includes.comfirm_user', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        <div class="create-ac-content bg-light-gray padding-20px-all">
                            <div class="msg-error mb-3" style="display: none;"></div>
                            <div class="cart-btn">
                                <button class="btn-main w-100 mt-3 submit-checkout" value="Place order" type="button" ><?php echo app('translator')->get('Đặt hàng'); ?></button>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5 ps-xl-4">
                        <div class="your-order-payment h-100 border-start ps-lg-3">
                            <?php echo $__env->make($templatePath .'.cart.includes.comfirm_cart_item', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                            <?php echo $__env->make($templatePath .'.cart.includes.payment-method', ['payment_method' => $payment_method??''], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                        </div>
                    </div>
                </div>
            </div>
        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('head-style'); ?>
<link rel="stylesheet" href="<?php echo e(url($templateFile .'/css/cart.css?ver=1.12')); ?>">
<style>
    .msg-error{
        color: #f00;
    }
</style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('after-footer'); ?>
<script type="application/javascript" src = "https://checkout.stripe.com/checkout.js" > </script> 
<script src="<?php echo e(asset($templateFile .'/js/cart.js?ver='. time())); ?>"></script>
<?php if(env('GHN_ACTIVE')): ?>
<script src="<?php echo e(asset('/js/ghn.js?ver='. time())); ?>"></script>
<?php endif; ?>
    <?php echo $__env->make($templatePath .'.cart.scripts', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>

<?php echo $__env->make($templatePath .'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/cart/checkout-confirm.blade.php ENDPATH**/ ?>