<?php
Route::name('admin.')->prefix( 'admin' )->namespace( 'App\Modules\Dashboard\Controllers\Backend' )->middleware('admin')->group( function() {
    Route::get( '/dashboard', 'DashboardController@index' )->name( 'dashboard' );
    Route::get( '/media-manager', 'DashboardController@mediaManager' )->name( 'media.manager' );
});

/*Route::prefix( 'admin/storage-manager' )->middleware('admin')->group( function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});*/

Route::name('front.')->middleware('user')->namespace('App\Modules\Dashboard\Controllers\Frontend' )->group(function() {
    Route::get('/dashboard', 'DashboardController@indexDashboard')->name('user.dashboard');
});
