<?php

$host ="localhost";
$username ="root";
$dbname ="employee_management";
$password ="password";

$conn = new mysqli($host,$username,$password,$dbname);

if($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}

// echo "Connected successfully";
$conn->set_charset("utf8");


?>

