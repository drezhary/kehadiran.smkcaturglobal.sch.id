<?php
$host = 'localhost';
$dbname = 'smkcaturglobalsc_kehadiran';
$username = 'smkcatur_admin';
$password = 'SMKC4turGl0b4l#314';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
