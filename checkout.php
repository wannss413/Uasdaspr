<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Jika keranjang kosong, redirect ke halaman beranda
if (empty($_SESSION['cart'])) {
    header("Location: beranda_customer.php");
    exit();
}

// Menyusun daftar produk dalam keranjang
$cart_items = $_SESSION['cart'];
$total_price = 0; // Total harga yang akan dihitung

foreach ($cart_items as $item) {
    $total_price += $item['price'] * $item['quantity'];
}

// Proses checkout
if (isset($_POST['checkout'])) {
    // Menyimpan data order ke database
    $username = $_SESSION['user']['username']; // Asumsikan user sudah login
    $total_price = $_POST['total_price']; // Harga total dari form checkout

    // Simpan data transaksi ke tabel transaksi
    $query = "INSERT INTO transaksi (username, total_harga, status) VALUES ('$username', '$total_price', 'pending')";
    $result = mysqli_query($conn, $query);

    if ($result) {
        // Ambil ID transaksi yang baru saja dimasukkan
        $transaksi_id = mysqli_insert_id($conn);
    
        // Simpan detail produk yang dibeli ke tabel detail_transaksi
        foreach ($cart_items as $item) {
            $produk_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
    
            // Simpan detail transaksi ke database
            $query_detail = "INSERT INTO detail_transaksi (transaksi_id, produk_id, quantity, harga) 
                             VALUES ($transaksi_id, $produk_id, $quantity, $price)";
            mysqli_query($conn, $query_detail);
    
            // Update jumlah produk yang terjual di tabel produk
            $query_update_produk = "UPDATE produk SET jumlah_terjual = jumlah_terjual + $quantity WHERE id = $produk_id";
            mysqli_query($conn, $query_update_produk);
        }
    
        // Update status transaksi menjadi 'paid' setelah pembayaran berhasil
        $query_update_status = "UPDATE transaksi SET status = 'paid' WHERE id = $transaksi_id";
        mysqli_query($conn, $query_update_status);
    
        // Update total pesanan dan pendapatan admin
        $query_update_admin = "UPDATE admin_dashboard SET total_pesanan = total_pesanan + 1, 
                                                    pendapatan = pendapatan + $total_price";
        mysqli_query($conn, $query_update_admin);
    
        // Kosongkan keranjang setelah checkout selesai
        unset($_SESSION['cart']);
    
        // Redirect ke halaman konfirmasi
        $_SESSION['message'] = 'Pembelian Anda berhasil! Silakan tunggu konfirmasi.';
        header("Location: konfirmasi.php");
        exit();
    }
    
    
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout - Wan Gaming Shop</title>
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
<!-- Menampilkan alert jika ada pesan dalam session -->
<?php if (isset($_SESSION['message'])): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['message']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php unset($_SESSION['message']); // Hapus pesan setelah ditampilkan ?>
<?php endif; ?>

<div class="container mt-4">
    <h2>Checkout</h2>

    <!-- Menampilkan daftar produk dalam keranjang -->
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
            <?php
            $cart_items = $_SESSION['cart'];
            $total_price = 0;

            foreach ($cart_items as $item) {
                $total_price += $item['price'] * $item['quantity'];
            ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <h4>Total Harga: Rp <?php echo number_format($total_price, 0, ',', '.'); ?></h4>

    <!-- Form untuk mengonfirmasi pembelian -->
    <form action="checkout.php" method="POST">
        <input type="hidden" name="total_price" value="<?php echo $total_price; ?>">
        <button type="submit" name="checkout" class="btn btn-primary">Proses Pembayaran</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
