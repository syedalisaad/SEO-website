<?php
//============================================================+
// File name    : For Project.php
// Created At   : 2020-06
// Description  : Helper includes a variety of global "helper" PHP functions.
// @Author      : Junaid Ahmed
// @github      : https://github.com/xunaidahmed
// -------------------------------------------------------------------
use App\Models\PatientTimelyAndEffectiveCare;
use \App\Models\Order;

function page_url( $uri = '' ) {
    return 'page/' . $uri;
}

function is_exists_file( $filename, $storage = null ) {
    $storage      = public_path( 'storage/' . ( $storage ? ltrim( $storage, '/' ) : '' ) );
    $file_storage = ( rtrim( $storage, '/' ) . '/' . ltrim( $filename, '/' ) );

    return (bool) \File::exists( $file_storage );
}

function random_number( $length ) {
    $result = '';
    for ( $i = 0; $i < $length; $i ++ ) {
        $result .= mt_rand( 0, 9 );
    }

    return $result;
}

/**
 * Get Few days Agao
 * get_few_times_ago()
 */
function get_few_times_ago( $time ) {

    $now = new Carbon\Carbon( $time );

    return $now->diffForHumans();
}

/**
 * For Messaging Days Ago
 *
 * @param      $datetime
 * @param bool $full
 *
 * @return string
 * @throws Exception
 */
function time_elapsed_string( $datetime, $full = false ) {

    $now     = new DateTime;
    $ago     = new DateTime( $datetime );
    $diff    = $now->diff( $ago );
    $diff->w = floor( $diff->d / 7 );
    $diff->d -= $diff->w * 7;
    $string  = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ( $string as $k => &$v ) {
        if ( $diff->$k ) {
            $v = $diff->$k . ' ' . $v . ( $diff->$k > 1 ? 's' : '' );
        } else {
            unset( $string[ $k ] );
        }
    }
    if ( ! $full ) {
        $string = array_slice( $string, 0, 1 );
    }

    return $string ? implode( ', ', $string ) . ' ago' : 'just now';
}

function patientSpeedOfCare( $type_of, $measure_id, $facility_id = null ) {
    return \App\Models\PatientTimelyAndEffectiveCare::where( [ 'facility_id' => $facility_id, 'measure_id' => $measure_id, 'type_of' => $type_of ] )->first();
}

function NationalScoreDetails( $type_of, $measure_id, $table ) {
    if ( $table == 'PatientUnplannedVisit' ) {
        $table = new \App\Models\PatientUnplannedVisit;
    } else if ( $table == 'PatientComplicationAndDeath' ) {
        $table = new \App\Models\PatientComplicationAndDeath;
    } else if ( $table == 'PatientInfection' ) {
        $table = new \App\Models\PatientInfection;
    } else if ( $table == 'PatientSurvey' ) {
        $table = new \App\Models\PatientSurvey;
    }

    return $table->where( [ 'measure_id' => $measure_id, 'type_of' => $type_of ] )->first();
}

function ScheduleDetails( $type_of, $patient_category = null ) {

    return \App\Models\Schedule::where( [ 'patient_category' => $patient_category, 'type_of' => $type_of ] )->first();
}

function checkIsActiveApi( $type_of, $category_id = null ) {
    return \App\Models\ApiLog::where( [ 'type_of' => $type_of, 'patient_category' => $category_id, 'is_active' => 0 ] )->first();
}

function notAvailableButton( $btn ) {
    if ( $btn = 'Not Available' || $btn = 'Not Applicable' ) {
        return 'silverbtn';
    }
}

function hasEloquentMenuTree( $tree, $parent_id = null ) {
    $refs = array();
    $list = array();
    foreach ( $tree as $row ) {
        $ref               = &$refs[ $row->id ];
        $ref['id']         = $row->id;
        $ref['parent_id']  = $row->pivot->parent_id;
        $ref['name']       = $row->name;
        $ref['slug']       = $row->is_page_off ? $row->slug : 'page/' . $row->slug;
        $ref['is_menu']    = $row->is_menu;
        $ref['extras']     = $row->extras;
        $ref['sort_order'] = $row->pivot->sort_order;
        if ( $row->pivot->parent_id == 0 ) {
            $list[ $row->id ] = &$ref;
        } else {
            $refs[ $row->pivot->parent_id ]['children'][ $row->id ] = &$ref;
        }
    }

    return $list;
}

/**
 * Current Subscription
 * get_current_subscription()
 */
function get_current_subscription( $user_id = null ) {

    $user_id = $user_id ?: auth()->user()->id;

    if( $user_id )
    {
        $current_date = date('Y-m-d H:i'); //dump($current_date);

        return Order::where('expire_package', '>=', $current_date)->where('user_id', $user_id)
                                                                  ->deliveredOrders()->first();
    }

    return null;
}

