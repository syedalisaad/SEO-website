<?php
Route::prefix( 'admin' )->name( 'admin.' )->middleware( 'admin' )->namespace( 'App\Modules\Page\Controllers\Backend' )->group( function() {
    Route::get( 'page/list', 'PageController@ajaxManageable' )->name( 'page.ajax.manageable' );
    Route::get( 'page/delete/{id}', 'PageController@destroy' )->name( 'page.delete' );
    Route::resource( 'page', 'PageController', [ 'except' => [ 'destroy', 'show' ] ] );
});

Route::name( 'front.' )->namespace( 'App\Modules\Page\Controllers\Frontend' )->group( function()
{
    //For Newsleeter
    Route::post( '/newsletter', 'PageController@postNewsletter' )->name( 'page.newsletter' );

    Route::get( '/contact-us', 'PageController@getContact' )->name( 'page.contact' );
    Route::post( '/contact-us', 'PageController@postContact' )->name( 'page.contact' );

    Route::get( 'page/{page}', 'PageController@getPageManagement' )->name( 'page.management' );

    Route::get( '/about-us', 'PageController@getAbout' )->name( 'page.about' );
    Route::get( '/terms-of-service', 'PageController@getTerms' )->name( 'page.terms' );
    Route::get( '/faqs', 'PageController@getFAQs' )->name( 'page.faq' );
    Route::get( '/privacy-policy', 'PageController@getPrivacyPolicy' )->name( 'page.privacy_policy' );
    Route::get( '/email', 'PageController@getEmail' )->name( 'page.email' );

    Route::get( '/premium/{slug}', 'PageController@getPremium' )->name( 'page.premium' );

    Route::get( '/near-me', 'PageController@getHospitalList' )->name( 'page.hospital.list' );
    Route::get( '/hospital-view/{slug}', 'PageController@getUnpaid' )->name( 'page.unpaid' );
//    Route::get( '/hospital/{slug}', 'PageController@getHospital' )->name( 'page.hospital' );
    Route::get( '/hospital/infection/{slug}', 'PageController@getInfection' )->name( 'page.hospital.infection' );
    Route::get( '/national/infection', 'PageController@getInfectionNAtional' )->name( 'page.national.infection' );
    Route::get( '/hospital/survey/{slug}', 'PageController@getSurvey' )->name( 'page.hospital.survey' );
    Route::get( '/national/survey', 'PageController@getSurveyNational' )->name( 'page.national.survey' );
    Route::get( '/national/national-averages', 'PageController@getNationalAvarages' )->name( 'page.national.national_avarages' );
    Route::get( '/hospital/death-and-complication/{slug}', 'PageController@getDeathAndComplications' )->name( 'page.hospital.death_and_complication' );
    Route::get( '/national/death-and-complication', 'PageController@getDeathAndComplicationsNational' )->name( 'page.national.death_and_complication' );
    Route::get( '/hospital/readmission/{slug}', 'PageController@getReadmission' )->name( 'page.hospital.readmission' );
    Route::get( '/national/readmission', 'PageController@getReadmissionNational' )->name( 'page.national.readmission' );
    Route::get( '/hospital/speed-of-care/{slug}', 'PageController@getSpeedOfCare' )->name( 'page.hospital.speed-of-care' );
    Route::get( '/national/speed-of-care/', 'PageController@getSpeedOfCareNational' )->name( 'page.national.speed-of-care' );
    Route::get( '/getHospitalAjax', 'PageController@postFacilityNameAjaxx' )->name( 'page.facility_name_ajax' );

    Route::get( '/getHospitalMap', 'PageController@getHospitals' )->name( 'page.map.hospitals' );
});
