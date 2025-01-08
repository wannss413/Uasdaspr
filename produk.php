<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Verifikasi apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data produk dari database
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Produk - Wan Gaming Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-dark text-white py-3">
        <div class="container">
            <div class="logo fs-4">Wan Gaming Shop - Dashboard Admin</div>
        </div>
    </header>

    <!-- Sidebar & Content -->
    <div class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-light p-4">
            <h4>Admin Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="admin_dashboard.php">Beranda</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="produk.php">Kelola Produk</a>
                
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
<div class="container mt-4">
    <h2>Daftar Produk</h2>
    <a href="tambah_produk.php" class="btn btn-primary mb-3">Tambah Produk</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Gambar</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($produk = mysqli_fetch_assoc($result)) : ?>
                <tr>
                    <td><?php echo $produk['id']; ?></td>
                    <td><?php echo $produk['nama']; ?></td>
                    <td>Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></td>
                    <td><img src="uploads/<?php echo $produk['gambar']; ?>" width="50"></td>
                    <td>
                        <a href="update_produk.php?id=<?php echo $produk['id']; ?>" class="btn btn-warning">Edit</a>
                        <a href="hapus_produk.php?id=<?php echo $produk['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
