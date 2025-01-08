<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Periksa apakah pengguna sudah login
if (!isset($_SESSION['user'])) {
    header("Location: login.php"); // Jika belum login, arahkan ke halaman login
    exit();
}

// Ambil username dari session
$username = $_SESSION['user']['username'];

// Ambil daftar transaksi yang dibuat oleh customer berdasarkan username
$query = "SELECT * FROM transaksi WHERE username = '$username' ORDER BY tanggal DESC";
$result = mysqli_query($conn, $query);

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan - Wan Gaming Shop</title>
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
<!-- Menampilkan header -->
<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="logo fs-4">Wan Gaming Shop - Riwayat Pesanan</div>
    </div>
</header>

<div class="container mt-4">
    <h2>Riwayat Pesanan Anda</h2>

    <?php if (mysqli_num_rows($result) == 0): ?>
        <p>Anda belum memiliki pesanan.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                while ($transaksi = mysqli_fetch_assoc($result)):
                    // Ambil detail transaksi untuk setiap transaksi
                    $transaksi_id = $transaksi['id'];
                    $status = $transaksi['status'];
                    $total_harga = number_format($transaksi['total_harga'], 0, ',', '.');
                    $tanggal = date("d-m-Y H:i", strtotime($transaksi['tanggal']));

                    // Ambil detail produk untuk transaksi
                    $query_detail = "SELECT * FROM detail_transaksi WHERE transaksi_id = $transaksi_id";
                    $result_detail = mysqli_query($conn, $query_detail);
                ?>
                    <tr>
                        <td><?php echo $no++; ?></td>
                        <td><?php echo $tanggal; ?></td>
                        <td>Rp <?php echo $total_harga; ?></td>
                        <td>
                            <?php
                            // Menampilkan status transaksi
                            if ($status == 'pending') {
                                echo "<span class='badge bg-warning'>Menunggu Pembayaran</span>";
                            } elseif ($status == 'paid') {
                                echo "<span class='badge bg-success'>Dibayar</span>";
                            } else {
                                echo "<span class='badge bg-danger'>Dibatalkan</span>";
                            }
                            ?>
                        </td>
                        <td><a href="detail_pesanan.php?id=<?php echo $transaksi_id; ?>" class="btn btn-info btn-sm">Lihat Detail</a></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
