<?php
session_start();
$error = '';
include 'koneksi.php'; // Termasuk file koneksi

// Jika sudah login, langsung arahkan ke halaman yang sesuai
if (isset($_SESSION['user'])) {
    // Redirect berdasarkan role
    if ($_SESSION['user']['role'] == 'admin') {
        header('Location: admin_dashboard.php');
        exit();
    } else {
        header('Location: customer_dashboard.php');
        exit();
    }
}

// login.php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek apakah username ada di database
    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('s', $username);  // 's' menandakan tipe data string
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        // Verifikasi password dengan password yang ada di database
        if (password_verify($password, $user['password'])) {
            // Password cocok, buat session untuk user
            $_SESSION['user'] = [
                'username' => $user['username'],
                'role' => $user['role'],
            ];

            // Redirect ke halaman dashboard berdasarkan role
            if ($user['role'] == 'admin') {
                header('Location: admin_dashboard.php');
            } else {
                header('Location: customer_dashboard.php');
            }
            exit();
        } else {
            $error = 'Password salah!';
        }
    } else {
        $error = 'Username tidak ditemukan!';
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Wan Gaming Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .card {
            max-width: 400px;
            width: 100%;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        .card-header {
            text-align: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 0.5rem;
        }
        .btn-primary {
            border-radius: 0.5rem;
        }
    </style>
</head>
<body>

    <div class="card">
        <div class="card-header">
            <h2>Login</h2>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" id="username" name="username" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="mt-3 text-center">Belum punya akun? <a href="register.php">Daftar sekarang</a></p>
    </div>

</body>
</html>
