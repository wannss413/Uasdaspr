<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Verifikasi apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil ID produk dari URL
$id = $_GET['id'];

// Hapus produk dari database
$query = "DELETE FROM produk WHERE id = $id";
if (mysqli_query($conn, $query)) {
    header("Location: produk.php"); // Redirect ke daftar produk
    exit();
} else {
    echo "Error: " . mysqli_error($koneksi);
}
?>
