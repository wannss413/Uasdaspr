<?php
session_start();

// Cek jika keranjang belanja kosong
if (empty($_SESSION['cart'])) {
    echo "Keranjang belanja Anda kosong!";
    exit();
}

$total = 0;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Wan Gaming Shop</title>
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
    <h2>Keranjang Belanja</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah</th>
                <th>Total</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['cart'] as $id => $item) : ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td>Rp <?php echo number_format($item['price'], 0, ',', '.'); ?></td>
                    <td>
                        <form action="keranjang_action.php?action=update&id=<?php echo $id; ?>" method="POST">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1" class="form-control" style="width: 70px;">
                            <button type="submit" class="btn btn-warning mt-2">Update</button>
                        </form>
                    </td>
                    <td>Rp <?php echo number_format($item['price'] * $item['quantity'], 0, ',', '.'); ?></td>
                    <td>
                        <a href="keranjang_action.php?action=remove&id=<?php echo $id; ?>" class="btn btn-danger">Hapus</a>
                    </td>
                </tr>
                <?php $total += $item['price'] * $item['quantity']; ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Total Belanja: Rp <?php echo number_format($total, 0, ',', '.'); ?></h4>
    <a href="checkout.php" class="btn btn-primary">Lanjutkan Pembelian</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>
