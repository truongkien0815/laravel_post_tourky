<?php

// Route xử lý cho admin
Route::namespace('Admin')->group(function () {
    Route::get('/login', 'LoginController@showLoginForm');
    Route::post('/login', 'LoginController@login')->name('admin.login');
    Route::get('/logout', 'LoginController@logout')->name('admin.logout');
    Route::get('/404', 'AdminController@error')->name('adminError');

    Route::get('deny', 'DashboardController@deny')->name('admin.deny');
    Route::get('data_not_found', 'DashboardController@dataNotFound')->name('admin.data_not_found');
    Route::get('deny_single', 'DashboardController@denySingle')->name('admin.deny_single');

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/', 'HomeController@index')->name('admin.dashboard');
        //các route của quản trị viên sẽ được viết trong group này, còn chức năng của user sẽ viết ngoài route
        Route::group(['middleware' => 'checkAdminPermission'], function () {
            //Setting
            Route::get('/theme-option', 'AdminController@getThemeOption')->name('admin.themeOption');
            Route::post('/theme-option', 'AdminController@postThemeOption')->name('admin.postThemeOption');
            Route::get('/menu', 'AdminController@getMenu')->name('admin.menu');

            Route::group( ['prefix' => 'payment'], function(){
                Route::get('history', 'ViewTipController@paymentHistory')->name('admin_tip.history');
                Route::get('history/{id}', 'ViewTipController@paymentHistoryDetail')->name('admin_tip.history_detail');
                Route::post('update', 'ViewTipController@historyUpdate')->name('admin_tip.history_update');
                Route::get('payment-view-tip', 'ViewTipController@viewTipHistory')->name('admin_tip.payment_history');
            });
            Route::group( ['prefix' => 'vnpay'], function(){
                Route::get('logs', 'VNPayController@logs')->name('admin_vnpay.logs');
            });

            Route::group( ['prefix' => 'shipping'], function(){
                Route::get('/', 'ShippingController@index')->name('admin.shipping');
                Route::get('edit/{id}', 'ShippingController@edit')->name('admin.shipping_edit');
                Route::get('create', 'ShippingController@create')->name('admin.shipping_create');
                Route::post('/', 'ShippingController@post')->name('admin.shipping_post');
                Route::get('delete/{id}', 'ShippingController@delete')->name('admin.shipping_delete');
            });

            //client
            Route::group(['prefix' => 'document'], function () {
                Route::get('/', 'DocumentController@index')->name('admin.document');
                Route::get('edit/{id}', 'DocumentController@edit')->name('admin.document_edit');
                Route::get('add', 'DocumentController@create')->name('admin.document_create');
                Route::post('post', 'DocumentController@post')->name('admin.document_post');
                Route::get('approve', 'DocumentController@approve')->name('admin.document_approve');
            });
            //client category
            Route::group(['prefix' => 'document-category'], function () {
                Route::get('/', 'DocumentCategoryController@index')->name('admin_document_category');
                Route::get('edit/{id}', 'DocumentCategoryController@edit')->name('admin_document_category.edit');
                Route::get('add', 'DocumentCategoryController@create')->name('admin_document_category.create');
                Route::post('post', 'DocumentCategoryController@post')->name('admin_document_category.post');
            });

            //Block
            Route::group( ['prefix' => 'block'], function(){
                Route::get('/', 'BlockController@index')->name('admin_block');
                Route::get('create', 'BlockController@create')->name('admin_block.create');
                Route::get('edit/{id}', 'BlockController@edit')->name('admin_block.edit');
                Route::post('post', 'BlockController@store')->name('admin_block.post');
            });

            //chi so tra cuu
            Route::group( ['prefix' => 'chi-so-tra-cuu'], function(){
                Route::get('/', 'ChiSoTraCuuController@index')->name('admin_chiso');
                Route::get('create', 'ChiSoTraCuuController@create')->name('admin_chiso.create');
                Route::get('/edit/{id}', 'ChiSoTraCuuController@edit')->name('admin_chiso.edit');
                Route::post('post', 'ChiSoTraCuuController@store')->name('admin_chiso.post');
            });
            //Tra cuu danh muc
            Route::group( ['prefix' => 'danh-muc-chi-so-tra-cuu'], function(){
                Route::get('/', 'ChiSoCategoryController@index')->name('admin_chiso_category');
                Route::get('create', 'ChiSoCategoryController@create')->name('admin_chiso_category.create');
                Route::get('/edit/{id}', 'ChiSoCategoryController@edit')->name('admin_chiso_category.edit');
                Route::post('post', 'ChiSoCategoryController@store')->name('admin_chiso_category.post');
            });

            //lich su tra cuu
            Route::group( ['prefix' => 'lich-su-tra-cuu'], function(){
                Route::get('/', 'TraCuuController@history')->name('admin_tracuu.history');
                Route::get('/{id}', 'TraCuuController@historyView')->name('admin_tracuu.historyView');
                Route::get('/download-full/{id}', '\App\Http\Controllers\TraCuuController@adminDownloadFull')->name('admin_tracuu.adminDownloadFull');
            });

            //Page
            Route::group( ['prefix' => 'page'], function(){
                Route::get('/list', 'PageController@listPage')->name('admin.pages');
                Route::get('create', 'PageController@createPage')->name('admin.createPage');
                Route::get('/edit/{id}', 'PageController@pageDetail')->name('admin.pageDetail');
                Route::post('post', 'PageController@postPageDetail')->name('admin.postPageDetail');
            });

            //Post
            Route::group( ['prefix' => 'post'], function(){
                Route::get('/list', 'PostController@listPost')->name('admin.posts');
                Route::get('search-post', 'PostController@searchPost')->name('admin.searchPost');
                Route::get('create', 'PostController@createPost')->name('admin.createPost');
                Route::get('edit/{id}', 'PostController@postDetail')->name('admin.postDetail');
                Route::post('/post', 'PostController@postPostDetail')->name('admin.postPostDetail');
            });

            //Category Post
            Route::group( ['prefix' => 'category-post'], function(){
                Route::get('/list', 'CategoryController@listCategoryPost')->name('admin.listCategoryPost');
                Route::get('create', 'CategoryController@createCategoryPost')->name('admin.createCategoryPost');
                Route::get('{id}', 'CategoryController@categoryPostDetail')->name('admin.categoryPostDetail');
                Route::post('/post', 'CategoryController@postCategoryPostDetail')->name('admin.postCategoryPostDetail');
            });

            /*service*/
            Route::group( ['prefix' => 'service'], function(){
                Route::get('/list', 'ServiceController@index')->name('admin_service');
                Route::get('create', 'ServiceController@create')->name('admin_service.create');
                Route::get('edit/{id}', 'ServiceController@edit')->name('admin_service.edit');
                Route::post('/post', 'ServiceController@store')->name('admin_service.post');
            });

            /*service category*/
            Route::group( ['prefix' => 'service-category'], function(){
                Route::get('list', 'ServiceCategoryController@index')->name('admin_service_category');
                Route::get('create', 'ServiceCategoryController@create')->name('admin_service_category.create');
                Route::get('edit/{id}', 'ServiceCategoryController@edit')->name('admin_service_category.edit');
                Route::post('post', 'ServiceCategoryController@store')->name('admin_service_category.post');
            });

            //Slider Home
            Route::group(['prefix' => 'slider'], function () {
                Route::get('/', 'SliderController@listSlider')->name('admin.slider');
                Route::get('create', 'SliderController@createSlider')->name('admin.createSlider');
                Route::get('{id}', 'SliderController@sliderDetail')->name('admin.sliderDetail');
                Route::post('post', 'SliderController@postSliderDetail')->name('admin.postSliderDetail');
                Route::post('insert', 'SliderController@insertSlider')->name('admin.slider.insert');
                Route::post('edit', 'SliderController@editSlider')->name('admin.slider.insert');
                Route::post('delete', 'SliderController@deleteSlider')->name('admin.slider.delete');

                Route::post('sort', 'SliderController@updateSort')->name('admin.slider.sort');
            });


            //xử lý users admin
            Route::group( ['prefix' => 'user-admin'], function(){
                Route::get('/', 'UserAdminController@index')->name('admin.listUserAdmin');
                Route::get('edit/{id}', 'UserAdminController@edit')->name('admin.userAdminDetail');
                Route::post('post', 'UserAdminController@post')->name('admin.postUserAdmin');
                Route::get('add', 'UserAdminController@create')->name('admin.addUserAdmin');
                Route::get('/delete/{id}', 'UserAdminController@deleteUserAdmin')->name('admin.delUserAdmin');
            });

            Route::group( ['prefix' => 'permission'], function(){
                Route::get('/', 'Auth\PermissionController@index')->name('admin_permission.index');
                Route::get('create', 'Auth\PermissionController@create')->name('admin_permission.create');
                Route::get('/edit/{id}', 'Auth\PermissionController@edit')->name('admin_permission.edit');
                Route::post('/post', 'Auth\PermissionController@post')->name('admin_permission.post');
                Route::get('/delete/{id}', 'Auth\PermissionController@delete')->name('admin_permission.delete');
            });
            Route::group(['prefix' => 'role'], function () {
                Route::get('/', 'Auth\RoleController@index')->name('admin_role.index');
                Route::get('create', 'Auth\RoleController@create')->name('admin_role.create');
                Route::get('/edit/{id}', 'Auth\RoleController@edit')->name('admin_role.edit');
                Route::post('/post', 'Auth\RoleController@post')->name('admin_role.post');
                Route::get('/delete/{id}', 'Auth\RoleController@delete')->name('admin_role.delete');
            });

            //xử lý users
            Route::group(['prefix' => 'user'], function () {
                Route::get('/', 'UserController@index')->name('admin_user');
                Route::get('edit/{id}', 'UserController@userDetail')->name('admin_user.edit');
                Route::get('add', 'UserController@create')->name('admin_user.create');
                Route::post('post', 'UserController@post')->name('admin_user.post');
                Route::get('delete/{id}', 'UserController@deleteUser')->name('admin_user.delete');
                Route::get('export', 'UserController@exportCustomer')->name('admin_user.export');
            });

            Route::group(['prefix' => 'bao-cao'], function () {
                Route::get('/', 'BaocaoController@index')->name('admin.baocao');
                Route::post('/export', 'BaocaoController@export')->name('admin.baocao_export');
            });
            Route::get('payment-history', 'PaymentController@paymentHistory')->name('admin.payment_history');
            Route::get('credit-spent', 'PaymentController@creditSpent')->name('admin.credit_spent');

            //export excel
            Route::group(['prefix' => 'export'], function () {
                Route::get('/customer', array('as' => 'admin.exportCustomer', 'uses' => 'AdminController@exportCustomer'));
                Route::get('/orders', array('as' => 'admin.exportOrders', 'uses' => 'AdminController@exportOrder'));
                Route::get('/products', array('as' => 'admin.exportProducts', 'uses' => 'AdminController@exportProduct'));
            });

            //package
            Route::group(['prefix' => 'package'], function () {
                Route::get('list', 'PackageController@index')->name('admin.package.index');
                Route::get('create', 'PackageController@create')->name('admin.package.create');
                Route::get('{id}', 'PackageController@edit')->name('admin.package.edit');
                Route::post('post', 'PackageController@post')->name('admin.package.post');
                Route::post('show-home', 'PackageController@showHome')->name('admin.package.show_home');
                Route::post('priority', 'PackageController@priority')->name('admin.package.priority');
            });

            //Category Product
            Route::group(['prefix' => 'product-category'], function () {
                Route::get('list', 'ProductCategoryController@index')->name('admin.listCategoryProduct');
                Route::get('create', 'ProductCategoryController@create')->name('admin.product.category.create');
                Route::get('{id}', 'ProductCategoryController@edit')->name('admin.categoryProductDetail');
                Route::post('post', 'ProductCategoryController@post')->name('admin.postCategoryProductDetail');
                Route::get('checklist/{id}', 'ProductCategoryController@getCategoryCheckList');
            });
            Route::get('/category-checklist/{id}', 'ProductCategoryController@getCategoryCheckList');

            //email template
            Route::group(['prefix' => 'subscription'], function () {
                Route::get('/', 'SubscriptionController@index')->name('admin_subscription');
                Route::get('edit/{id}', 'SubscriptionController@edit')->name('admin_subscription.edit');
                Route::get('add', 'SubscriptionController@create')->name('admin_subscription.create');
                Route::post('post', 'SubscriptionController@post')->name('admin_subscription.post');
            });
            //email template
            Route::group(['prefix' => 'email-template'], function () {
                Route::get('/', 'EmailTemplateController@index')->name('admin.email_template');
                Route::get('edit/{id}', 'EmailTemplateController@edit')->name('admin.email_template.edit');
                Route::get('add', 'EmailTemplateController@create')->name('admin.email_template.create');
                Route::post('post', 'EmailTemplateController@post')->name('admin.email_template.post');
            });

            //change password
            Route::group(['prefix' => 'change-password'], function () {
                Route::get('/', 'AdminController@changePassword')->name('admin.changePassword');
                Route::post('/', 'AdminController@postChangePassword')->name('admin.postChangePassword');
            });

            Route::get('/check-password', 'AjaxController@checkPassword')->name('admin.checkPassword');

            //ajax delete
            Route::post('/delete-id', 'AjaxController@ajax_delete')->name('admin.ajax_delete');

            //ajax process
            Route::group(['prefix' => 'ajax'], function () {
                Route::post('process_theme_fast', 'AjaxController@processThemeFast')->name('admin.ajax.processThemeFast');
                Route::post('process_new_item', 'AjaxController@update_new_item_status')->name('admin.ajax.process_new_item');
                Route::post('process_flash_sale', 'AjaxController@update_process_flash_sale')->name('admin.ajax.process_flash_sale');
                Route::post('process_sale_top_week', 'AjaxController@update_process_sale_top_week')->name('admin.ajax.process_sale_top_week');
                Route::post('process_propose', 'AjaxController@update_process_propose')->name('admin.ajax.process_propose');
                Route::post('process_store_status', 'AjaxController@updateStoreStatus')->name('admin.ajax.process_store_status');
                Route::post('load_variable', 'AjaxController@loadVariable')->name('admin.ajax.load_variable');
            });

            //variable
            Route::group(['prefix' => 'shop-variable'], function () {
                Route::get('/list', 'ShopVariableController@index')->name('admin_variable');
                Route::get('/create', 'ShopVariableController@create')->name('admin_variable.create');
                Route::get('/edit/{id}', 'ShopVariableController@edit')->name('admin_variable.edit');
                Route::post('/post', 'ShopVariableController@post')->name('admin_variable.post');
            });

            // review
            Route::group(['prefix' => 'review'], function () {
                Route::get('/', 'ProductReviewController@index')->name('admin_review');
                Route::get('/{id}', 'ProductReviewController@edit')->name('admin_review.edit');
                Route::post('/update-status', 'ProductReviewController@updateStatus')->name('admin_review.updateStatus');
            });
            // review

            //Product
            Route::group(['prefix' => 'product'], function () {
                Route::get('/list', 'ProductController@listProduct')->name('admin.listProduct');
                Route::get('/search', 'ProductController@searchProduct')->name('admin.searchProduct');
                Route::get('create', 'ProductController@createProduct')->name('admin.createProduct');
                Route::get('export', 'ProductController@export')->name('admin.product.export');
                Route::post('export', 'ProductController@exportPost');
                Route::get('{id}', 'ProductController@productDetail')->name('admin.productDetail');
                Route::post('post', 'ProductController@postProductDetail')->name('admin.postProductDetail');
                Route::post('update-stock', 'ProductController@updateStock')->name('admin_product.updateStock');
                Route::post('update-status', 'ProductController@updateStatus')->name('admin_product.updateStatus');
            });

            //Brand
            Route::group(['prefix' => 'brand'], function () {
                Route::get('/list', 'BrandController@index')->name('admin.brand');
                Route::get('/create', 'BrandController@create')->name('admin.brand.create');
                Route::get('/edit/{id}', 'BrandController@edit')->name('admin.brand.edit');
                Route::post('/post', 'BrandController@post')->name('admin.brand.post');
            });
            //Level
            Route::group(['prefix' => 'level'], function () {
                Route::get('/list', 'ShopLevelController@index')->name('admin_level');
                Route::get('/create', 'ShopLevelController@create')->name('admin_level.create');
                Route::get('/edit/{id}', 'ShopLevelController@edit')->name('admin_level.edit');
                Route::post('/post', 'ShopLevelController@post')->name('admin_level.post');
            });
            //Typê
            Route::group(['prefix' => 'type'], function () {
                Route::get('/list', 'ShopTypeController@index')->name('admin_type');
                Route::get('/create', 'ShopTypeController@create')->name('admin_type.create');
                Route::get('/edit/{id}', 'ShopTypeController@edit')->name('admin_type.edit');
                Route::post('/post', 'ShopTypeController@post')->name('admin_type.post');
            });
            /*Route::group(['prefix' => 'element'], function () {
                Route::get('/', 'ElementController@index')->name('admin_element.index');
                Route::get('create', 'ElementController@create')->name('admin_element.create');
                Route::get('{id}', 'ElementController@edit')->name('admin_element.edit');
                Route::post('post', 'ElementController@post')->name('admin_element.post');
            });*/
            //Orders
            Route::group(['prefix' => 'order'], function () {
                Route::get('list', 'OrderController@listOrder')->name('admin.listOrder');
                Route::get('search', 'OrderController@searchOrder')->name('admin.searchOrder');
                Route::get('edit/{id}', 'OrderController@orderDetail')->name('admin.orderDetail');
                Route::post('/post', 'OrderController@postOrderDetail')->name('admin.postOrderDetail');
                Route::post('/update', 'OrderController@update')->name('admin_order.update');
            });
            Route::get('/product_import', array('as' => 'admin_product.import', 'uses' => 'ProductController@import'));
            Route::post('/product_import', array('as' => 'admin_product.import_process', 'uses' => 'ProductController@importProcess'));

            Route::get('media-manager/fm-button', 'FileManagerController@fmButton')
                ->name('fm.fm-button');

            Route::group(['prefix' => 'admin-menu'], function () {
                Route::get('/', 'AdminMenuController@index')->name('admin_menu.index');
                Route::post('/create', 'AdminMenuController@postCreate')->name('admin_menu.create');
                Route::get('/edit/{id}', 'AdminMenuController@edit')->name('admin_menu.edit');
                Route::post('/edit/{id}', 'AdminMenuController@postEdit')->name('admin_menu.edit');
                Route::post('/delete', 'AdminMenuController@deleteList')->name('admin_menu.delete');
                Route::post('/update_sort', 'AdminMenuController@updateSort')->name('admin_menu.update_sort');
            });

            //email template
            Route::group(['prefix' => 'email-template'], function () {
                Route::get('/', 'EmailTemplateController@index')->name('admin.email_template');
                Route::get('edit/{id}', 'EmailTemplateController@edit')->name('admin.email_template.edit');
                Route::get('add', 'EmailTemplateController@create')->name('admin.email_template.create');
                Route::post('post', 'EmailTemplateController@post')->name('admin.email_template.post');
            });
        });
    });
    //Route plugin
    Route::group(
        [
            'middleware' => 'auth:admin',
        ],
        function () {
            foreach (glob(app_path() . '/Plugins/*/*/Route.php') as $filename) {
                require_once $filename;
            }
        }
    );
});