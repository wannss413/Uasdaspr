<?php
// admin_dashboard.php
session_start();
include 'koneksi.php';

// Verifikasi apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php"); // Jika bukan admin, arahkan ke login
    exit();
}

$username = $_SESSION['user']['username']; // Ambil username dari session

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Admin - Wan Gaming Shop</title>

    <!-- Link ke Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Custom CSS -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
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
                </li>
                
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>

        <!-- Content -->
        <!-- Content -->
    <div class="container mt-4 col-md-9">
        <h2>Dashboard Admin</h2>

        <!-- Ringkasan Statistik -->
       
        <!-- Produk Terbaru -->
        <section class="mt-4">
            <h4>Produk Terbaru</h4>
            <div class="row">
                <?php
                $query_produk_terbaru = "SELECT * FROM produk ORDER BY id DESC LIMIT 5"; // Menampilkan produk terbaru
                $result_produk_terbaru = mysqli_query($conn, $query_produk_terbaru);
                while ($produk = mysqli_fetch_assoc($result_produk_terbaru)):
                ?>
                    <div class="col-md-3">
                        <div class="card">
                            <img src="uploads/<?php echo $produk['gambar']; ?>" class="card-img-top" alt="Produk">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $produk['nama']; ?></h5>
                                <p class="card-text">Rp <?php echo number_format($produk['harga'], 0, ',', '.'); ?></p>
                                <a href="detail_produk.php?id=<?php echo $produk['id']; ?>" class="btn btn-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </section>
    </div>
</div>

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
