<?php
require '../config/db_connection.php';

// Ambil kata kunci pencarian dari request
$query = isset($_GET['query']) ? $_GET['query'] : '';

// Query SQL untuk mencari data berdasarkan nama guru
$sql = "SELECT guru.nama_guru, kehadiran.tanggal, kehadiran.waktu_hadir, kehadiran.status, kehadiran.foto_hadir 
        FROM guru 
        INNER JOIN kehadiran ON guru.kode_guru = kehadiran.kode_guru 
        WHERE guru.nama_guru LIKE :query
        ORDER BY kehadiran.tanggal DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute(['query' => '%' . $query . '%']);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Kembalikan hasil dalam format JSON
header('Content-Type: application/json');
echo json_encode($results);
