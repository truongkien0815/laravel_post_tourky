<?php
/**
 * Route front
 */
/*Route::group(
    [
        'prefix'    => '/plugin/discount',
        'namespace' => 'App\Plugins\Total\Discount\Controllers',
    ],
    function () {
        Route::post('/discount_process', 'FrontController@useDiscount')
            ->name('discount.process');
        Route::post('/discount_remove', 'FrontController@removeDiscount')
            ->name('discount.remove');
    }
);
*/

/**
 * Route admin
 */
Route::group(
    [
        'prefix' => 'shop_discount',
        'namespace' => '\App\Plugins\Total\Discount\Admin',
    ], 
    function () {
        Route::get('/', 'AdminController@index')->name('admin_discount');
        Route::get('create', 'AdminController@create')->name('admin_discount.create');
        Route::get('/edit/{id}', 'AdminController@edit')->name('admin_discount.edit');
        Route::post('post', 'AdminController@post')->name('admin_discount.post');
        Route::post('/delete', 'AdminController@deleteList')->name('admin_discount.delete');
    }
);
