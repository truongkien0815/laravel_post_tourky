
<?php if($priceFinal > 0 && $price): ?>
    <?php
    $price_sale = $price - $priceFinal;
    $price_percent = round($price_sale * 100 / $price);
    ?>
    
   <div class="product-price d-flex flex-wrap align-items-center">
      <span class="price px-2">
         <ins>
            <span><?php echo render_price($priceFinal); ?></span>
         </ins>
         <?php if(!empty($unit)): ?>
            <span>/ <?php echo $unit; ?></span>
         <?php endif; ?>
      </span>
      <del class="fs-sm text-muted px-2"><?php echo render_price($price); ?></del>
   </div>
<?php else: ?>
   <?php if($price>0): ?>
      <div class="product-price d-flex align-items-center">
         <span class="price">
            <ins>
               <span><?php echo render_price($price); ?></span>
            </ins>
         </span>
         <?php if(!empty($unit)): ?>
            <span>/ <?php echo e($unit); ?></span>
         <?php endif; ?>
      </div>
   <?php else: ?>
      <div class="product-price d-flex align-items-center">
         <span class="price">Liên hệ</span>
      </div>
   <?php endif; ?>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/product/includes/showPrice.blade.php ENDPATH**/ ?>