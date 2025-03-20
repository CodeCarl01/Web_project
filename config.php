<?php
$host = "localhost";
$db_name = "fintech"; 
$db_user = "root";
$db_pass = "root";

$dsn = "mysql:host=$host;dbname=$db_name;charset=utf8mb4";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];
?>
