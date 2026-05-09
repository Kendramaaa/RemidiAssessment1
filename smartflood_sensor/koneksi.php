<?php
$conn = mysqli_connect("localhost", "root", "", "smartflood_sensor");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

session_start();
?>