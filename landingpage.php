<?php
// index.php
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wan Gaming Shop</title>

    <!-- Link ke Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Optional: Custom CSS for further customization -->
    <link rel="stylesheet" href="styles.css">
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Header -->
    <header class="bg-dark text-white py-3">
        <div class="container d-flex justify-content-between align-items-center">
            <div class="logo fs-4">Wan Gaming Shop</div>
            <nav>
                <a href="#" class="text-white mx-2">Home</a>
                <a href="#" class="text-white mx-2">Produk</a>
                
        </div>
    </header>

    <!-- Hero Section -->
    <section class="hero bg-primary text-white text-center py-5 min-vh-50 d-flex justify-content-center align-items-center">
        <div class="container">
            <h1 class="display-4 fw-bold mb-4">Temukan Perlengkapan Gaming Terbaik di Wan Gaming Shop!</h1>
            <a href="login.php" class="btn btn-light btn-lg mt-4">
                <img src="https://img.icons8.com/ios/50/ffffff/login-rounded-right.png" alt="Get Started" class="me-2">
                <span>Get Started</span>
            </a>
        </div>
    </section>

    <!-- Main Content (Optional) -->
    <section class="container text-center py-5">
        <h2>Jelajahi Produk Kami</h2>
        <p>Temukan berbagai perlengkapan gaming terbaik yang kami tawarkan. Kunjungi produk kami untuk melihat lebih banyak!</p>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <p>&copy; 2025 Wan Gaming Shop</p>
            <div>
                <a href="#" class="text-white mx-2">Facebook</a>
                <a href="#" class="text-white mx-2">Instagram</a>
                <a href="#" class="text-white mx-2">Twitter</a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS (Optional for interactive features) -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>

</body>
</html>
