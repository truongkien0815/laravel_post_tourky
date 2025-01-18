<?php
    $url_current = url()->current();
    $add_cart_disabled = 'disabled';
    if($product->stock != 0 && $product->getFinalPrice() != 0)
    {
       $add_cart_disabled = '';
    }
    $sale = 0;
    if($product->promotion && $product->price){
        $sale = round(100 - ($product->promotion * 100 / $product->price));
    }
?>
<div class="price">
    <p>
        <ins><?php echo $product->showPriceDetail(); ?></ins>
    </p>
    <?php echo $sale > 0 ? '<div class="sale-detail">-'.$sale.'%</div>' : ''; ?>

</div>



 <div class="product-single__addtocart">
     <form action="<?php echo e(route('cart.ajax.add')); ?>" id="product_form_addCart" accept-charset="UTF-8" enctype="multipart/form-data">
         <input type="hidden" name="product" value="<?php echo e($product->id); ?>">
 
         <div class="product-single__options">
             <div class="product-attr-content">
                 <?php echo $product->product_variables(); ?>

             </div>
             <?php if(!$product->stock): ?>
                 <div class="outofstock">
                     <span>Hết hàng</span>
                 </div>
             <?php endif; ?>
         </div>
         <div class="product-single__actions">
             <div class="product-single__quantity">
                 <div class="quantity qtyField <?php echo e($disabled); ?>" rel-script="quantity-change">
                     <a href="javascript:void(0);" class="quantity__reduce qtyBtn minus">-</a>
                     <input type="number" id="Quantity" name="qty" value="1" max="99" min="1" class="quantity__control product-form__input qty">
                     <a href="javascript:void(0);" class="quantity__augure qtyBtn plus">+</a>
                       
                 </div>
             </div>


             
             <div class="product-single__button <?php echo e($add_cart_disabled); ?>">
                 <a href="javascript:;" class=" product-form__cart-add <?php echo e($add_cart_disabled); ?>">THÊM VÀO GIỎ</a>
             </div>
         </div>
     </form>
 </div>
 








<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-summary.blade.php ENDPATH**/ ?>