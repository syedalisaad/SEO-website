<?php

//For Roles
Route::get('role/list', 'RoleController@ajaxManageable')->name('role.ajax.manageable');
Route::get('role/delete/{id}', 'RoleController@destroy')->name('role.delete');
Route::resource('role', 'RoleController', ['except' => ['show']]);

//For Permissions
Route::get('permission/list', 'PermissionController@ajaxManageable')->name('permission.ajax.manageable');
Route::get('permission/delete/{id}', 'PermissionController@destroy')->name('permission.delete');
Route::resource('permission', 'PermissionController', ['except' => ['show']]);
