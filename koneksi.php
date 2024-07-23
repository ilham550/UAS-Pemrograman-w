<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "ilham";

// Membuat koneksi
$koneksi = new mysqli($host, $user, $pass, $db);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}
?>