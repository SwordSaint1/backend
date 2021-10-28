<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$db = mysqli_connect($servername, $username, $password,'CPMS_db');

// Check connection
if (!$db) {
    die("Connection failed: " . mysqli_connect_error());
}

?>