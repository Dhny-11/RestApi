<?php
$host = "localhost";
$username = "root";
$password = "";
$db = "db_market";
$koneksi = mysqli_connect($host, $username, $password, $db);
if (!$koneksi) {
    die("Koneksi ke database gagal");
}
