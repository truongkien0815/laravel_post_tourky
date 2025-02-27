<script type="text/javascript">
jQuery(document).ready(function($) {
        
    $('#coupon-button').click(function() {
        var coupon = $('#coupon-value').val();
           if(coupon==''){
               $('#coupon-group').addClass('has-error');
               $('.coupon-msg').html('<?php echo e(sc_language_render('cart.coupon_empty')); ?>').addClass('text-danger').show();
           }else{
           $('#coupon-button').prop('disabled', true);
           setTimeout(function() {
               $.ajax({
                   url: '<?php echo e(route('discount.process')); ?>',
                   type: 'POST',
                   dataType: 'json',
                   data: {
                       code: coupon,
                       uID: <?php echo e(session('customer')->id ?? 0); ?>,
                       _token: "<?php echo e(csrf_token()); ?>",
                   },
               })
               .done(function(result) {
                       $('#coupon-value').val('');
                       $('.coupon-msg').removeClass('text-danger');
                       $('.coupon-msg').removeClass('text-success');
                       $('#coupon-group').removeClass('has-error');
                       $('.coupon-msg').hide();
                   if(result.error ==1){
                       $('#coupon-group').addClass('has-error');
                       $('.coupon-msg').html(result.msg).addClass('text-danger').show();
                   }else{
                       $('#removeCoupon').show();
                       $('.coupon-msg').html(result.msg).addClass('text-success').show();
                       $('.showTotal').remove();
                       $('#showTotal').prepend(result.html);
                   }
               })
               .fail(function() {
                   console.log("error");
               })
              $('#coupon-button').prop('disabled', false);
          }, 1000);
           }
    
       });
       $(document).on('click', '#removeCoupon', function() {
               $.ajax({
                   url: '<?php echo e(route('discount.remove')); ?>',
                   type: 'POST',
                   dataType: 'json',
                   data: {
                       _token: "<?php echo e(csrf_token()); ?>",
                   },
               })
               .done(function(result) {
                       $('#removeCoupon').hide();
                       $('#coupon-value').val('');
                       $('.coupon-msg').removeClass('text-danger');
                       $('.coupon-msg').removeClass('text-success');
                       $('.coupon-msg').hide();
                       $('.showTotal').remove();
                       $('#showTotal').prepend(result.html);
               })
               .fail(function() {
                   console.log("error");
               })
       });
    });
</script><?php /**PATH D:\laragon\www\congnghiepnew\app\Plugins\Total\Discount/Views/script.blade.php ENDPATH**/ ?>