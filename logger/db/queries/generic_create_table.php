<?php
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/bme.kiriev.com/public_html');

// --------- display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// ----------- error display ------------ 


// $SQL_query = file_get_contents(__DIR__ . '/generic_create_table.ChargerData.sql');
$SQL_query = file_get_contents($SQL_File);
// replace table name variable
$SQL_query = str_replace("NewTableName", $table_name, $SQL_query);
echo BR . "SQL_query is now -> " . $SQL_query;

$con =  $this->isConn;

// Check connection
if (!$con) {
    $generic_create_table_resp['succ'] = 0;
    $generic_create_table_resp['code'] = mysqli_errno($con);
    $generic_create_table_resp['info'] = mysqli_error($con);

    // die("Connection failed in query function - " . mysqli_connect_error());
    die(json_encode($generic_create_table_resp));
} else if ($con) {
    // echo "con, ready to query";
    try {
        if ($q = $con->query($SQL_query)) {
            $generic_create_table_resp['succ'] = 1;
            $generic_create_table_resp['code'] = 1;
            $generic_create_table_resp['info'] = "registered";
        } else {
            $generic_create_table_resp['succ'] = 0;
            $generic_create_table_resp['code'] = 0;
            $generic_create_table_resp['tble'] = 0;
            $generic_create_table_resp['info'] = "erro creating data table for this unit";
        }
    } catch (exception $e) {
        //code to handle the exception
        // echo "error";
        // echo $e->getMessage();
        $generic_create_table_resp['succ'] = 0;
        $generic_create_table_resp['code'] = mysqli_errno($con);
        $generic_create_table_resp['info'] =  mysqli_error($con);
        $generic_create_table_resp['tble'] = 0;
        $generic_create_table_resp['info'] = "erro creating data table for this unit";

        // echo BR . "----- registered .. or not -----" . BR;

    }
    $con->close();
}
