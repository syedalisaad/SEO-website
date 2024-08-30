<?php
Route::prefix('admin')->name('admin.site.')->namespace('App\Modules\Setting\Controllers\Backend' )->group(function() {
    Route::get( 'setting/sites', 'SettingController@getSites' )->name( 'setting' );
    Route::post( 'setting/sites', 'SettingController@postSites' )->name( 'save_setting' );
    Route::post( 'setting/change-password', 'SettingController@postChangePassword' )->name( 'change_password' );
    Route::post( 'setting/hospital-survey-job', 'SettingController@postChangePassword' )->name( 'change_password' );
    Route::post( 'setting/auth-setting', 'SettingController@postAuthSetting' )->name( 'authsetting' );
    Route::post( 'setting/hospital-survey', 'SettingController@postHospitalSurveyJobs' )->name( 'postHospitalSurveyJobs' );

});
