<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\PackagePrice\Controllers\Backend' )->group(function() {
    Route::get('Package-Price/ajax/list', 'PackagePriceController@ajaxManageable')->name('packageprice.ajax.manageable');
    Route::get('Package-Price/list', 'PackagePriceController@index')->name('packageprice.list');
    Route::get('/Package-Price/show/{id}', 'PackagePriceController@show')->name('packageprice.show');
    Route::get('/add-package-price/{product_stripe_id}', 'PackagePriceController@getAddPrice')->name('add.package.price');
    Route::post('/create-package-price', 'PackagePriceController@getCreatePrice')->name('create.package.price');
});
