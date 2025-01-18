<?php
   $url = route('news.single', ['id' => $post->id, 'slug' => $post->slug]);
   $date = \Carbon\Carbon::parse($post->created_at);
?>

<div class="item">
   <div class="thumb">
      <a href="<?php echo e($url); ?>">
         <img src="<?php echo e(asset($post->image)); ?>" onerror="this.src='<?php echo e(asset('assets/images/placeholder.png')); ?>';" alt="">
      </a>
   </div>
   <div class="content-wrapper">
      <p><i class="fa-regular fa-clock"></i> Ngày <?php echo e($date->day); ?>/<?php echo e($date->month); ?>/<?php echo e($date->year); ?></p>
      <h4><a href="<?php echo e($url); ?>"><?php echo e($post->name); ?></a></h4>
   </div>
</div><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/news/includes/post-item.blade.php ENDPATH**/ ?>