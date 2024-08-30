<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\User\Controllers\Backend' )->group(function() {

    //List of States & Cities
    Route::get('user/states/list/{country_id}', 'UserController@ajaxStates')->name('user.ajax.state');
    Route::get('user/cities/list/{state_id}', 'UserController@ajaxCities')->name('user.ajax.city');

    Route::get('user/ajax/list', 'UserController@ajaxManageable')->name('user.ajax.manageable');
    Route::get('user/ajax/trashed', 'UserController@ajaxTrashManageable')->name('user.ajax.trash.manageable');

    Route::get('user/delete/{id}', 'UserController@destroy')->name('user.delete');

    Route::get('user/trash/{id}', 'UserController@forceTrash')->name('user.trash');
    Route::get('user/undo/{id}', 'UserController@undo')->name('user.undo');

    //List of Unverified Hospitals
   Route::get('user/hospitals/un-verified/index', 'UserController@getUserUnverifiedHospitalIndex')->name('user.hospital.unverified.index');
   Route::get('user/ajax/hospitals/un-verified/list', 'UserController@ajaxUserUnverifiedHospitalManageable')->name('user.ajax.hospital.unverified.manageable');
   Route::get('user/hospitals/request/{status}/{user_id}', 'UserController@manageableHospitalStatus')->name('user.hospital.managestatus');

    //List of Unverified User
    Route::get('user/un-verified/index', 'UserController@getUserUnverifiedIndex')->name('user.unverified.index');
    Route::get('user/ajax/un-verified/list', 'UserController@ajaxUserUnverifiedManageable')->name('user.ajax.unverified.manageable');
    Route::get('user/resend/{user_id}', 'UserController@resendUserEmail')->name('user.resend.email');

    Route::resource('user', 'UserController');
});

Route::name('front.')->namespace('App\Modules\User\Controllers\Frontend' )->group(function() {

    //Login
    Route::get('/login', 'UserController@getLogin')->name('user.login');
    Route::post('/login', 'UserController@postLogin')->name('user.login');

    //Register
    Route::get('/register', 'UserController@getRegister')->name('user.register');
    Route::post('/register', 'UserController@postRegister')->name('user.register');

    //Verification Account
    Route::get('/verify-account', 'UserController@getVerifyToken')->name('user.verifybytoken');
    Route::get( '/email/verified/{token}', 'UserController@getEmailVerification' )->name( 'user.email.verified' );

    //Forgot Password
    Route::get('/forgot', 'UserController@getForgot')->name('user.forgot');
    Route::post('/forgot', 'UserController@postForgot')->name('user.forgot');

    //Reset Password
    Route::get('/reset-password/{token}', 'UserController@getResetPassword')->name('user.reset_password');
    Route::post('/reset-password/{token}', 'UserController@postResetPassword')->name('user.reset_password');
    Route::get('reset/new-pasword/{token}', 'UserController@getResetPassword')->name('user.reset.newpassword');
    Route::post('reset/new-pasword/{token}', 'UserController@postResetNewPassword')->name('user.reset.savednewpassword');

    //remove vidoe
    Route::post('ajax-remove-video','UserController@ajaxRemoveVideo')->name('ajax_remove_video');
});
Route::name('front.user.')->namespace('App\Modules\User\Controllers\Frontend' )->group(function() {
    Route::post('ajax-remove-video','UserController@ajaxRemoveVideo')->name('ajax_remove_video');

});

Route::name('front.user.')->middleware('user')->namespace('App\Modules\User\Controllers\Frontend' )->group(function() {

    //Order
    Route::get('user/orders/list', 'OrderController@getOrdersList')->name('orders');

    //package
    Route::get('/packages', 'UserController@getPackages')->name('packages');
    Route::get('/unsubscribe-package/{order_id}', 'UserController@getUnsubscribePackage')->name('unsubscribe.package');

    //payment
    Route::get('/payment', 'UserController@getpayment')->name('payment');

    //Profile Setting
    Route::get('/profile', 'UserController@getEditProfile')->name('edit.setting');
    Route::post('/profile', 'UserController@postEditProfile')->name('edit.setting.update');

    //Change Password
    Route::get('/change-password', 'UserController@getChangePassword')->name('change_password');
    Route::post('/change-password', 'UserController@postChangePassword')->name('change_password');

    //Dashboard upload
    Route::post('/dashboard-update', 'UserController@postdashboardUpdate')->name('dashboard_update');
    Route::post('/dashboard-share-image', 'UserController@postShareImageUpdate')->name('dashboard.share_image.upload');


    Route::post('reset/change-password', 'UserController@postChangePassword')->name('reset.change_password');

    //logout
    Route::get('/logout', 'UserController@logout')->name('logout');
    Route::get('/change-password', 'UserController@getChangePassword')->name('change_password');

    //package terms
    Route::get('/payment-terms-and-condition', 'UserController@getTerms')->name('terms');

    //package terms
    Route::post('/system_price_email', 'UserController@postSystemPrice')->name('systemprice');

    //package email
    Route::post('/help_email', 'UserController@postHelpEmail')->name('helpemail');



});
