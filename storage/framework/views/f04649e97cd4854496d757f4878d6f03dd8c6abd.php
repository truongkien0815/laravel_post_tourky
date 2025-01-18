<?php extract($data) ?>
<?php
	$agent = new Jenssegers\Agent\Agent;
	
	$sliders = \App\Model\Slider::where('slider_id', $id)->where('type', '=', 'desktop')->orderby('order','asc')->get(); 

	
	$slider_mobiles = \App\Model\Slider::where('slider_id', $id)->where('type', 'mobile')->get(); 
?>



	<main class="main">
<section class="hero-section">
    
    <div class="hero-slider owl-carousel">
		<?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
		
        <div class="div img_banner"><img src="<?php echo e(asset($slider->src)); ?>" alt=""></div>
        
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/shortcode/slider.blade.php ENDPATH**/ ?>