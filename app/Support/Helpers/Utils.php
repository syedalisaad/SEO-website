<?php
//============================================================+
// File name    : Utils.php
// Created At   : 2020-06

// Description  : Utils includes a variety of global "helper" PHP functions.
// @Author      : Junaid Ahmed
// @github      : https://github.com/xunaidahmed
// -------------------------------------------------------------------

function q_start(){
    \DB::enableQueryLog();
}

function q_end(){
    dd(\DB::getQueryLog());
}

/*
 * Get Media Storage
 * - - - - - - - - - - - - - - - - - - - - - - - -
 *
 * @path
 * @storage     null ($storage | default : public)
 * $disk        null ($disk | default: local)
 * $default     null ($return | default: dummy image)
 *
 * **/
function media_storage_url( $path, $storage = null, $disk = null, $return_by = null, $size = '300x300' ) {

    $file_path = ('storage/' . ltrim( $path, '/' ));

    if( \File::exists(public_path($file_path)) ) {
        return url( $file_path );
    }

    if( !$return_by ) {
        return $return_by;
    }

    return "https://via.placeholder.com/$size";
    return 'https://dummyimage.com/600x400/f2f2f2/0d0d0d.png&text=No+Image';
}

function default_media_url( $default_url = null ) {

    return $default_url ?: 'https://via.placeholder.com/300x300';

    return 'https://dummyimage.com/600x400/f2f2f2/0d0d0d.png&text=No+Image';
}

function is_url_exist($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    $status = $code == 200 ? true : false;

    curl_close($ch);
   return $status;
}

/**
 * HTML Remove All tags
 * strip_tags_content()
 */
function strip_tags_content($string) {

    // ----- remove HTML TAGs -----
    $string = preg_replace( '/<[^>]*>/', ' ', $string );
    // ----- remove control characters -----
    $string = str_replace( "\r", '', $string );
    $string = str_replace( "\n", ' ', $string );
    $string = str_replace( "\t", ' ', $string );
    $string = str_replace( "&nbsp;", ' ', $string );
    // ----- remove multiple spaces -----
    $string = trim( preg_replace( '/ {2,}/', ' ', $string ) );

    return $string;
 }

/**
 * Conversion Currency Format
 * format_currency()
 */
function format_currency($amount, $format = 'USD')
{
    return number_format($amount, 2) . ' ' . $format;
}

/**
 * Conversion Date Format
 * format_datetime()
 */
function format_datetime($datetime, $format = 'Y-m-d H:i')
{
    return date($format, strtotime($datetime));
}

/**
 * Get Number Random Value
 * n_digit_random()
 */
function n_digit_random( $digits = 6 )
{
    $temp = "";
    for ( $i = 0; $i < $digits; $i ++ ) {
        $temp .= rand( 0, 9 );
    }

    if(strlen($temp) == $digits){
    	return (int) $temp;
    }

    return n_digit_random($digits) ;
}

/**
 * Get String Random Value
 * generate_random_string()
 */
function generate_random_string( $length = 10 ) {

    $characters       = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen( $characters );
    $randomString = '';

    for ( $i = 0; $i < $length; $i ++ ) {
        $randomString .= $characters[ rand( 0, $charactersLength - 1 ) ];
    }

    return $randomString;
}

/**
 * Display Base64 view Image
 * save_image_base64JPEG()
 */
function save_image_base64JPEG( $data, $path ) {

    $base64_string = 'data:image/png;base64,' . $data;
    $output_file = str_random() . '.jpg';
    // open the output file for writing
    $ifp = fopen( $path . '/' . $output_file, 'wb' );
    // split the string on commas
    // $data[ 0 ] == "data:image/png;base64"
    // $data[ 1 ] == <actual base64 string>
    $data = explode( ',', $base64_string );
    // we could add validation here with ensuring count( $data ) > 1
    fwrite( $ifp, base64_decode( $data[1] ) );
    // clean up the file resource
    fclose( $ifp );

    return $output_file;
}

/**
 * Save image base64-encoded
 * save_image_base64Encoded()
 */
function save_image_base64Encoded( $data, $path, $csBase64 = null )
{
    if ( $csBase64 ) {
        $data = 'data:image/png;base64,' . $data;
    }
    list( $type, $data ) = explode( ';', $data );
    list( , $data ) = explode( ',', $data );
    $data = base64_decode( $data );
    $file_name = str_random() . '.png';
    file_put_contents( $path . '/' . $file_name, $data );

    return $file_name;
}

