<?php
$host = 'localhost';  // Ganti dengan host MySQL Anda
$username = 'root';   // Ganti dengan username MySQL Anda
$password = '';       // Ganti dengan password MySQL Anda
$dbname = 'wan'; // Ganti dengan nama database Anda

// Membuat koneksi
$conn = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}
?>
