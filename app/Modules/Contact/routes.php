<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\Contact\Controllers\Backend' )->group(function() {
    Route::get('contact/list', 'ContactController@getAjaxList')->name('contact.ajaxlist');
    Route::get('contact/delete/{id}', 'ContactController@destroy')->name('contact.delete');
    Route::resource('contact', 'ContactController', ['except' => ['create', 'edit', 'update', 'show']]);
});
