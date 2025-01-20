<?php

include 'config/db_connection.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = $_POST['user'];
    $password = $_POST['password'];

    // Validate input
    if (empty($user) || empty($password)) {
        $error = "User dan password wajib diisi.";
    } else {
        // Prepare and execute query
        $stmt = $pdo->prepare("SELECT * FROM admin WHERE user = :user");
        $stmt->bindParam(':user', $user);
        $stmt->execute();
        $admin = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($admin) {
            // Check if the password is hashed or plain text
            if (password_verify($password, $admin['password']) || $password === $admin['password']) {
                // Set session and redirect to admin.html
                $_SESSION['admin_user'] = $admin['user'];
                header("Location: pages/admin.php");
                exit();
            } else {
                $error = "User atau password salah.";
            }
        } else {
            $error = "User atau password salah.";
        }
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
            <form action="loginadmin.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="useradmin" name="user" placeholder="Masukkan username admin" required>
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