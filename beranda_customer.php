<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Mengambil semua produk yang terdaftar di database
$query = "SELECT * FROM produk";
$result = mysqli_query($conn, $query);

// Inisialisasi keranjang belanja jika belum ada
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wan Gaming Shop - Beranda Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="bg-dark text-white py-3">
        <div class="container">
            <div class="logo fs-4">Wan Gaming Shop - Dashboard Customer</div>
        </div>
    </header>

    <!-- Sidebar & Content -->
    <div class="container-fluid d-flex">
        <!-- Sidebar -->
        <div class="col-md-3 col-lg-2 bg-light p-4">
            <h4>Customer Menu</h4>
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link active" href="customer_dashboard.php">Beranda</a>
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="pesanan_customer.php">Pesanan Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="beranda_customer.php">Produk Tersedia</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
<div class="container mt-4">
    <h2>Selamat Datang di Wan Gaming Shop</h2>
    <a href="keranjang.php" class="btn btn-primary mb-3">Lihat Keranjang Belanja</a>

    <div class="row">
        <?php while ($produk = mysqli_fetch_assoc($result)) : ?>
            <div class="col-md-4 mb-4">
                <div class="card">
                    <img src="uploads/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="<?php echo $produk['nama']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                        <p class="card-text">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                        <a href="keranjang_action.php?action=add&id=<?php echo $produk['id']; ?>" class="btn btn-success">Tambah ke Keranjang</a>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
