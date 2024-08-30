<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\Blog\Controllers\Backend' )->group(function() {
    Route::get('blog/list', 'BlogController@ajaxManageable')->name('blog.ajax.manageable');
    Route::get('blog/delete/{id}', 'BlogController@destroy')->name('blog.delete');
    Route::resource('blog', 'BlogController', ['except' => ['destroy', 'show']]);
});

Route::name('front.')->namespace('App\Modules\Blog\Controllers\Frontend' )->group(function() {
    Route::get('/blogs', 'BlogController@getIndex')->name('blog.index');
    Route::get('/blogs/{blog}', 'BlogController@getSingle')->name('blog.single');
});
