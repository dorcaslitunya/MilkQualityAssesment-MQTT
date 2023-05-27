<?php
if (!isset($site)) {
    $site = $_SERVER['DOCUMENT_ROOT'];
}

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --------- display all errors --------- 
include_once "$site/error_toggle.php";
// ----------- error display ------------ 

include $_SERVER['DOCUMENT_ROOT'] . "/endpoints/db/DBKonnekt.php";
$db_name = "kiri_entitee";
$table_name = "profiles_sumary";

$email = db_konnekt($db_name)->CleanDBData($_POST['email']);
$password = db_konnekt($db_name)->CleanDBData($_POST['password']);

$SQLStatement = "SELECT * FROM profiles_sumary";
$where_clause = "WHERE user_email='$email'";
$keys = $password;

$select_qry = db_konnekt($db_name)->select_user($SQLStatement, $where_clause, $keys);

if ($select_qry['success'] == 1) {
    $select_qry['sess'] = 4;
    $select_qry['group'] = $select_qry['group'];
    $_SESSION['email'] = $select_qry['email'];
    $_SESSION['name'] = $select_qry['name'];
    $_SESSION['status'] = $select_qry['active'];
    $_SESSION['group'] = $select_qry['group'];
    $_SESSION['role'] = $select_qry['role'];
    $_SESSION['site'] = 0;
}

echo (json_encode($select_qry));
