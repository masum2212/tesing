<?php
$servername = "localhost";
$db_username = "root";
$password = "";
$dbname = "tracking_system_db";


$conn = new mysqli(
    $servername,
    $db_username,
    $password,
    $dbname
);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$servername_qc = "192.168.200.15";
$db_username_qc = "readonly";
$password_qc = "readonly#123";
$dbname_qc = "report_qc_management";


$conn_qc = new mysqli(
    $servername_qc,
    $db_username_qc,
    $password_qc,
    $dbname_qc
);

if ($conn_qc->connect_error) {
    die("Connection failed: " . $conn_qc->connect_error);
}
