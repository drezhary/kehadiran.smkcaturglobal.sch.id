<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['kode_guru'])) {
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2 class="mb-4">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_guru']); ?></h2>

        <!-- Form Kehadiran -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Catat Kehadiran</h5>
                <form id="attendanceForm" action="../process/attendance_action.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="kodeGuru" class="form-label">Kode Guru</label>
                        <input type="text" class="form-control" id="kodeGuru" name="kode_guru" readonly value=<?php echo $_SESSION['kode_guru']; ?>>
                    </div>
                    <div class="mb-3">
                        <label for="fotoKehadiran" class="form-label">Foto Kehadiran</label>
                        <input type="file" class="form-control" id="fotoKehadiran" accept="image/*" name="foto_hadir" capture="environment" required>
                    </div>
                    <button type="submit" class="btn btn-success">Hadir</button>
                    <a href="../process/logout_action.php" class="btn btn-danger">Logout</a>
                </form>
            </div>
        </div>

        <!-- Tabel Kehadiran -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Catatan Kehadiran</h5>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Waktu</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>2025-01-13</td>
                                <td>07:30</td>
                                <td><img src="foto1.jpg" alt="Foto Kehadiran" width="50"></td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>2025-01-12</td>
                                <td>07:35</td>
                                <td><img src="foto2.jpg" alt="Foto Kehadiran" width="50"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>