<?php
echo BR . "******************** handler_RegisterUnit ********************" . BR;

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/milktester.com/public_html/');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// --------- /enable display all errors --------- 

$payload = array(
    'turbidity_reading' => $turbidity_reading
);

$db_name = 'sensors';
$table_name = 'turbidity';

include_once SITE_ROOT_PATH . "/MQTT_Engine_PHP/logger/db/DBKonnekt.php";

$UpdateTurbidityQuery = db_konnekt($db_name)->generic_insert_data($table_name, $payload);
echo BR . json_encode($UpdateTurbidityQuery) . BR;
$UpdateTurbidityQuery_resp = $UpdateTurbidityQuery;
