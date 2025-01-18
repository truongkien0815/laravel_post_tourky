

<?php extract($data) ?>
<?php
    
    $banner = \App\Model\Slider::get(); 
    if(!empty($data['id_mobile']))
        $banner_mobile = \App\Model\Slider::find($data['id_mobile']); 

    	$sliders = \App\Model\Slider::where('slider_id', $id)->where('type', '=', 'desktop')->get(); 
    	$slidersdt = \App\Model\Slider::where('slider_id', $id_dt)->where('type', '=', 'desktop')->get(); 

?>




 <section class="achievement-section">
            <div class="container">
                <div class="section-title text-center d-block">
                    <div class="sub-title">chứng nhận</div>
                    <h3>Đại lý uỷ quyền từ hãng</h3>
                </div>
                <div class="achievement-slider owl-carousel">
                    <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  
                  
                    <div class="item-achievement">
                        <div class="thumb">
                            <img src="<?php echo e(asset($item->src)); ?>" alt="" />
                        </div>
                    </div>
                   
                   
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  
                </div>
            </div>
 </section>


 <section class="partner-section">
    <div class="container">
        <div class="section-title text-center d-block">
            <div class="sub-title">ĐỐI TÁC &</div>
            <h3> KHÁCH HÀNG TIÊU BIỂU</h3>
        </div>
        <div class="achievement-slider owl-carousel">
            <?php $__currentLoopData = $slidersdt; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            
            <div class="item-achievement">
                <div class="thumb">
                    <img src="<?php echo e(asset($item->src)); ?>" alt="" />
                    
                </div>
            </div>
            
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          
        </div>
    </div>
</section><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/shortcode/banner.blade.php ENDPATH**/ ?>