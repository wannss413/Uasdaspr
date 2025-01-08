<?php
session_start();
include 'koneksi.php'; // Koneksi database

// Verifikasi apakah pengguna sudah login dan memiliki role 'admin'
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Ambil data produk berdasarkan ID
$id = $_GET['id'];
$query = "SELECT * FROM produk WHERE id = $id";
$result = mysqli_query($conn, $query);
$produk = mysqli_fetch_assoc($result);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $nama = $_POST['nama'];
    $harga = $_POST['harga'];

    if ($_FILES['gambar']['name']) {
        $gambar = $_FILES['gambar']['name'];
        $gambar_tmp = $_FILES['gambar']['tmp_name'];
        // Pindahkan gambar baru
        $upload_dir = 'uploads/';
        move_uploaded_file($gambar_tmp, $upload_dir . $gambar);
    } else {
        // Jika gambar tidak diubah, gunakan gambar lama
        $gambar = $produk['gambar'];
    }

    // Update data produk di database
    $query = "UPDATE produk SET nama = '$nama', harga = '$harga', gambar = '$gambar' WHERE id = $id";
    if (mysqli_query($conn, $query)) {
        header("Location: produk.php"); // Redirect ke daftar produk
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Produk - Wan Gaming Shop</title>
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
                    <a class="nav-link" href="#">Kelola Pengguna</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="produk.php">Kelola Produk</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Laporan</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Keluar</a>
                </li>
            </ul>
        </div>
<div class="container mt-4">
    <h2>Update Produk</h2>
    <form action="update_produk.php?id=<?php echo $produk['id']; ?>" method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nama" class="form-label">Nama Produk</label>
            <input type="text" name="nama" id="nama" class="form-control" value="<?php echo $produk['nama']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="harga" class="form-label">Harga</label>
            <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $produk['harga']; ?>" required>
        </div>
        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar Produk (Kosongkan jika tidak ingin mengubah)</label>
            <input type="file" name="gambar" id="gambar" class="form-control">
            <img src="uploads/<?php echo $produk['gambar']; ?>" width="100" class="mt-2">
        </div>
        <button type="submit" class="btn btn-primary">Update Produk</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
</body>
</html>