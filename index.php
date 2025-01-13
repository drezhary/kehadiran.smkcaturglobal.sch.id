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
</head>

<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <?php if (isset($_GET['error']) && $_GET['error'] == 'true'): ?>
            <div class="alert alert-danger" role="alert">
                Kode guru tidak valid.
            </div>
        <?php endif; ?>
        <form action="process/login_action.php" method="POST">
            <div class="mb-3">
                <label for="kode_guru" class="form-label">Kode Guru</label>
                <input type="text" class="form-control" id="kode_guru" name="kode_guru" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</body>

</html>