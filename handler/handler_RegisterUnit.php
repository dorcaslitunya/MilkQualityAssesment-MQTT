<?php
echo BR . "******************** handler_RegisterUnit ********************" . BR;

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/bme.kiriev.com/public_html');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// --------- /enable display all errors --------- 

include_once __DIR__ . "/handler_RegisterUnit.class.php";

// Globals
$unit_ID = $unit_category . "_" . $unit_serial . "_" . (bin2hex(random_bytes(6)));

if ($unit_category == "chrg") { //TODO - Fetch and loof from a table of categories and category names
    $table_name = 'chargers_summary';
} else {
    $table_name = 'units_uncat_summary';
}

$payload = array(
    'unit_serial' => $unit_serial,
    'unit_group' => $unit_group,
    'unit_category' => $unit_category,
    'unit_ID' => $unit_ID
);

$unit_is_brand_new = false;


// ***************************** register new node - Summary table ***************************** 
$db_name = "kiri_entitee";
$Unit_ClassInst = new Unit_RegisterUpdateHbit();
$handler_RegisterUnit_resp = $Unit_ClassInst->Unit_Register($db_name, $table_name, $payload);

if (isset($handler_RegisterUnit_resp['succ']) && $handler_RegisterUnit_resp['succ'] == 1 && isset($handler_RegisterUnit_resp['code']) && $handler_RegisterUnit_resp['code'] == 1) {
    $unit_is_brand_new = true;
}

echo BR . " ----- Register Summary response -----> " . json_encode($handler_RegisterUnit_resp) . BR . "-----------------" . BR;
// ***************************** /register new node - Summary table  ***************************** 


// ***************************** register new node - group table ***************************** 
$db_name = "group_radiinvestments_8u0c2l0s1k6h9y7d1h0f_db";
$Unit_ClassInst = new Unit_RegisterUpdateHbit();
$handler_RegisterUnit_resp = $Unit_ClassInst->Unit_Register($db_name, $table_name, $payload);

if (isset($handler_RegisterUnit_resp['succ']) && $handler_RegisterUnit_resp['succ'] == 1 && isset($handler_RegisterUnit_resp['code']) && $handler_RegisterUnit_resp['code'] == 1) {
    $unit_is_brand_new = true;
}

echo BR . " ----- Register Group response -----> " . json_encode($handler_RegisterUnit_resp) . BR . "-----------------" . BR;
// ***************************** /register new node - group table  ***************************** 


// ******************** Create a node table if node is new ******************* 
if ($unit_is_brand_new) {
    // ----- get the node unit ID, formulate table name
    $OurNewTable_Name = $unit_ID . "_data";
    $OurNewTable_Name = "`$db_name`.`$OurNewTable_Name`";
    $SQL_File = SITE_ROOT_PATH . "/MQTT_Engine_PHP/logger/db/queries/generic_create_table.ChargerData.sql";

    include_once SITE_ROOT_PATH . "/MQTT_Engine_PHP/logger/db/DBKonnekt.php";

    $NewTble_Query = db_konnekt($db_name)->generic_create_table($OurNewTable_Name, $SQL_File);
    echo BR . json_encode($NewTble_Query) . BR;
    $handler_RegisterUnit_resp = $NewTble_Query;
}
// ******************** Create a node table if node is new ******************* 
