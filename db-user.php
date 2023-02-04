<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

$DB_host = "localhost";
$DB_user = "root";
$DB_pass = "root";
$DB_name = "nordech_challenge";

try {
    $DB_con = new PDO("mysql:host={$DB_host};dbname={$DB_name}",$DB_user,$DB_pass);
    $DB_con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     //echo 'Connected';
}catch(PDOException $e) { 
    echo 'Connection did not work out!';
    return false;
}


include_once 'class.user.php';
$account = new USER($DB_con);
$error = false;