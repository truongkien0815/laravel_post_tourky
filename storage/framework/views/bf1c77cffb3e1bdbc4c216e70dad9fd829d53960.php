<div class="row">
    <div class="form-group col-md-12">
      
      <div id="coupon-group" class="input-group <?php echo e(Session::has('error_discount')?'has-error':''); ?>">
        <input type="text" <?php echo e(($plugin['permission'])?'':'disabled'); ?> placeholder="Your coupon" class="form-control" id="coupon-value" aria-describedby="inputGroupSuccess3Status">
        <div class="input-group-prepend">
        <span class="input-group-text <?php echo e(($plugin['permission'])?'':'disabled'); ?>"  <?php echo ($plugin['permission'])?'id="coupon-button"':''; ?> style="cursor: pointer;" data-loading-text="<i class='fa fa-spinner fa-spin'></i> checking"><?php echo e(sc_language_render('cart.apply')); ?></span>
        </div>
      </div>
      <span class="status-coupon" style="display: none;" class="glyphicon glyphicon-ok form-control-feedback" aria-hidden="true"></span>
      <div class="coupon-msg  <?php echo e(Session::has('error_discount')?'text-danger':''); ?>" style="text-align: left; font-size: 13px; margin-top: 5px; <?php echo e(Session::has('error_discount')? 'color:red':''); ?>"><?php echo e(Session::has('error_discount')?Session::get('error_discount'):''); ?></div>
    </div>
</div>
<?php /**PATH D:\laragon\www\congnghiepnew\app\Plugins\Total\Discount/Views/render.blade.php ENDPATH**/ ?>