<?php
Route::prefix('admin')->name('admin.')->middleware('admin')->namespace('App\Modules\HospitalSurvey\Controllers\Backend' )->group(function() {

    Route::get('hospital-survey/ajax/list', 'HospitalSurveyController@ajaxManageable')->name('hospitalsurvey.ajax.manageable');
    Route::get('hospital-survey/list', 'HospitalSurveyController@getManage')->name('hospitalsurvey.list');
    Route::get('/hospital-survey/show/{id}', 'HospitalSurveyController@show')->name('hospitalsurvey.show');

    //Hospitals - Request Change Informations
    Route::get('hospital-survey/ajax/change-info-request/list', 'HospitalSurveyController@ajaxHospitalChangeReqInfo')->name('hospitalsurvey.ajax.change_info_req');
    Route::get('hospital-survey/change-info-request', 'HospitalSurveyController@getHospitalChangeReqInfo')->name('hospitalsurvey.change_info_req');

    Route::get('hospital-survey/change-info-request/form/{id}', 'HospitalSurveyController@formHospitalChangeReqInfo')->name('hospitalsurvey.form.change_info_req');
    Route::post('hospital-survey/change-info-request/form/{id}', 'HospitalSurveyController@postHospitalChangeReqInfo')->name('hospitalsurvey.submit.change_info_req');

    Route::resource('hospital', 'HospitalSurveyController', ['except' => ['destroy', 'show']]);
});
