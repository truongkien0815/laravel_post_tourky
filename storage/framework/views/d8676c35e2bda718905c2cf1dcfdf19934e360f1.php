<?php 
    
    $cate_type = App\Model\ShopType::all();
    $cate_shop = App\Model\ShopCategory::where('parent','0')->get();
    $cate_shop_leve2 = App\Model\ShopCategory::all();
    $cate_shop_leve3 = App\Model\ShopCategory::where('parent','!=','0')->limit(8)->get();

    $product_new = App\Product::limit(7)->get();
    $product_item = App\Product::all();

    
?>
<section class="product-grid-section">
    <div class="container">
        <div class="row g-3">
            <div class="col-md-4 col-lg-3">


                <div class="sidebar">
                    <h3 class="title-cate">DANH MỤC SẢN PHẨM</h3>
                    <?php $__currentLoopData = $cate_shop; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="item-cate-sidebar">
                        
                       
                       
                       
                        
                      
                        <div class="item-cate-content">
                            <ul>
                                
                                <li>
                                    <a href="<?php echo e($item->slug.'.html'); ?>">  <?php echo e($item->name); ?> <i class="fa-regular fa-chevron-right"></i></a>
                                  
                                    <ul class="sub-menu">
                                          <?php $__currentLoopData = $cate_shop_leve2; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item_nho): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($item->id == $item_nho->parent): ?>
                                        <li>
                                            <a href="<?php echo e($item_nho->slug.'.html'); ?>"><?php echo e($item_nho->name); ?></a>
                                        </li>
                                          <?php else: ?>
                        
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                      
                                    </ul>
                                    
                                </li>
                                
                            </ul>
                        </div>
                      
                       

                       
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <div class="col-md-8 col-lg-9">
                <div class="list-product-right">
                    <?php if(!empty($category)): ?>
                    <h5><?php echo e($category->name); ?></h5>
                  <?php   $cate_shop_leve4 = App\Model\ShopCategory::where('parent','=',$category->parent)->get();
                  
                  $cate_shop_leve44 = App\Model\ShopCategory::where('parent','=',$category->id)->get();
                  ?>
                  
                    <?php else: ?>
                    <h5>Sản phẩm</h5>
                    <?php endif; ?>
                    <div class="list-tag">
                        <ul>
                            
                          
                            
                            <?php if(empty($category)): ?>
                            <?php $__currentLoopData = $cate_shop_leve3; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                         
                            <li class="product-photo" data-product-id="<?php echo e($item->id); ?>"><a href="#sort"><?php echo e($item->name); ?></a></li>
                        
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            <?php else: ?>
                <?php if($category->parent == 0): ?>
                <?php $__currentLoopData = $cate_shop_leve44; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                         
                <li class="product-photo" data-product-id="<?php echo e($item->id); ?>"><a href="#sort"><?php echo e($item->name); ?></a></li>

                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <?php $__currentLoopData = $cate_shop_leve4; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                         
            <li class="product-photo" data-product-id="<?php echo e($item->id); ?>"><a href="#sort"><?php echo e($item->name); ?></a></li>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
                          
                            
                            <?php endif; ?> 
                           
                        </ul>
                        <div class="spinner-border d-none loader" role="status">
							<span class="sr-only">Loading...</span>
						  </div>
                    </div>
                    <div class="products" id="#sort">
                        <?php $__currentLoopData = $products; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                     
                        <div class="item-product">
                            <a href="<?php echo e($product->slug.'.html'); ?>">
                                <div class="product-img">
                                    <img src="<?php echo e(asset($product->image)); ?>" alt="" />
                                </div>
                            </a>
                            <div class="item-product-body">
                                <h3><a href="<?php echo e($product->slug.'.html'); ?>"><?php echo e($product->name); ?></a></h3>
                                <div class="price-cart">
                                  <span class="price">
                                    <?php echo $product->showPrice(); ?>

                                 </span>
                                        
                                    <a href="<?php echo e($product->slug.'.html'); ?>">  <img src="<?php echo e(asset('img/cart.png')); ?>" alt="" /></a>
                                  
                                </div>
                            </div>
                        </div>
                      
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                       

                    </div>
                </div>
                <?php if(empty($category)): ?>
                <div class="product-view-more btn-loadmore" data-url="<?php echo e(route('product.loadmore')); ?>">
                    <button class="btn">xem thêm</button>
                </div>
                <?php else: ?>
                <div class="product-view-more btn-loadmo">
                <?php echo $products->links(); ?>

            </div>
                <?php endif; ?>
               
            </div>
        </div>
    </div>
</section>
  <!-- Product Grid Section End -->
  </main>

  
<?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/product/includes/product-list.blade.php ENDPATH**/ ?>