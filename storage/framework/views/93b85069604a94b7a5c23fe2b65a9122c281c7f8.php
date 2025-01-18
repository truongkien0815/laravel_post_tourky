
<?php
    $points = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getPointProduct($product->id);
    //dd($points);
    $pathPlugin = (new App\Plugins\Cms\ProductReview\AppConfig)->pathPlugin;

    $star_5 = 0;
    $star_4 = 0;
    $star_3 = 0;
    $star_2 = 0;
    $star_1 = 0;
    if($points->count()){
        $round_star = round($points->sum('point')/$points->count(), 2); //làm tròn số sao
        foreach($points as $point){
            if($point->point == 5)
                $star_5++;
            elseif($point->point == 4)
                $star_4++;
            elseif($point->point == 3)
                $star_3++;
            elseif($point->point == 2)
                $star_2++;
            elseif($point->point == 1)
                $star_1++;
        }
    }

?>
<section class="mt-3 section-sm bg-default">
    <div  id="review">
        <div class="rate_thongke mb-3 p-3">
            <div class="row">
                <div class="col-lg-6 col-5 d-flex align-items-center justify-content-center">
                    <div class="thongke_star text-center">
                        <div class="rate_diem"><?php echo e($round_star ?? 0); ?> <i class="fa fa-star"></i></div>
                        <?php if($points->count()): ?>
                            <div class="">Có <?php echo e($points->count()); ?> đánh giá</div>
                        <?php else: ?>
                            <div class="">Chưa có đánh giá</div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6 col-7">
                    <div class="thongke_star_detail text-center">
                        <ul>
                            <li>
                                <span class="tk_star">5 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width: <?php echo e($points->count() ? $star_5 * 100 / $points->count() : 0); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num"><?php echo e($star_5); ?></span>
                            </li>

                            <li>
                                <span class="tk_star">4 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  <?php echo e($points->count() ? $star_4 * 100 / $points->count() : 0); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num"><?php echo e($star_4); ?></span>
                            </li>
                            <li>
                                <span class="tk_star">3 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  <?php echo e($points->count() ? $star_3 * 100 / $points->count() : 0); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num"><?php echo e($star_3); ?></span>
                            </li>
                            <li>
                                <span class="tk_star">2 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  <?php echo e($points->count() ? $star_2 * 100 / $points->count() : 0); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num"><?php echo e($star_2); ?></span>
                            </li>
                            <li>
                                <span class="tk_star">1 <i class="fa fa-star"></i></span>
                                <div class="tk_progress">
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" style="width:  <?php echo e($points->count() ? $star_1 * 100 / $points->count() : 0); ?>%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="0"></div>
                                    </div>
                                </div>
                                <span class="tk_num"><?php echo e($star_1); ?></span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="col-lg-12">
                    <hr>
                    <div id="review-detail" class="mb-3">
                        <?php if($points->count()): ?>
                            <?php $__currentLoopData = $points; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $point): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($k < 3): ?>
                                    <div class="review-detail" >
                                        <div class="r-name">
                                            <b><?php echo e($point->name); ?></b>
                                            <div class="review-star">
                                                <?php for($i = 1;  $i <= $point->point; $i++): ?>
                                                    <i class="fa fa-star voted" aria-hidden="true"></i>
                                                <?php endfor; ?>
                                                <?php for($k = 1;  $k <= (5- $point->point); $k++): ?>
                                                    <i class="fa fa-star-o" aria-hidden="true"></i>
                                                <?php endfor; ?>
                                            </div>
                                            <?php if(auth()->user() && $point->customer_id == auth()->user()->id): ?>
                                                <span class="r-remove text-danger text-right btn"  data-id="<?php echo e($point->id); ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></span>
                                            <?php endif; ?>
                                        </div>

                                        <?php if($point->picture): ?>
                                            <?php
                                                $picture_cmt = json_decode($point->picture, true);
                                            ?>
                                            <div class="list_rate_pic">
                                                <div id="aniimated-thumbnials">
                                                    <?php $__currentLoopData = $picture_cmt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pic): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <a href="<?php echo e(asset($pic)); ?>">
                                                            <img src="<?php echo e(asset($pic)); ?>" with="65" alt=""></a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        <?php endif; ?>

                                        <div class="r-comment"><?php echo sc_html_render($point->comment); ?></div>

                                        
                                        <?php
                                            $replies = (new App\Plugins\Cms\ProductReview\Models\PluginModel)->getReply($point->id);
                                        ?>
                                        <?php if($replies->count()): ?>
                                            <span class="icon-replies-count"><i class="fa fa-comment-o" aria-hidden="true"></i> <?php echo e($replies->count()); ?> phản hồi</span>
                                            <?php $__currentLoopData = $replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <div class="box_reply">
                                                    <div class="reply_item">
                                                        <div class="list_rate_title"><span>CSKH </span> gửi vào lúc <?php echo e($reply->created_at ?? date('d/m/Y H:i', $reply->rate_date)); ?></div>
                                                        <div class="reply_content">
                                                            <?php echo sc_html_render($reply->comment); ?>

                                                        </div>
                                                    </div>
                                                </div>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php else: ?>
                            <p>Chưa có đánh giá</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="d-flex justify-content-center">
                        <div class="thongke_post_rate mr-2"><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reviewModal"><i class='bx bx-message-rounded-dots' ></i> Gửi đánh giá</button></div>
                    </div>
                </div>
            </div>
        </div>

        <?php echo $__env->make($templatePath .'.product-review.form-review', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
</section>


<?php $__env->startPush('scripts'); ?>
    <?php echo $__env->make($templatePath .'.product-review.script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <script>
        jQuery(document).ready(function($) {
            $('.icon-replies-count').click(function(){
                if($(this).hasClass('active')){
                    $(this).removeClass('active');
                    $(this).parent().find('.box_reply').hide();
                }
                else{
                    $(this).addClass('active');
                    $(this).parent().find('.box_reply').show();
                }
            });
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/product/product_review.blade.php ENDPATH**/ ?>