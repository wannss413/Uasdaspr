<?php
// customer_dashboard.php
session_start();
include 'koneksi.php';
// Verifikasi apakah pengguna sudah login dan memiliki role 'customer'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'customer') {
    header("Location: login.php"); // Jika bukan customer, arahkan ke login
    exit();
}
$query = "SELECT * FROM produk ORDER BY id DESC"; // Menampilkan produk terbaru terlebih dahulu
$result = mysqli_query($conn, $query);
$username = $_SESSION['user']['username'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Customer - Wan Gaming Shop</title>

    <!-- Link ke Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
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

        <!-- Content -->
        <div class="col-md-9 col-lg-10 p-4">
            <h2>Selamat Datang, <?php echo htmlspecialchars($username); ?>!</h2>
            <p>Anda sedang berada di dashboard customer.</p>

            
            <!-- Produk Terbaru yang Ditambahkan oleh Admin -->
<section id="produk" class="container mt-5">
    <h2 class="mb-4">Produk Terbaru</h2>
    <div class="row">
        <?php while ($produk = mysqli_fetch_assoc($result)): ?>
            <div class="col-md-4">
                <div class="card">
                    <img src="uploads/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="Produk">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                        <p class="card-text">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                        
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p>&copy; 2025 Wan Gaming Shop</p>
        </div>
    </footer>

    <!-- Bootstrap 5 JS (Optional for interactive features) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
