<?php
//============================================================+
// File name    : For API
// Created At   : 2021-06

// Description  : Theme includes a variety of global "helper" PHP functions.
// @Author      : Junaid Ahmed
// @github      : https://github.com/xunaidahmed
// -------------------------------------------------------------------

use \App\Models\User;

function validate_errors($errors)
{

    if (count($errors)) {
        return array_map(function ($v) {
            return $v[0];
        }, $errors);
    }

    return [];
}

function response_replace_message($message, $replace = null)
{
    $items = $replace && is_array($replace) ? $replace : [];

    if (count($items)) {
        foreach ($items as $key => $value) {
            $pattern = '/{' . $key . '}/i';
            $message = preg_replace($pattern, $value, $message);
        }
    }

    return $message;
}

/**
 *
 * FCM Token Policy "extras"
 * - - - - - - - - - - - - - - - - - - - - - -
 *
 */
function curl_service_provider($query,$OFFSET)
{
    $api_url = "https://data.cms.gov/provider-data/api/1/datastore/sql?query=" . urlencode($query . '[LIMIT 50 OFFSET '.$OFFSET.']');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_HEADER, FALSE);
//    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 300);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $array = json_decode($result, true);

    return $array;
}

/**
 *
 * Notification for Mobile Notification (FCM)
 * - - - - - - - - - - - - - - - - - - - - - -
 *
 */
function send_fcm_notify($token, $notification, $data = [])
{
    /**
     * @notification:
     * @var (title, body)
     *
     * @data
     * @var custom variable array
     *
     */
    $fields = [
        'to' => $token,
        'notification' => $notification
    ];

    if (count($data)) {
        $fields['data'] = $data;
    }

    $FIREBASE_AUTHORIZATION_KEY = env('FIREBASE_AUTHORIZATION_KEY');

    $headers = array(
        'Authorization:key=' . $FIREBASE_AUTHORIZATION_KEY,
        'Content-Type:application/json'
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));

    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
