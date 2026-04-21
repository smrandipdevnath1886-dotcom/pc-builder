<?php
// connect.php

$server = "localhost";
$user = "root";
$password = ""; // XAMPP এ default empty থাকে
$db = "pc_builder";

$conn = mysqli_connect($server, $user, $password, $db);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");
?>