<?php
$server = "DESKTOP-6FJ7TC2\SQLEXPRESS";
$connection = array(
    "Database" => "student",
    "Uid" => "sa",
    "PWD" => "12345"
);

$con = sqlsrv_connect($server, $connection); //sqlsrv_connect : connect to Microsoft SQL Server
if($con) {
// echo "Connection established";
} else {
    "Error";
}
?>      