<?php
if (!isset($site)) {
    $site = $_SERVER['DOCUMENT_ROOT'];
}

// include "enable_errors.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// --------- display all errors --------- 
include_once "$site/error_toggle.php";
// ----------- error display ------------ 

include $_SERVER['DOCUMENT_ROOT'] . "/endpoints/db/DBKonnekt.php";
$db_name = "kiri_entitee";
$table_name = "profiles_sumary";

$name = db_konnekt($db_name)->CleanDBData($_POST['user_name']);
$email = db_konnekt($db_name)->CleanDBData($_POST['user_email']);
$organisation = db_konnekt($db_name)->CleanDBData($_POST['user_company']);
$phone = db_konnekt($db_name)->CleanDBData($_POST['user_phone']);
$password = db_konnekt($db_name)->CleanDBData($_POST['user_password']);

$email_username = explode("@", $email);
$email_username = $email_username[0];
$user_id = "user_" . $email_username . "_" . (bin2hex(random_bytes(6)));

$password = password_hash($password, PASSWORD_DEFAULT);

$insert_arrays = array(
    'user_name' => $name,
    'user_email' => $email,
    'institution_name' => $organisation,
    'user_phone_nu' => $phone,
    'password' => $password,
    'user_id' => $user_id,
    'user_active_state_code' => 10,
);

$regist_Qry = db_konnekt($db_name)->register_user($table_name, $insert_arrays);
echo $regist_Qry;

    // $duplicate = mysqli_query($conn, "select * from h_are where email='$email'");
    // if (mysqli_num_rows($duplicate) > 0) {
    //     echo json_encode(array("statusCode" => 201));
    // } else {
    //     $sql = "INSERT INTO `h_are`( `name`, `email`, `phone`, `password`) 
    // 		VALUES ('$name','$email','$phone', '$password')";
    //     if (mysqli_query($conn, $sql)) {
    //         echo json_encode(array("statusCode" => 200));
    //     } else {
    //         echo json_encode(array("statusCode" => 201));
    //     }
    // }
    // mysqli_close($conn);
