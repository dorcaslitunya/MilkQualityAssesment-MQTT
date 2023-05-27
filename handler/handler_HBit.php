<?php
echo BR . "******************** heartbeat handler ********************" . BR;

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/bme.kiriev.com/public_html');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// --------- /enable display all errors --------- 

// --------- Declare messages in and out --------- 
echo $message;
$handler_charger_resp = array();
// --------- /Declare messages in and out --------- 

// MQTT Payload MUST be valid JSON first. 
if ($message_php_arr = json_decode($message, true)) {
    // Get the unit serial 
    if (array_key_exists("IMEI", $message_php_arr)) {
        $unit_serial = $message_php_arr['IMEI'];
    } else if (array_key_exists("imei", $message_php_arr)) {
        $unit_serial = $message_php_arr['imei'];
    } else if (array_key_exists("im", $message_php_arr)) {
        $unit_serial = $message_php_arr['im'];
    } else if (array_key_exists("IM", $message_php_arr)) {
        $unit_serial = $message_php_arr['IM'];
    } else if (array_key_exists("serial", $message_php_arr)) {
        $unit_serial = $message_php_arr['serial'];
    } else if (array_key_exists("SERIAL", $message_php_arr)) {
        $unit_serial = $message_php_arr['SERIAL'];
    } else if (array_key_exists("ser", $message_php_arr)) {
        $unit_serial = $message_php_arr['ser'];
    } else if (array_key_exists("SER", $message_php_arr)) {
        $unit_serial = $message_php_arr['SER'];
    } else if (array_key_exists("SRL", $message_php_arr)) {
        $unit_serial = $message_php_arr['SRL'];
    } else if (array_key_exists("srl", $message_php_arr)) {
        $unit_serial = $message_php_arr['srl'];
    } else $unit_serial = null;
    if (!isset($unit_serial)) {
        $handler_charger_resp['succ'] = 0;
        $handler_charger_resp['code'] = array();
        $handler_charger_resp['info'] = array();
        array_push($handler_charger_resp['code'], "000");
        array_push($handler_charger_resp['info'], "!serial");
        // Do not go beyond this level.
        $do_continue = false;
    } else {
        $response_topic = "KIRI/node/$unit_serial/11";
        echo BR . "response topic -> $response_topic" . BR;
    }

    // Get the unit group
    if (array_key_exists("group", $message_php_arr)) {
        $unit_group = $message_php_arr['group'];
    } else if (array_key_exists("GROUP", $message_php_arr)) {
        $unit_group = $message_php_arr['GROUP'];
    } else if (array_key_exists("grp", $message_php_arr)) {
        $unit_group = $message_php_arr['grp'];
    } else if (array_key_exists("GRP", $message_php_arr)) {
        $unit_group = $message_php_arr['GRP'];
    } else if (array_key_exists("institution", $message_php_arr)) {
        $unit_group = $message_php_arr['institution'];
    } else if (array_key_exists("inst", $message_php_arr)) {
        $unit_group = $message_php_arr['inst'];
    } else if (array_key_exists("organisation", $message_php_arr)) {
        $unit_group = $message_php_arr['organisation'];
    } else if (array_key_exists("org", $message_php_arr)) {
        $unit_group = $message_php_arr['org'];
    } else $unit_group = null;
    if (!isset($unit_group)) {
        // $handler_charger_resp['succ'] = 0;
        // $handler_charger_resp['code'] = array();
        // $handler_charger_resp['info'] = array();
        // array_push($handler_charger_resp['code'], "000");
        // array_push($handler_charger_resp['info'], "!group");
        // // Do not go beyond this level.
        // $do_continue = false;
    }

    // Get the unit category  
    if (array_key_exists("category", $message_php_arr)) {
        $unit_category = $message_php_arr['category'];
    } else if (array_key_exists("CATEGORY", $message_php_arr)) {
        $unit_category = $message_php_arr['CATEGORY'];
    } else if (array_key_exists("CAT", $message_php_arr)) {
        $unit_category = $message_php_arr['CAT'];
    } else if (array_key_exists("cat", $message_php_arr)) {
        $unit_category = $message_php_arr['cat'];
    } else if (array_key_exists("CTGRY", $message_php_arr)) {
        $unit_category = $message_php_arr['CTGRY'];
    } else if (array_key_exists("ctgry", $message_php_arr)) {
        $unit_category = $message_php_arr['ctgry'];
    } else $unit_category = null;
    if (!isset($unit_category)) {
        // $handler_charger_resp['succ'] = 0;
        // $handler_charger_resp['code'] = array();
        // $handler_charger_resp['info'] = array();
        // array_push($handler_charger_resp['code'], "000");
        // array_push($handler_charger_resp['info'], "!category");
        // // Do not go beyond this level.
        // $do_continue = false;
    }

    if ($do_continue) {
        // // --------- Register or update the unit --------- 
        // $handler_RegisterUnit_resp = array();
        // include "handler_RegisterUnit.php";
        // $handler_charger_resp = $handler_RegisterUnit_resp;
        // // --------- /Register or update the unit --------- 


        $handler_charger_resp["succ"] = 1;
        $handler_charger_resp["code"] = 1;
        $handler_charger_resp["info"] = "ack";
    }
} else {
    // report why and if it is not a valid JSON.
    echo "\n";
    echo "error decoding JSON message: " . json_last_error_msg();
    echo "\n";

    $handler_charger_resp["succ"] = 0;
    $handler_charger_resp['code'] = array();
    $handler_charger_resp['info'] = array();
    array_push($handler_charger_resp['code'], json_last_error());
    array_push($handler_charger_resp['info'], json_last_error_msg());
    // $handler_charger_resp["code"] = json_last_error();
    // $handler_charger_resp["info"] = json_last_error_msg();
    // $handler_charger_resp = json_encode($handler_charger_resp);
}
// Enable message publish response.
$do_respond = true;
// Package response message.
echo json_encode($handler_charger_resp);
$response_message = json_encode($handler_charger_resp);
