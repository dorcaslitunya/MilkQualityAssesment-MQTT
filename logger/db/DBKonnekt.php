<?php

function db_konnekt($db_name)
{
    include_once dirname(__FILE__) . '/DBKonnectClass.php';

    $db_conn = array(
        'host' => 'localhost',
        'database' => $db_name,
        'user' => 'milk',
        'pass' => 'home'
    );

    $db = new db_konnekt_class($db_conn);
    return $db;
}
