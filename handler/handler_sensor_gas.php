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
$handler_gas_resp = array();
// --------- /Declare messages in and out --------- 

$do_continue = true;
// MQTT Payload MUST be valid JSON first. 
if ($message_php_arr = json_decode($message, true)) {
    if (array_key_exists("gas", $message_php_arr)) {
        $gas_reading = $message_php_arr['gas'];
    } else  if (array_key_exists("ammonia", $message_php_arr)) {
        $gas_reading = $message_php_arr['ammonia'];
    } else $gas_reading = null;


    if (!isset($gas_reading)) {
        $handler_gas_resp['succ'] = 0;
        $handler_gas_resp['code'] = array();
        $handler_gas_resp['info'] = array();
        array_push($handler_gas_resp['code'], "000");
        array_push($handler_gas_resp['info'], "No gas data");
        // Do not go beyond this level.
        $do_continue = false;
    } else {
        $response_topic = "milktester/response/gas";
        echo BR . "response topic -> $response_topic" . BR;
    }

    if ($do_continue) {
        // --------- Register or update the unit --------- 
        $UpdateGasQuery_resp = array();
        include "handler_sensor_gas_db.php";
        $handler_gas_resp = $UpdateGasQuery_resp;
        // --------- /Register or update the unit --------- 
    }
} else {
    // report why and if it is not a valid JSON.
    echo "\n";
    echo "error decoding JSON message: " . json_last_error_msg();
    echo "\n";

    $handler_gas_resp["succ"] = 0;
    $handler_gas_resp['code'] = array();
    $handler_gas_resp['info'] = array();
    array_push($handler_gas_resp['code'], json_last_error());
    array_push($handler_gas_resp['info'], json_last_error_msg());
    // $handler_gas_resp["code"] = json_last_error();
    // $handler_gas_resp["info"] = json_last_error_msg();
    // $handler_gas_resp = json_encode($handler_gas_resp);
}
// Enable message publish response.
$do_respond = true;
// Package response message.
echo json_encode($handler_gas_resp);
$response_message = json_encode($handler_gas_resp);
