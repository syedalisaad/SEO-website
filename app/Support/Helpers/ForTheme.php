<?php
//============================================================+
// File name    : For Theme.php
// Created At   : 2020-06

// Description  : Theme includes a variety of global "helper" PHP functions.
// @Author      : Junaid Ahmed
// @github      : https://github.com/xunaidahmed
// -------------------------------------------------------------------
use App\Models\Admin;

/*
 * Admin Section
 */
function getAuth() {

    $user = \Auth::guard( 'admin' )->user();

    //TODO :: Redirection to login
    if( !$user ){
        return redirect('/');
    }

    return \App\Models\User::find( $user->id );

    return \Auth::guard( 'admin' )->user();
}

function isAdmin()
{
    if( !getAuth() ) {
        return false;
    }

    return getAuth()->is_admin;
}

function get_full_name()
{
    if( !getAuth() ) {
        return 'No Name Available';
    }

    $auth = getAuth();

    return $auth->first_name . ' ' . $auth->last_name;
}

/*
 * For Frontend
 *
 * **/

function front_asset( $view ) {
	return sprintf("frontend/%s", $view );
}

function front_layout( $view ) {
	return sprintf("frontend.layouts.%s", $view );
}

function front_view( $view ) {
	return sprintf("frontend.%s", $view );
}

function front_route( $route ) {
    return sprintf("front.%s", $route );
}

/*
 * For Backend
 *
 * **/

function admin_asset( $path ) {
	return asset( sprintf("/adminlite/%s/", ltrim($path,'/') ) );
}

function admin_layout( $view ) {
	return sprintf("admin.layouts.%s", $view );
}

function admin_view( $view ) {
    return sprintf("admin.%s", $view );
}

function admin_route( $route, $default = 'admin' ) {
    return sprintf("%s.%s", $default, $route );
}

function admin_url ( $path ) {
	return url( '/admin/'. ltrim($path,'/') );
}

/*
 * For API
 *
 * **/

/*
 * For Module
 *
 * **/


function admin_module_layout( $view ) {
	return sprintf("General::admin.%s", $view );
}

/*
 * For Template - Include
 * */
function admin_module_render( $view, $module = null ) {

    $module = ($module ? $module : \Request::segment(2));
    $module = ucfirst($module);

    return sprintf("%s::admin.%s", $module, $view );
}

function admin_module_view( $view, $module = 'General' ) {
    return sprintf("%s::admin.%s", $module, $view );
}

function frontend_module_view( $view, $module = 'General' ) {
    return sprintf("%s::frontend.%s", $module, $view );
}

function mail_module_view( $view, $module = 'General' ) {
    //return sprintf("%s::mails.%s", $module, $view );
    return sprintf("User::mails.frontend.%s", $view );
}

function admin_module_lang( $lang, $default = null, $is_module = false ) {

    $module = ( $is_module ? 'General' : \Request::segment( 2 ) );
    $module = $is_module ? $module : ucfirst( $module );
    $trans  = sprintf( "%s::%s", $module, $lang );

    /*if( strpos($trans, '::')){
        return $default;
    }*/
    //dump($trans);

    return trans($trans);
}


function admin_heading( $default = null ) {

    $segment = $default ?: \Request::segment(1);

    if( !in_array($segment, ['user', 'admin'])) {
        abort(404);
    }

    return ucfirst(sprintf("%s", $segment ));
}

function admin_datetime_format( $reference_data, $time = false, $date = false )
{
	return ( $time ?
		date('F d, Y g:i a', strtotime( $reference_data )) :
		date('F d, Y', strtotime( $reference_data ))
	);
}

function anchor_delete($url, $title = 'Delete') {
	$return = '';
	$return .= '<a href="'.$url.'" onclick="return confirm(\'Are you sure you want to delete this record?\');"><i class="fa fa-trash-o"></i>' . $title . '</a>';

	return $return;
}
