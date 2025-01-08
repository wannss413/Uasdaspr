<?php
session_start();
include 'koneksi.php'; // Koneksi ke database

// Menambahkan produk ke dalam keranjang belanja
if (isset($_GET['action']) && $_GET['action'] == 'add') {
    $id = $_GET['id'];
    $query = "SELECT * FROM produk WHERE id = $id";
    $result = mysqli_query($conn, $query);
    $produk = mysqli_fetch_assoc($result);

    $item = [
        'id' => $produk['id'],
        'name' => $produk['nama'],
        'price' => $produk['harga'],
        'quantity' => 1 // Jumlah default saat ditambahkan
    ];

    // Jika produk sudah ada dalam keranjang, jumlahnya ditambah
    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += 1;
    } else {
        $_SESSION['cart'][$id] = $item;
    }

    // Menyimpan pesan ke dalam session untuk alert
    $_SESSION['message'] = 'Produk telah ditambahkan ke keranjang!';

    // Redirect kembali ke beranda_customer.php
    header("Location: beranda_customer.php");
    exit();
}

// Memperbarui jumlah produk dalam keranjang
if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $id = $_GET['id'];
    $quantity = $_POST['quantity'];

    if ($quantity < 1) {
        $quantity = 1; // Pastikan jumlah minimal 1
    }

    $_SESSION['cart'][$id]['quantity'] = $quantity;

    header("Location: keranjang.php"); // Redirect ke halaman keranjang
    exit();
}

// Menghapus produk dari keranjang
if (isset($_GET['action']) && $_GET['action'] == 'remove') {
    $id = $_GET['id'];

    unset($_SESSION['cart'][$id]); // Menghapus produk dari keranjang

    header("Location: keranjang.php"); // Redirect ke halaman keranjang
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Customer - Wan Gaming Shop</title>
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
                    <a class="nav-link" href="#">Profil Saya</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Pesanan Saya</a>
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
    <h2>Produk Wan Gaming Shop</h2>
    <div class="row">
        <?php
        // Query untuk menampilkan produk
        $query = "SELECT * FROM produk";
        $result = mysqli_query($conn, $query);

        while ($produk = mysqli_fetch_assoc($result)):
        ?>
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
