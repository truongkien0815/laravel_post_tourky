<?php

use Illuminate\Support\Facades\Route;
use App\http\Controllers\ContactController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */
Route::get('/lang/{lang}', 'LangController@index')->name('lang.index');

 Route::post('/sendEmail', 'AboutController@send_mail')->name('send');
 Route::resource('admin/question', 'QuestionController');


Route::resource('admin/contact', 'ContactController');
Route::get('/addcontact', 'ContactController@addcontact');
Route::post('/addcontactnew', 'ContactController@story');
Route::get('clear-cache', function() {
     Artisan::call('config:cache');
     Artisan::call('cache:clear');
     Artisan::call('route:clear');
     Artisan::call('view:clear');
    return 'DONE'; //Return anything
});

Route::localized(function () {

    //Route plugin
    Route::group(
        [
            'prefix'    => '/plugin/discount',
            'namespace' => '\App\Plugins\Total\Discount\Controllers',
        ],
        function () {
            Route::post('/discount_process', 'FrontController@useDiscount')
                ->name('discount.process');
            Route::post('/discount_remove', 'FrontController@removeDiscount')
                ->name('discount.remove');
        }
    );

    Route::get('/', '\App\Http\Controllers\PageController@index')->name('index');

    Route::group(['prefix' => 'customer'], function() {
        Route::get('/register', 'CustomerController@registerCustomer')->name('user.register');
        Route::post('/register', 'CustomerController@createCustomer')->name('postRegisterCustomer');
        Route::get('/register-success', 'CustomerController@createCustomerSuccess')->name('user.register.success');
        Route::get('/login', 'CustomerController@showLoginForm')->name('user.login');
        Route::post('/login', 'CustomerController@postLogin')->name('loginCustomerAction');
        Route::post('/logout', 'Customer\CustomerLoginController@logout')->name('CustomerLogout');

        Route::post('/nap-tai-khoan', 'PaymentController@checkout')->name('customer.vnpay');
    });

    //user forget password
    Route::group(['prefix' => 'forget'], function () {
        Route::get('password', 'Auth\ForgotPasswordController@forget')->name('forgetPassword');
        Route::post('password', 'Auth\ForgotPasswordController@actionForgetPassword')->name('actionForgetPassword');

        Route::get('password-step-2', 'Auth\ForgotPasswordController@forgetPassword_step2')->name('forgetPassword_step2');
        Route::post('password-step-2', 'Auth\ForgotPasswordController@actionForgetPassword_step2')->name('actionForgetPassword_step2');

        Route::get('password-step-3', 'Auth\ForgotPasswordController@forgetPassword_step3')->name('forgetPassword_step3');
        Route::post('password-step-3', 'Auth\ForgotPasswordController@actionForgetPassword_step3')->name('actionForgetPassword_step3');
    });

    /*//user forget password
    Route::get('forget-password', 'CustomerController@forgetPassword')->name('forgetPassword');
    Route::post('forget-password', 'CustomerController@actionForgetPassword')->name('actionForgetPassword');
    Route::get('forget-password-step-2', 'CustomerController@forgetPassword_step2')->name('forgetPassword_step2');
    Route::post('forget-password-step-2', 'CustomerController@actionForgetPassword_step2')->name('actionForgetPassword_step2');
    Route::get('forget-password-step-3', 'CustomerController@forgetPassword_step3')->name('forgetPassword_step3');
    Route::post('forget-password-step-3', 'CustomerController@actionForgetPassword_step3')->name('actionForgetPassword_step3');*/

    Route::group(['middleware' => 'auth'], function () {
        Route::group(['prefix' => 'customer'], function() {
            Route::get('/', 'CustomerController@index')->name('customer.dashboard');
            Route::get('/thong-tin', array('as' => 'customer.profile', 'uses' => 'CustomerController@profile'));
            Route::post('/thong-tin', array('as' => 'customer.updateprofile', 'uses' => 'CustomerController@updateProfile'));

            Route::get('/quan-ly-tin-dang', array('as' => 'customer.post', 'uses' => 'CustomerController@myPost'));
            Route::get('/refused', array('as' => 'customer.refused', 'uses' => 'CustomerController@refused'));

            Route::get('/payment-point', 'PaymentController@paymentPoint')->name('customer.payment.point');


            Route::get('/my-orders', 'CustomerController@myOrder')->name('customer.my-orders');
            Route::get('/my-orders-detail/{id}', 'CustomerController@myOrderDetail')->name('customer.order_detail');
            Route::get('/my-reviews', 'CustomerController@myReviews')->name('customer.reviews');

            Route::get('/change-pass', 'CustomerController@changePassword')->name('customer.changePassword');
            Route::post('/change-pass', 'CustomerController@postChangePassword')->name('customer.post.ChangePassword');
            Route::post('/post-reviews', 'CustomerController@postReviews')->name('customer.post_reviews');
            Route::get('/logout', 'CustomerController@logoutCustomer')->name('customer.logout');
        });
    });

    Route::group(['prefix' => 'cart'], function() {
        Route::get('/', 'CartController@cart')->name('cart');
        Route::get('/remove', 'CartController@removeCarts')->name('carts.remove');
        Route::post('/update', 'CartController@updateCarts')->name('carts.update');
        
        Route::get('/checkout', 'CartController@checkout')->name('cart.checkout');
        Route::get('/checkout-confirm', 'CartController@checkoutConfirm')->name('cart.checkout.get.confirm');
        Route::post('/checkout-confirm', 'CartController@checkoutConfirm')->name('cart.checkout.confirm');

        Route::get('/quick-buy-checkout-confirm', 'CartController@quickBuyConfirm')->name('quick_buy.get.confirm');
        Route::post('/quick-buy-checkout-confirm', 'CartController@quickBuyConfirm')->name('quick_buy.checkout.confirm');

        Route::get('/check-payment/{cart_id}', 'CartController@checkPayment')->name('cart.check_payment');

        Route::post('ajax/add', 'CartController@addCart')->name('cart.ajax.add');
        Route::post('ajax/remove', 'CartController@removeCart')->name('cart.ajax.remove');

        Route::post('ajax/get-shipping-cost', 'CartController@shipping')->name('cart.ajax.shipping');

        Route::get('checkout/success', 'CartController@orderSuccessProcessFront')->name('order.success');
        Route::get('view/{id}', 'CartController@view')->name('cart.view');

        Route::post('shipping-usps', 'USPSController@index')->name('cart.usps');
        Route::post('shipping-cost', 'USPSController@shippingCost')->name('cart.usps.cost');

    });

    Route::middleware(['blockIP'])->group(function () {
        Route::get('payment/return-ipn', '\App\Plugins\Payment\Vnpay\Controllers\FrontController@processIpn');
    });
    Route::get('payment/vnpay-process', '\App\Plugins\Payment\Vnpay\Controllers\FrontController@processResponse')->name('vnpay.process');

    Route::get('/payment-return', 'PaymentController@payment_return')->name('payment.return');
    // Route::post('/payment-type', 'PaymentController@paymentType')->name('payment.type');
    Route::get('/payment-success', 'PaymentController@paymentSuccess')->name('payment.success');
    Route::get('/payment-type', 'PaymentController@paymentType')->name('payment.type');

    // Route::get('payment', 'PayPalTestController@index');
    Route::post('checkout-process', 'CartController@processCheckout')->name('cart_checkout.process');
    Route::post('checkout-charge', 'PayPalTestController@charge')->name('cart.checkout.charge');
    Route::get('payment-success/{id?}', 'PayPalTestController@paymentStrip_success');
    Route::get('paymentsuccess', 'PayPalTestController@payment_success');
    Route::get('paymenterror', 'PayPalTestController@payment_error');
    //request payment
    Route::get('request-payment-success/{id}', 'CartController@requestPaymentSuccess')->name('request_payment_success');
    Route::post('send-request-payment-success', 'CartController@post_requestPaymentSuccess')->name('request_payment_success.post');

    // GHN
    Route::group(['prefix' => 'ghn'], function() {
        Route::get('/test', 'GHNController@index');
        Route::post('/shipping-fee', 'GHNController@shippingFee')->name('ghn.shipping_fee');
        Route::post('/shipping-fee-review', 'GHNController@shippingFeeReview')->name('ghn.shipping_fee_review');
        Route::get('/shipping-fee-review/{id}', 'GHNController@shippingFeeReviewOrder')->name('ghn.shipping_fee_review_order');
        Route::post('/shipping-fee-create-order', 'GHNController@createOrder')->name('ghn.create_order');
        Route::post('/webhook', 'GHNController@webhook')->name('ghn.webhook');
    });

    // Route::get('/contact-submit', array('as' => 'contact.submit', 'uses' => 'CustomerController@contactSend'));

    Route::post('/dang-ky-nhan-tin', array('as' => 'subscription', 'uses' => 'CustomerController@subscription'));


    Route::get('/wishlist', array('as' => 'customer.wishlist', 'uses' => 'CustomerController@wishlist'));
    Route::post('add-to-wishlist', 'ProductController@wishlist')->name('product.wishlist');

    Route::get('tin-tuc', 'NewsController@index')->name('news');
    Route::get('blog-left-sidebar.html', 'NewsController@index')->name('news');

    //category
    Route::get('sale', 'ProductController@allProducts')->name('shop.sale');
    Route::get('san-pham', 'ProductController@allProducts')->name('shop');
    Route::get('{slug}.html', 'ProductController@categoryDetail')->name('shop.detail');
    Route::post('quick-view', 'ProductController@quickView')->name('shop.quickView');
    Route::get('buy-now/{id}', 'ProductController@buyNow')->name('shop.buyNow');
    Route::post('buy-now', 'ProductController@getBuyNow')->name('shop.buyNow.post');
    Route::get('level/{slug}', 'ProductController@level')->name('shop.level');
    Route::get('cap/{slug}', 'ProductController@cap')->name('shop.cap');

    //news
    Route::get('news/{slug}.html', '\App\Http\Controllers\NewsController@categoryDetail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+'])
        ->name('news.single');
    /*Route::get('news/{slug}-{id}.html', '\App\Http\Controllers\NewsController@newsDetail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+', 'id' => '[0-9]+'])
        ->name('news.single');*/

    //document
    Route::get('/tai-nguyen', 'DocumentController@index')->name('document.index');
    Route::get('/tai-nguyen/{slug}', 'DocumentController@category')->name('document.detail');

    
    Route::post('contactv', 'ContactController@send_mail');

    Route::post('contact/recruitment', 'ContactController@recruitmentPost')->name('contact_recruitment');
    //contact
    Route::post('/get-contact-form/{type}', array('as' => 'contact.get', 'uses' => 'ContactController@getContact'));
    // Route::get('contact.html', 'ContactController@index')->name('contact');
    Route::post('contact', 'ContactController@submit')->name('contact.submit');
    Route::post('ajax/contact', 'ContactController@sendContact')->name('contact.send');

    //search
    Route::post('/input/search-text/{type}', 'AjaxController@inputSearchText');

    Route::get('/search', 'SearchController@index')->name('search');
    Route::post('search-select', 'AjaxController@searchSelect');

    //get-distric
    Route::post('search-select', 'AjaxController@searchSelect');

    //page
    Route::group(['prefix' => 'location'], function() {
        Route::post('district', 'LocationController@getDistrict')->name('location.district');
        Route::post('ward', 'LocationController@getWard')->name('location.ward');
    });



    //project
    Route::get('du-an/{slug}-{id}.html', '\App\Http\Controllers\ProjectController@detail')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+', 'id' => '[0-9]+'])
        ->name('project.detail');

    Route::get('du-an/{slug}.html', '\App\Http\Controllers\ProjectController@category')
        ->where(['slug' => '[a-zA-Z0-9$-_.+!]+'])
        ->name('project.category');
    //end project

    Route::group(['prefix' => 'ajax'], function() {
        Route::post('change-attr', 'ProductController@changeAttr')->name('ajax.attr.change');
        Route::post('change-attr-color', 'ProductController@changeAttrColor')->name('ajax.attr.change_color');

        Route::post('product-ajax-filter', 'ProductController@ajaxFilter')->name('ajax.product_filter');
        Route::post('search', 'SearchController@ajaxSearch')->name('ajax.search');
    });

    //page
    Route::get('{slug}', 'PageController@page')->name('page');

    Route::group(
        [
            'prefix'    => 'plugin/product_review',
            'namespace' => '\App\Plugins\Cms\ProductReview\Controllers',
        ],
        function () {
            Route::post('post-review', 'FrontController@postReview')
                ->name('product_review.postReview');
            Route::post('remove-review', 'FrontController@removeReview')
                ->name('product_review.removeReview');
        }
    );
});
