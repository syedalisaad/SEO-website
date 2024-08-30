<?php
Route::prefix('admin')->name('admin.')->namespace('App\Modules\ApiJob\Controllers' )->group(function() {
    Route::get('apilog/load/{type}/{categories}', 'ApiLogController@ApiJob')->name('ApilogController.ApiLoad');
    Route::get('apilog/load/{type}', 'ApiLogController@ApiJob')->name('ApilogController.ApiLoadGeneral');
    Route::get('apilog/footnode/crosswalk', 'ApiLogController@getFootnodeCrosswalk')->name('ApilogController.footnode-crosswalk');

});
