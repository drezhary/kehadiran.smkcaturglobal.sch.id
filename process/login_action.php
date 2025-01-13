<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require '../config/db_connection.php';

// Memastikan request method dari form login adalah POST dan kodeguru sudah diisi
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['kode_guru'])) {
    $kodeguru = $_POST['kode_guru'];

    // Query ke database memeriksa kode_guru
    $stmt = $pdo->prepare('SELECT * FROM guru WHERE kode_guru = :kode_guru');
    $stmt->bindParam(':kode_guru', $kodeguru, PDO::PARAM_STR);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $guru = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION['kode_guru'] = $guru['kode_guru'];
        $_SESSION['nama_guru'] = $guru['nama_guru'];

        // Redirect ke halaman kehadiran
        header('Location: ../pages/kehadiran.php');
        exit();
    } else {
        // Redirect kembali ke halaman login jika kode guru tidak valid
        header('Location: index.php?error=true');
        exit();
    }
} else {
    // Jika form tidak disubmit, kembali ke login
    header('Location: ../index.php');
    exit();
}
