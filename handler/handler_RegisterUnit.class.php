<?php

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/bme.kiriev.com/public_html');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// --------- /enable display all errors --------- 


class Unit_RegisterUpdateHbit
{
    // Properties
    // public $serial;

    // Methods
    function Unit_Register($db_name, $table_name, $payload = array())
    {
        // include DB instance file
        include_once SITE_ROOT_PATH . "/MQTT_Engine_PHP/logger/db/DBKonnekt.php";
        // Instanciate the DB class instance
        $db_inst = db_konnekt($db_name);

        // Required vars to be existing 
        $table_name = "`$db_name`.`$table_name`";
        $unit_serial = $db_inst->CleanDBData($payload['unit_serial']);
        $unit_group = $db_inst->CleanDBData($payload['unit_group']);
        $unit_category = $db_inst->CleanDBData($payload['unit_category']);
        $unit_ID = $db_inst->CleanDBData($payload['unit_ID']);

        $insert_arrays = array(
            'unit_serial' => $unit_serial,
            'unit_id' => $unit_ID,
            'unit_group_name' => $unit_group,
            'unit_category_name' => $unit_category,
        );

        $Unit_Register_resp = $db_inst->generic_insert_data($table_name, $insert_arrays);
        return $Unit_Register_resp;
        // echo BR . "INSERT RESPONSE -> " . json_encode($regist_Qry) . BR;
    }
}
