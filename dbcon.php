<?php

date_default_timezone_set('Asia/Manila');


$currentDate=date('m/d/Y');
$currentTime=date('h:i:s A');

$date_mm=date('m');
$date_dd=date('d');
$date_yyyy=date('Y');
    
$host = 'localhost';
$db   = 'stc_logkeeper';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];
try {
     $conn = new PDO($dsn, $user, $pass, $options);
     
} catch (PDOException $e) {
     throw new PDOException($e->getMessage(), (int)$e->getCode());
     
}

$max_cap=500;

?>
 
