<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Periksa apakah ada ID transaksi yang dikirimkan
if (!isset($_GET['id'])) {
    header("Location: pesanan_customer.php"); // Jika tidak ada ID, redirect ke riwayat pesanan
    exit();
}

$transaksi_id = $_GET['id'];

// Ambil detail transaksi
$query_transaksi = "SELECT * FROM transaksi WHERE id = $transaksi_id";
$result_transaksi = mysqli_query($conn, $query_transaksi);
$transaksi = mysqli_fetch_assoc($result_transaksi);

// Jika transaksi tidak ditemukan, redirect ke riwayat pesanan
if (!$transaksi) {
    header("Location: pesanan_customer.php");
    exit();
}

// Ambil detail produk dalam transaksi
$query_detail = "SELECT dp.*, p.nama, p.harga FROM detail_transaksi dp
                 JOIN produk p ON dp.produk_id = p.id
                 WHERE dp.transaksi_id = $transaksi_id";
$result_detail = mysqli_query($conn, $query_detail);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pesanan - Wan Gaming Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="bg-dark text-white py-3">
    <div class="container">
        <div class="logo fs-4">Wan Gaming Shop - Detail Pesanan</div>
    </div>
</header>

<div class="container mt-4">
    <h2>Detail Pesanan</h2>
    
    <!-- Menampilkan informasi transaksi -->
    <p><strong>Tanggal:</strong> <?php echo date("d-m-Y H:i", strtotime($transaksi['tanggal'])); ?></p>
    <p><strong>Total Harga:</strong> Rp <?php echo number_format($transaksi['total_harga'], 0, ',', '.'); ?></p>
    <p><strong>Status:</strong> 
        <?php
        if ($transaksi['status'] == 'pending') {
            echo "<span class='badge bg-warning'>Menunggu Pembayaran</span>";
        } elseif ($transaksi['status'] == 'paid') {
            echo "<span class='badge bg-success'>Dibayar</span>";
        } else {
            echo "<span class='badge bg-danger'>Dibatalkan</span>";
        }
        ?>
    </p>

    <h4>Detail Produk</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($item = mysqli_fetch_assoc($result_detail)): ?>
                <tr>
                    <td><?php echo $item['nama']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rp <?php echo number_format($item['harga'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <a href="pesanan_customer.php" class="btn btn-secondary">Kembali ke Riwayat Pesanan</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
