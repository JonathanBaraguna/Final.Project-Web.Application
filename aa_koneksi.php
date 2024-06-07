<?php
$host = "localhost"; // Ganti sesuai dengan host database Anda
$user = "root"; // Ganti sesuai dengan username database Anda
$password = ""; // Ganti sesuai dengan password database Anda
$database = "login_user"; // Ganti sesuai dengan nama database Anda

$mysqli = new mysqli($host, $user, $password, $database);

if ($mysqli->connect_errno) {
    echo "Gagal terhubung ke MySQL: " . $mysqli->connect_error;
    exit();
}
?>