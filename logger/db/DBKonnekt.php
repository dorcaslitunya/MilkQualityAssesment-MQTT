<?php

function db_konnekt($db_name)
{
    // $db = "simatech_system";
    include_once dirname(__FILE__) . '/DBKonnectClass.php';

    $db_conn = array(
        'host' => 'localhost',
        'database' => $db_name,
        'user' => 'MrMosquitto',
        'pass' => 'u78ejywn49@9iHl@6yjYu78e'
    );

    $db = new db_konnekt_class($db_conn);
    return $db;
}
