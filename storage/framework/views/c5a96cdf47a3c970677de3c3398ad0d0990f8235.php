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
    
   



  
   
  


//    
$sliders_thanhvien = \App\Model\Slider::where('slider_id', 42)->where('type', '=', 'desktop')->get(); 
?>


<?php /**PATH D:\laragon\www\congnghiepnew-call-api\resources\views/theme/layouts/footer.blade.php ENDPATH**/ ?>