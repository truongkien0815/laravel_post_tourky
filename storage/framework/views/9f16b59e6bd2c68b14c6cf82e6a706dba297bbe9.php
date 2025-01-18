<?php extract($data); 

$question = \App\Question::orderBy('created_at','desc')->get();
 $category_lh = \App\Model\Category::where('slug', 'lien-he')->first();
   
   $posts_lien_he = $category_lh->post()->first();

?>



<?php $__env->startSection('seo'); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    


    <div class="qoute-section">
        <div class="container">
            <div class="row align-items-center g-3">
                <div class="col-md-6">
                    <div class="content-qoute">
                        <h5><?php echo e($posts_lien_he->name); ?></h5>
                  
                        <p> <?php echo htmlspecialchars_decode($posts_lien_he->content); ?>      </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-qoute">
                      <?php if(Session::has('message')): ?>
                      <p class="recruitment-success text-white"><?php echo e(Session::get('message')); ?></p>
                  <?php endif; ?>
                        <form action="contact/recruitment" method="post">
                          <?php echo csrf_field(); ?>
                            <div class="row g-3">
                                <div class="col-md-6 form-group">
                                    <input type="text" required name="fullname" class="form-control" placeholder="Họ tên" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="tel" required name="mobile" class="form-control" placeholder="Số điện thoại" />
                                </div>
                                <div class="col-md-6 form-group">
                                    <input type="email" required name="address" class="form-control" placeholder="Email">
                                </div>
                                <div class="col-md-6 form-group">
                                    <div class="select-wrap">
                                        <span class="icon icon-arrow_drop_down"></span>
                                        <select name="question" id="question" class="form-control">
                                          <option value="Chọn câu hỏi" selected="">Chọn câu hỏi</option>
                                          <?php $__currentLoopData = $question; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $itam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($itam->question_list); ?>"><?php echo e($itam->question_list); ?></option>
                                           
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 form-group">
                                    <textarea class="form-control" required name="content" placeholder="Mô tả" rows="1"></textarea>
                                </div>
                                <div class="col-12 form-group">
                                    <button class="btn btn-send" type="submit">GỬI</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
  </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make($templatePath.'.layouts.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/page/contact.blade.php ENDPATH**/ ?>