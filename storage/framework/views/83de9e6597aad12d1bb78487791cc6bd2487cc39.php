<?php
    extract($data);
    $gallery = $product->getGallery() ?? '';

    $spec_short = $product->spec_short ?? '';
    if($spec_short != '')
        $spec_short = json_decode($spec_short, true);

    $product_stock = $product->checkStock();
     $disabled = 'disabled';
     if($product_stock)
        $disabled = '';
?>



<?php $__env->startSection('seo'); ?>

<?php $__env->startSection('content'); ?>
<main class="main">
    <!-- Breadcrumb Section Begin -->
    <section class="breadcrumb-detail-section">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb-text">
                        <div class="bt-option">
                            <a href="/">Trang chủ</a>
                            <a href="/san-pham">Sản phẩm</a>
                            
                            <a href="<?php echo e(route('shop.detail', $category->slug)); ?>"><?php echo e($category->name??''); ?></a>
                            <span><?php echo e($product->name); ?></span>
                          
                        
                          
                           
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->
    <div class="product-single">
        <div class="container">
            <div class="row g-4">
                
                <div class="col-lg-8">
                    
                </div>
            </div>
          
        </div>
    </div>



    <!-- Product Detail Section Begin -->
    <section class="detail-product-section pb-5">
        <div class="container">
            <div class="row">
                
                <div class="col-md-5 col-lg-6">


                    <?php if(!empty($gallery)): ?>
                    <div class="pdp-image-gallery-block">
                        <!-- Gallery -->
                        <div class="gallery_pdp_container">
                            <div id="gallery_pdp">
                                <?php $__currentLoopData = $gallery; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <a href="#" data-image="<?php echo e(asset($image)); ?>" data-zoom-image="<?php echo e(asset($image)); ?>">
                                    <img id="" src="<?php echo e(asset($image)); ?>" />
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                               
                            </div>
                            <!-- Up and down button for vertical carousel -->
                            <a href="#" id="ui-carousel-next" style="display: inline;"></a>
                            <a href="#" id="ui-carousel-prev" style="display: inline;"></a>
                        </div>
                       
                    </div>
                    <div class="gallery-viewer">
                        <img id="zoom_10" src="<?php echo e(asset($product->image)); ?>" data-zoom-image="<?php echo e(asset($product->image)); ?>" href="<?php echo e(asset($product->image)); ?>" />
                    </div>
                    <?php else: ?>
                    <div class="gallery-viewer">
                        <img id="zoom_10" src="<?php echo e(asset($product->image)); ?>" data-zoom-image="<?php echo e(asset($product->image)); ?>" href="<?php echo e(asset($product->image)); ?>" />
                    </div>
                    <?php endif; ?>



                </div>
                <div class="col-md-7 col-lg-6">
                    <div class="product-info">
                        <h1 class="product-title"><?php echo e($product->name); ?></h1>
                        <?php if(!empty($type)): ?>
                        
                      <div class="product-type">
                        Hãng sản xuất:  <span>
                            <?php echo e($type->name); ?>

                        </span>
                      </div>
                    <?php else: ?>
                   
                    <?php endif; ?>
                        <p class="product-code">TSN cung cấp linh kiện cơ khí chất lượng cao, giá rẻ được sản xuất tại Đài Loan.</p>
                        <?php echo $__env->make($templatePath .'.product.product-summary', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                       
                     
                        <div class="product-share__icon">
                            <p><img src="img/share.png" alt="" /> Chia sẻ bài đăng:</p>
                            <div class="box-share">
                               

                                <a href="#" class="btn-social">
                                    <img src="<?php echo e(asset('img/call-ic.png')); ?>" />
                                </a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo e(url()->current()); ?>&amp;t=<?php echo e($product->name); ?>" class="btn-social">
                                    <img src="<?php echo e(asset('img/facebook-ic.png')); ?>" />
                                </a>
                                <a href="#" class="btn-social">
                                    <img src="<?php echo e(asset('img/zalo-ic.png')); ?>" />
                                </a>
                                <a href="#" class="btn-social">
                                    <img src="<?php echo e(asset('img/wechat-ic.png')); ?>" />
                                </a>
                                <a href="http://twitter.com/share?text=text goes here&url=<?php echo e(url()->current()); ?>" class="btn-social">
                                    <img src="<?php echo e(asset('img/twitter-ic.png')); ?>" />
                                </a>
                                <a href="https://www.instagram.com/?url=<?php echo e(url()->current()); ?>" class="btn-social">
                                    <img src="<?php echo e(asset('img/pinterest-ic.png')); ?>" />
                                </a>
                                <a href="#" class="btn-social">
                                    <img src="<?php echo e(asset('img/share-more.png')); ?>" />
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


       

        <div class="product-tabs mt-5">
            <div class="container">
                <div class="scroll-mb">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                      <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="detail-tab" data-bs-toggle="tab" data-bs-target="#detail" type="button" role="tab" aria-controls="detail" aria-selected="true">mô tả sản phẩm</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="comment-tab" data-bs-toggle="tab" data-bs-target="#comment" type="button" role="tab" aria-controls="comment" aria-selected="false">đánh giá</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="policy-tab" data-bs-toggle="tab" data-bs-target="#policy" type="button" role="tab" aria-controls="policy" aria-selected="false">chính sách mua hàng</button>
                      </li>
                      <li class="nav-item" role="presentation">
                        <button class="nav-link" id="question-tab" data-bs-toggle="tab" data-bs-target="#question" type="button" role="tab" aria-controls="question" aria-selected="false">Câu hỏi thường gặp</button>
                      </li>
                    </ul>
                </div>
                <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="detail" role="tabpanel" aria-labelledby="detail-tab">
                    <div class="product-detail_description">

                        <?php echo htmlspecialchars_decode($product->content); ?>

                    </div>
                </div>
                <div class="tab-pane fade" id="comment" role="tabpanel" aria-labelledby="comment-tab">
                    <div class="product-detail_description">
                        <div class="fb-comments" data-href="<?php echo e(url()->current()); ?>" data-width="100%" data-numposts="1"></div>
                        <?php echo $__env->make($templatePath .'.product.product_review', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </div>
                <div class="tab-pane fade" id="policy" role="tabpanel" aria-labelledby="policy-tab">
                    <div class="product-detail_description">
                        <?php
                            $page_buy = \App\Page::find(13);
                        ?>
                        <?php if($page_buy): ?>
                            <?php echo htmlspecialchars_decode($page_buy->content); ?>

                        <?php endif; ?>
                    </div>
                  </div>
                  <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
                    <div class="product-detail_description">
                        <?php echo htmlspecialchars_decode($product->body); ?>

                    </div>
                  </div>
                </div>
            </div>
        </div>
        
        
    </section>
    <!-- Product Detail Section End -->

    <!-- Product Related Section Begin -->
    <section class="product-related-section py-5">
        <div class="container">
            <div class="section-title">
                <h3>Sản phẩm liên quan</h3>
            </div>
            <div class="product-related">
                <?php $__currentLoopData = $related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $items): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $product): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php echo $__env->make($templatePath .'.product.product-item', compact('product'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               
            </div>
        </div>
    </section>
    <!-- Product Related Section End -->
</main>
   

<?php $__env->stopSection(); ?>


<?php $__env->startPush('head-style'); ?>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('after-footer'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(function() {
            $(document).on('change', '.product-form__item_color input', function(event) {
                event.preventDefault();
                /* Act on the event */
                var attr_id = $(this).data('id'),
                    product = <?php echo e($product->id); ?>;
                axios({
                    method: 'post',
                    url: '<?php echo e(route('ajax.attr.change')); ?>',
                    data: {attr_id:attr_id, product:product, type:$(this).data('type')}
                }).then(res => {
                    if(res.data.error == 0){
                        if(res.data.attr_stock==0)
                            $('.product-form__cart-add').addClass('disabled');
                        $('.product-single-variations').html(res.data.view);
                    }
                }).catch(e => console.log(e));
            });

            $(document).on('change', '.available-item input', function(event) {
                event.preventDefault();

                var attr_id_change = $(this).data('id'),
                    attr_id_change_parent = $(this).data('parent');
                console.log(attr_id_change);
                $('#product_form_addCart').find('input[name="attr_id"]').attr('name', 'attr_id['+ attr_id_change_parent +']').val(attr_id_change);

                var form = document.getElementById('product_form_addCart');
                var formData = new FormData(form);

                axios({
                    method: 'post',
                    url: '<?php echo e(route('ajax.attr.change')); ?>',
                    data: formData
                }).then(res => {
                    if(res.data.error == 0){
                        $('.product-single-variations').html(res.data.view);
                        if(res.data.show_price != '')
                            $('.product-single__price').html(res.data.show_price);
                    }
                }).catch(e => console.log(e));
            });
            $(".write_comment").click(function() {
                $('html,body').animate({
                        scrollTop: $(".rate_thongke").offset().top},
                    'slow');
            });
        });
    </script>

<?php $__env->stopPush(); ?>
<?php echo $__env->make($templatePath .'.layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product-single.blade.php ENDPATH**/ ?>