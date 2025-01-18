<?php
// Aktifkan error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
date_default_timezone_set("Asia/Bangkok");

session_start();
require '../config/db_connection.php';

// Validasi jika form dikirimkan

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Ambil data dari form
    $kode_guru = $_SESSION['kode_guru'];
    $tanggal = date('Y-m-d'); // format tanggal: tahun - bulan - tanggal
    $waktu = date('H:i:s'); // waktu saat ini
    $status = 'Hadir'; // Default status kehadiran
    $foto_hadir = null;
    var_dump($kode_guru, $tanggal, $waktu, $status);

    // validasi jika data kode guru kosong
    if (!$kode_guru) {
        die("Kode guru wajib diisi");
    }

    // Proses upload foto
    if (isset($_FILES['foto_hadir']) && $_FILES['foto_hadir']['error'] === UPLOAD_ERR_OK) {
        $fotoTmpName = $_FILES['foto_hadir']['tmp_name'];
        $fotoName = $_FILES['foto_hadir']['name'];
        $fotosize = $_FILES['foto_hadir']['size'];
        $fotoError = $_FILES['foto_hadir']['error'];
        $fotoType = $_FILES['foto_hadir']['type'];

        // Debug : cek informasi file
        var_dump($fotoTmpName, $fotoName, $fotosize, $fotoError, $fotoType);

        // validasi jika file bukan gambar
        $fotoExt = strtolower(pathinfo($fotoName, PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($fotoExt, $allowedExt)) {
            die("Foto kehadiran harus berupa gambar");
        }

        // // validasi jika ukuran file lebih dari 2MB
        // if ($fotosize > 2 * 1024 * 1024) {
        //     die("Ukuran foto kehadiran maksimal 2MB");
        // }

        // Tentukan lokasi penyimpanan foto
        $fotoNewName = uniqid('foto_', true) . '.' . $fotoExt;
        $fotoUploadPath = '../assets/uploads/' . $fotoNewName;

        // Debug  cek path file

        var_dump($fotoUploadPath);
        // Pindahkan file ke folder uploads
        if (!move_uploaded_file($fotoTmpName, $fotoUploadPath)) {
            die("Gagal mengunggah foto kehadiran");
        }

        // Simpan path foto ke database
        $foto_hadir = $fotoUploadPath;
    } else {
        var_dump($_FILES['foto_hadir']);
        die("Foto kehadiran wajib diunggah");
    }
    // Masukkan data ke tabel kehadiran
    $query = "INSERT INTO kehadiran (kode_guru, tanggal, waktu_hadir, status, foto_hadir) 
            VALUES (?,?,?,?,?)";
    $stmt = $pdo->prepare($query);
    var_dump($stmt);

    if ($stmt) {
        // Jika guru hadir sebelum jam 07.30
        $stmt->bindParam(1, $kode_guru);
        $stmt->bindParam(2, $tanggal);
        $stmt->bindParam(3, $waktu);

        // Memeriksa apakah waktu_hadir lebih dari 07.30
        if (strtotime($waktu) > strtotime('07:30:30')) {
            $status = 'Terlambat';
        }
        $stmt->bindParam(4, $status);
        $stmt->bindParam(5, $foto_hadir);
        if ($stmt->execute()) {
            echo "<script>alert('Kehadiran berhasil disimpan'); window.location.href = '../pages/kehadiran.php';</script>";
            exit();
        } else {
            die("Gagal menyimpan data kehadiran: " . implode(", ", $stmt->errorInfo()));
        }
        $stmt->close();
    } else {
        die("Gagal membuat statement");
    }
} else {
    die("Metode request tidak valid");
}
