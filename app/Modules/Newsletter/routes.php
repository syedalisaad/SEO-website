<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\Newsletter\Controllers\Backend' )->group(function() {

    Route::post('newsletter/send/email', 'NewsletterController@postSendNewsletter')->name('newsletter.send');

    Route::get('newsletter/list', 'NewsletterController@getAjaxList')->name('newsletter.ajaxlist');
    Route::get('newsletter/delete/{id}', 'NewsletterController@destroy')->name('newsletter.delete');
    Route::resource('newsletter', 'NewsletterController', ['except' => ['create', 'edit', 'update', 'show']]);
});
