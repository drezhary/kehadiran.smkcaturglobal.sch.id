<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// Jika sudah login, redirect ke halaman kehadiran
if (isset($_SESSION['kode_guru'])) {
    header("Location: ../pages/kehadiran.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .custom-shadow {
            box-shadow: 0 4px 8px rgba(250, 88, 0, 0.83);
            /* Change the color and intensity as needed */
        }
    </style>
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 custom-shadow" style="width: 400px;">
            <!-- Logo dan Judul -->
            <div class="text-center mb-4">
                <img src="assets/logo.jpeg" alt="Logo Aplikasi" class="mb-3" style="width: 100px;">
                <h4 class="fw-bold">Aplikasi Kehadiran Guru</h4>
            </div>

            <!-- Form Login -->
            <form action="process/login_action.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="kode_guru" name="kode_guru" placeholder="Masukkan Kode Guru" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href="loginadmin.php">Login sebagai admin</a>
                <?php if (isset($_GET['error']) && $_GET['error'] == 'true'): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        Kode guru tidak valid.
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>

</html>