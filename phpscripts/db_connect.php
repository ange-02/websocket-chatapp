<?php

$host = "localhost:3306";
$username = "root";
$password = "";
$database_in_use = "schoolproject";

$mysqli = new mysqli($host, $username, $password, $database_in_use);
if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
} 
?>