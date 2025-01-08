<?php
session_start();
session_destroy(); // Hapus sesi saat logout
header("Location: login.php"); // Arahkan kembali ke halaman login
exit();
?>