/**
 * last Subscription
 * get_last_subscription()
 */
function get_last_subscription( $user_id = null ) {

    $user_id = $user_id ?: auth()->user()->id;

    if( $user_id )
    {
        $current_date = date('Y-m-d H:i'); //dump($current_date);

        return Order::where('expire_package', '<', $current_date)->where('user_id', $user_id)
                    ->deliveredOrders()->latest()->first();
    }

    return null;
}

/**
 * Global Site Settings
 * get_site_settings()
 */
function get_site_settings( $item = null ) {

    $data     = [];
    $settings = \App\Models\Setting::all();
    if ( $settings->count() ) {

        foreach ( $settings as $key => $value ) {
            $data[ $value->key ] = $value->value;
        }
        if ( isset( $data[ $item ] ) ) {
            return $data[ $item ];
        }
    }

    return $data;
}

/*
 *  Get Datatable Search Columns
 * - - - - - - - - - - - - - - -
 *
 * */
function geCurlApiData() {
    foreach ( json_decode( $result, true ) as $key ) {

        $arr                     = array_combine( array_map( function( $str ) {
            $arry_HCAHPS_remove = str_replace( "HCAHPS ", "", $str );

            return str_replace( " ", "_", $arry_HCAHPS_remove );
        }, array_keys( $key ) ), array_values( $key ) );
        $push_data['created_by'] = 2;
        $push_data['type_of']    = $request->type_of;
        $array[ $j ]             = array_change_key_case( $arr, CASE_LOWER );
        $array_save[ $j ]        = array_merge( $array[ $j ], $push_data );
        $table[ $i ]->create( $array_save[ $j ] );
        $j ++;
    }
}

;
/*
 *  Get Datatable Search Columns
 * - - - - - - - - - - - - - - -
 *
 * */
function getColsByDataable( $search_cols, $excepts_cols = null ) {
    $excepts_cols = array_filter( is_array( $excepts_cols ) ? $excepts_cols : [ $excepts_cols ] );
    $search_cols  = array_column( $search_cols, 'name' );

    return array_diff( $search_cols, $excepts_cols );
}

;
function array_group_dot( $arr ) {
    if ( count( $arr ) < 1 ) {
        return $arr;
    }
    $_tmp = [];
    foreach ( $arr as $key => $value ) {
        $split                     = explode( '.', $value );
        $_tmp[ $split[0] ][ $key ] = $value;
    }

    return $_tmp;
}

function dot_heading( $name, $replace = null ) {
    $split = explode( '.', $name );
    if ( count( $split ) ) {
        $name = preg_replace( '/(\s|&(amp;)?|\.)+/', ' ', $name );

        return ucwords( $name );
    }

    return $name;
}

function upload_max_filesize_label() {
    $size_prefix = strtolower( ini_get( 'upload_max_filesize' ) );
    $size_prefix = str_replace( 'm', 'mb', $size_prefix );
    $size_prefix = strtoupper( $size_prefix );

    return $size_prefix;
}

function multi_array_diff( $arraya, $arrayb ) {
    foreach ( $arraya as $keya => $valuea ) {
        if ( in_array( $valuea, $arrayb ) ) {
            unset( $arraya[ $keya ] );
        }
    }

    return $arraya;
}

function remove_space_bracket_api( $data ) {
    $j = 0;
    foreach ( $data as $key ) {
        $arr         = array_combine( array_map( function( $str ) {
            $arry_HCAHPS_remove = str_replace( "HCAHPS ", "", $str );

            return str_replace( " ", "_", $arry_HCAHPS_remove );
        }, array_keys( $key ) ), array_values( $key ) );
        $array[ $j ] = array_change_key_case( $arr, CASE_LOWER );
        $j ++;
    }

    return $array;
}

function array_index_map( $object, $index, $remove_index = false ) {
    $newArray = array();
    foreach ( $object as $key => $obj ) {
        if ( isset( $obj[ $index ] ) ) {
            $_tmp = $obj[ $index ];
            if ( $remove_index ) {
                unset( $obj[ $index ] );
            }
            $newArray[ $_tmp ] = $obj;
        }
    }

    return $newArray;
}

function email_template_sitename($site_settings) {
    $site_name = $site_settings['sites']['site_name'] .'.com';
    return '<a href="'.env('APP_URL', '/').'">'. $site_name .'</a>';
}

function getYoutubeId($url) {
    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^\#&\n]+|(?<=youtu.be/)[^&\n]+#", $url, $matches);
    return current($matches);
}
