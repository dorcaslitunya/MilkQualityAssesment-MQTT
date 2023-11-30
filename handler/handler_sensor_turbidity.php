<?php
echo BR . "******************** handler_Register ********************" . BR;

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/milktester.com/public_html/');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/MQTT_Engine_PHP/error_toggle.php";
// --------- /enable display all errors --------- 

// --------- Declare messages in and out --------- 
echo $message;
$handler_turbidity_resp = array();
// --------- /Declare messages in and out --------- 

$do_continue = true;
// MQTT Payload MUST be valid JSON first. 
if ($message_php_arr = json_decode($message, true)) {
    if (array_key_exists("turb", $message_php_arr)) {
        $turbidity_reading = $message_php_arr['turb'];
    } else  if (array_key_exists("turbidity", $message_php_arr)) {
        $turbidity_reading = $message_php_arr['turbidity'];
    } else $turbidity_reading = null;


    if (!isset($turbidity_reading)) {
        $handler_turbidity_resp['succ'] = 0;
        $handler_turbidity_resp['code'] = array();
        $handler_turbidity_resp['info'] = array();
        array_push($handler_turbidity_resp['code'], "000");
        array_push($handler_turbidity_resp['info'], "No turbidity data");
        // Do not go beyond this level.
        $do_continue = false;
    } else {
        $response_topic = "milktester/response/turbidity";
        echo BR . "response topic -> $response_topic" . BR;
    }

    if ($do_continue) {
        // --------- Register or update the unit --------- 
        $UpdateTurbidityQuery_resp = array();
        include "handler_sensor_turbidity_db.php";
        $handler_turbidity_resp = $UpdateTurbidityQuery_resp;
        // --------- /Register or update the unit --------- 
    }
} else {
    // report why and if it is not a valid JSON.
    echo "\n";
    echo "error decoding JSON message: " . json_last_error_msg();
    echo "\n";

    $handler_turbidity_resp["succ"] = 0;
    $handler_turbidity_resp['code'] = array();
    $handler_turbidity_resp['info'] = array();
    array_push($handler_turbidity_resp['code'], json_last_error());
    array_push($handler_turbidity_resp['info'], json_last_error_msg());
    // $handler_turbidity_resp["code"] = json_last_error();
    // $handler_turbidity_resp["info"] = json_last_error_msg();
    // $handler_turbidity_resp = json_encode($handler_turbidity_resp);
}
// Enable message publish response.
$do_respond = true;
// Package response message.
echo json_encode($handler_turbidity_resp);
$response_message = json_encode($handler_turbidity_resp);
