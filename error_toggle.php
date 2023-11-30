<?php

$site_under_dev = true;

if ($site_under_dev) {
    // --------- display all errors --------- 
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // ------------ error display ------------
}
