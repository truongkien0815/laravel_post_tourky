<?php

    $menu_footer = Menu::getByName('Menu-footer');
    
    $address = setting_option('address');
    $phone_sales = setting_option('phone-sales');
    $phone_support = setting_option('phone-support');
    $email = setting_option('company_email');
    $question = \App\Question::orderBy('created_at','desc')->get();
    $category = \App\ProductCategory::limit(8)->get();
$footer_company= setting_option('footer-company');
    // $settingnew= \App\Setting::all()->get();
    $category_ht = \App\Model\Category::where('slug', 'ho-tro-khach-hang')->first();
   
   $posts_ht = $category_ht->post()->get();


   $category_lh = \App\Model\Category::where('slug', 'lien-he')->first();
   
   $posts_lien_he = $category_lh->post()->first();


//    
$sliders_thanhvien = \App\Model\Slider::where('slider_id', 42)->where('type', '=', 'desktop')->get(); 
?>


<footer class="footer-section">


  <div class="top-footer">
    <div class="container">
      <h3 class="title-personnel">Chi nhánh miền Bắc</h3>
      <div class="row g-3">
        <?php $__currentLoopData = $sliders_thanhvien; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-6 col-md-4 col-lg-3">
          <div class="item-personnel">
            <div class="wrap-img">
              <img src="<?php echo e(asset($item->src)); ?>" alt="" />
            </div>
            <div class="content">
              <h3><?php echo e($item->name); ?></h3>
              <p><i><?php echo strip_tags(htmlspecialchars_decode($item->description)); ?></i></p>
              <a href="tel:<?php echo e($item->link); ?>"><?php echo e($item->link); ?></a>
            </div>
          </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       
      </div>
    </div>
  </div>


  <div class="main-footer">
      <div class="container">
          <div class="row g-3 info-footer">
              <div class="col-md-4 col-lg-5">
              
               

                <a href="/" class="logo-footer">
                    <img src="<?php echo e(asset('img/logo-white.png')); ?>" alt="" />
                </a>
                
                <h3><?php echo setting_option('company_name'); ?></h3>
                <ul>
                    <li>
                        <img src="<?php echo e(asset('img/map-pin.png')); ?>" alt="" />
                        <p> <?php echo setting_option('address'); ?></p>
                    </li>
                    <li>
                        <img src="<?php echo e(asset('img/phone.png')); ?>" alt="" />
                        <p> <?php echo setting_option('hotline'); ?></p>
                    </li>
                    <li>
                        <img src="<?php echo e(asset('img/mail.png')); ?>" alt="" />
                        <p> <?php echo setting_option('company_email'); ?> </p>
                    </li>
                    <li>
                        <img src="<?php echo e(asset('img/clock.png')); ?>" alt="" />
                        
                        <p><?php echo setting_option('time_footer'); ?> </p>
                    </li>
                </ul>

                 

                  
              </div>
              <div class="col-md-8 col-lg-7">
                  <div class="row g-3">
                      <div class="col-md-4">
                          <h3>DANH MỤC SẢN PHẨM</h3>
                          <ul>
                            <?php $__currentLoopData = $category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li>
                                  <a href="<?php echo e(url($item->slug.'.html')); ?>"><?php echo e($item->name); ?></a>
                              </li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                          </ul>
                      </div>
                      <div class="col-md-4">
                          <h3>HỖ TRỢ KHÁCH HÀNG</h3>
                          <ul>
                            <?php $__currentLoopData = $posts_ht; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li>
                                  <a href="<?php echo e(url('news/'.$item->slug .'.html?id='.$item->id)); ?>"><?php echo e($item->name); ?></a>
                              </li>
                              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            
                          </ul>
                      </div>
                      <div class="col-md-4 col-last">
                          <h3>LIÊN KẾT</h3>
                          <ul>
                              <li>
                                  <a href="<?php echo e(setting_option('facebook')); ?>">
                                      <img src="<?php echo e(asset('img/facebook.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="<?php echo e(setting_option('youtube')); ?>">
                                      <img src="<?php echo e(asset('img/youtube.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="<?php echo e(setting_option('linkedin')); ?>">
                                      <img src="<?php echo e(asset('img/linkedin.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="<?php echo e(setting_option('zalo')); ?>">
                                      <img src="<?php echo e(asset('img/zalo.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="<?php echo e(setting_option('messenger')); ?>">
                                      <img src="<?php echo e(asset('img/wechat.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="<?php echo e(setting_option('twitter')); ?>">
                                      <img src="<?php echo e(asset('img/twitter.png')); ?>" alt="" />
                                  </a>
                              </li>
                              <li>
                                  <a href="tel:<?php echo e(setting_option('hotline')); ?>">
                                      <img src="<?php echo e(asset('img/call.png')); ?>" alt="" />
                                  </a>
                              </li>
                          </ul>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <div class="copyright-footer">
      <p>© Copyright 2024 Expro Việt Nam. <a href="https://thietkewebnhanh247.com/">Công ty TNHH Giải Pháp Số</a> <a href="https://expro.vn">Expro Việt Nam</a></p>
      <p>Mã số thuế: 0108658002 cấp tại Phòng đăng ký kinh doanh Sở Kế hoạch và Đầu tư Thành phố Hồ Chí Minh</p>
  </div>
</footer><?php /**PATH D:\laragon\www\congnghiepnew\resources\views/theme/layouts/footer.blade.php ENDPATH**/ ?>