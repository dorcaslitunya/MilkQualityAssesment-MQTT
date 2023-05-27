<?php

// ------------ Predefine root path ---------- 
defined('SITE_ROOT_PATH') or define('SITE_ROOT_PATH', '/var/www/html/bme.kiriev.com/public_html');
// ----------- /Predefine root path ----------

// --------- enable display all errors --------- 
include_once SITE_ROOT_PATH . "/error_toggle.php";
// --------- /enable display all errors --------- 

/*
    $insert_arrays = array
    (
        'mach_UID' => "16_dig_GSM_IMEI",
        'tx_UID'=> '123445'
    );
    
    Call it like this:
    $db = new SimpleDBClass("host_name", "user_id", "password","database")
    $Qry = $db->register_user('table',$insert_arrays);

    If ran successfully, it will return an array
*/

foreach (array_keys($dayta_array) as $key) {
    $columns[] = "$key";
    $values[] = "'" .  $dayta_array[$key] . "'";
}
//Get columns and values
$columns = implode(",", $columns);
$values = implode(",", $values);

$sql_query = "INSERT INTO $table_name ($columns) VALUES ($values)";
// echo "sql is -> " . $sql_query;

$con =  $this->isConn;

// Check connection
if (!$con) {
    $generic_insert_resp['succ'] = 0;
    $generic_insert_resp['code'] = mysqli_errno($con);
    $generic_insert_resp['info'] = mysqli_error($con);

    // die("Connection failed in query function - " . mysqli_connect_error());
    die(json_encode($generic_insert_resp));
} else if ($con) {
    // echo "con, ready to query";
    try {
        $q = $con->query($sql_query);
        if (mysqli_errno($con) == 1062) {
            // echo BR . "user already exists" . BR;
            $generic_insert_resp['succ'] = 1;
            $generic_insert_resp['code'] = 11;
            $generic_insert_resp['info'] = "exsts";
        } else {
            $generic_insert_resp['succ'] = 1;
            $generic_insert_resp['code'] = 1;
            $generic_insert_resp['info'] = "rgst";
        }
    } catch (exception $e) {
        //code to handle the exception
        // echo "error";
        // echo $e->getMessage();
        $generic_insert_resp['succ'] = 0;
        $generic_insert_resp['code'] = mysqli_errno($con);
        $generic_insert_resp['info'] =  mysqli_error($con);

        // echo BR . "----- registered .. or not -----" . BR;
    }
    $con->close();
}
