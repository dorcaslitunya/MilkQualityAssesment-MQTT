<?php

$payload = array();
$payload['code'] = 333; // get the list of codes
// $payload['load']['num'] = '0729614745';
$payload['load']['amt'] = 400; // Full integer
$payload['load']['dur'] = 60; // How do we come up with duration
$payload['load']['acc'] = "KIRIA12"; // Standard of account names and units

echo json_encode($payload);
