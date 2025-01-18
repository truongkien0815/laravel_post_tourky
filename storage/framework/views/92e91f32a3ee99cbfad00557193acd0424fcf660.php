<?php
    $sale = 0;
    if($product->promotion && $product->price){
        $sale = round(100 - ($product->promotion * 100 / $product->price));
    }
    $color_first = $product->getColor();
?>

<div class="item-product">
    <a href="<?php echo e(route('shop.detail', $product->slug)); ?>">
        <div class="product-img">
           
            <img class="item-img" src="<?php echo e(asset($product->image)); ?>" title="<?php echo e($product->name); ?> <?php echo e($product->sku); ?>" alt="<?php echo e($product->name); ?>" onerror="if (this.src != '<?php echo e(asset('assets/images/placeholder.png')); ?>') this.src = '<?php echo e(asset('assets/images/placeholder.png')); ?>';">
        </div>
    </a>
    <div class="item-product-body">
        <h3><a href="<?php echo e(route('shop.detail', $product->slug)); ?>"><?php echo e($product->name); ?></a></h3>
        <div class="price-cart">
            <span class="price"> <?php echo $product->showPrice(); ?> <span></span></span>
            <a href="<?php echo e(route('shop.detail', $product->slug)); ?>"><img src="img/cart.png" alt="" /></a>
            
            
        </div>
    </div>
</div>

<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-item.blade.php ENDPATH**/ ?>