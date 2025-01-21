<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require 'config/db_connection.php';

// Proses login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = $_POST['username'] ?? '';
    $inputPassword = $_POST['password'] ?? '';

    if (!empty($inputUsername) && !empty($inputPassword)) {
        // Query untuk mendapatkan data pengguna
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->execute(['username' => $inputUsername]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($inputPassword, $user['password'])) {
            // Login berhasil
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: pages/admin.php");
            exit();
        } else {
            $error = "Username atau password salah.";
        }
    } else {
        $error = "Harap isi semua kolom.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div class="card p-4 shadow-lg" style="width: 400px;">
            <!-- Logo dan Judul -->
            <div class="text-center mb-4">
                <img src="assets/logo.jpeg" alt="Logo Aplikasi" class="mb-3" style="width: 100px;">
                <h4 class="fw-bold">Aplikasi Admin Kehadiran Guru</h4>
            </div>

            <!-- Form Login -->
            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="user" name="username" placeholder="Masukkan username admin" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password admin" required>
                </div>
                <button type="submit" class="btn btn-primary w-100">Login</button>
                <a href="index.php">Login sebagai guru</a>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger mt-3" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</body>

</html>