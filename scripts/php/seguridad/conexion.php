<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "fichajedb";

$conexion = mysqli_connect($host, $user, $password, $db);

// Check connection
if (!$conexion) {
    die("Connection failed: " . mysqli_connect_error());
}

// Optional: Set character set
mysqli_set_charset($conexion, "utf8");

// Optionally, you can print a success message for debugging
// This line can be removed or commented out in a production environment
//print("Connected successfully");
