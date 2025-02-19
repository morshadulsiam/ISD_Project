<?php

$sName = "localhost";
$uName = "root";
$pass = "";
$db_name = "auth_db";

try {
    $conn = new PDO("mysql:host=$sName;dbname=$db_name", $uName, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>