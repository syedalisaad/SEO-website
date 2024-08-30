<?php

Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\Category\Controllers\Backend' )->group(function() {
    Route::get('category/list', 'CategoryController@ajaxManageable')->name('category.ajax.manageable');
    Route::get('category/delete/{id}', 'CategoryController@destroy')->name('category.delete');
    Route::get('categories/retrieve/{level}/{category_id}', 'CategoryController@getRetrieveCategoryById');
    Route::resource('category', 'CategoryController', ['except' => ['destroy', 'show']]);
});
