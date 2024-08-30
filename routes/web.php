<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

//Authentication
Route::prefix('admin')->name('admin.')->group(function() {

    Route::get('login', 'AdminAuthController@showLoginForm');

    //Authentication
    Route::get('login', 'AdminAuthController@showLoginForm')->name( 'login');
    Route::post('login', 'AdminAuthController@login')->name('authorize.login');

    //Reset Password
    Route::get('reset', 'AdminAuthController@showResetForm')->name( 'reset');
    Route::post('reset', 'AdminAuthController@sendPasswordResetToken')->name('submit.reset');

    Route::get('reset/new-pasword/{token}', 'AdminAuthController@getPasswordResetToken')->name('reset.newpassword');
    Route::post('reset/new-pasword/{token}', 'AdminAuthController@postResetNewPassword')->name('reset.savednewpassword');

    Route::get('logout', 'AdminAuthController@logout')->name('logout');

    //For Backend Routes
    Route::namespace('Admin' )->middleware('admin')->group(function() {
        require('provider.php');
    });
});

/*Route::name( 'front.' )->group(function()
{
    Route::get( '/login', 'UserAuthController@showLoginForm' )->name( 'page.login' );
    Route::post( '/create/register', 'UserAuthController@register' )->name( 'register' );
    Route::get( '/email/verified/{token}', 'UserAuthController@getEmailVerification' )->name( 'email.verified' );
    Route::post('/login', 'UserAuthController@login')->name('authorize.login');
    Route::get( '/register', 'UserAuthController@showRegisterForm' )->name( 'page.register' );
    //Reset Password
    Route::get('reset', 'UserAuthController@showResetForm')->name( 'reset');
    Route::post('reset', 'UserAuthController@sendPasswordResetToken')->name('submit.reset');

    Route::get('reset/new-pasword/{token}', 'UserAuthController@getPasswordResetToken')->name('reset.newpassword');
    Route::post('reset/new-pasword/{token}', 'UserAuthController@postResetNewPassword')->name('reset.savednewpassword');
});*/

//For Frontend Routes
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/stripe-webhook', [App\Http\Controllers\HomeController::class, 'stripe_webhook'])->name('stripe_webhook');

//For Developers Routes
Route::prefix('dev')->group(function () {
    require('dev-commands.php');
});
