<?php if($priceFinal > 0): ?>
    <?php
    if($price)
    {
        $price_sale = $price - $priceFinal;
        $price_percent = round($price_sale * 100 / $price);
    }
    ?>
    
    
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money"><?php echo render_price($priceFinal); ?></span></span>
        <?php if(isset($unit) && $unit != ''): ?>
        <span>/ <?php echo $unit; ?></span>
        <?php endif; ?>
    </span>

    <?php if($price): ?>
    <s id="ComparePrice-product-template"><span class="money"><?php echo render_price($price); ?></span></s>
    <?php endif; ?>

<?php else: ?>
    <?php if($price > 0): ?>
    <span class="product-price__price">
        <span id="ProductPrice-product-template"><span class="money"><?php echo render_price($price); ?></span></span>
        <?php if(isset($unit) && $unit != ''): ?>
        <span>/ <?php echo $unit; ?></span>
        <?php endif; ?>
    </span>

    <?php else: ?>
    <span class="product-price__price product-price__price-product-template product-price__sale product-price__sale--single">
        <span id="ProductPrice-product-template"><span class="money">Liên hệ</span></span>
    </span>
    <?php endif; ?>
<?php endif; ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/includes/showPriceDetail.blade.php ENDPATH**/ ?>