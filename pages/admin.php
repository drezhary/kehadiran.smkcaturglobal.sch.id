<?php
require '../config/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../loginadmin.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: sticky;
            top: 0;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
        }

        .sidebar a {
            text-decoration: none;
            color: #333;
            padding: 15px 20px;
            display: block;
        }

        .sidebar a:hover {
            background-color: #e9ecef;
        }

        .content {
            flex-grow: 1;
            padding: 20px;
        }
    </style>
</head>

<body>

    <!-- Sidebar -->
    <nav class="sidebar">
        <a href="admin.php">
            <h4 class="text-center mt-3">Admin Dashboard</h4>
        </a>
        <a href="report.html">Laporan Kehadiran</a>
        <a href="#">Data Guru</a>
        <a href="#">Pengaturan</a>
        <a href="../process/logout_action.php">Logout</a>
    </nav>

    <!-- Content -->
    <div class="content">
        <div class="row">
            <div class="col-12 mt-4">
                <h2>Dashboard Admin</h2>
                <p>Selamat datang di dashboard admin. Anda dapat mengelola data kehadiran guru di sini.</p>
            </div>
        </div>

        <!-- Statistik Ringkas -->
        <div class="row my-4">
            <div class="col-md-3">
                <div class="card text-white bg-success mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Total Kehadiran</h5>
                        <p class="card-text">120 Kehadiran</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-warning mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Hadir Hari Ini</h5>
                        <p class="card-text">30 Guru</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-danger mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Terlambat Hari Ini</h5>
                        <p class="card-text">5 Guru</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-white bg-secondary mb-3">
                    <div class="card-body">
                        <h5 class="card-title">Tidak Hadir</h5>
                        <p class="card-text">10 Guru</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabel Kehadiran -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Data Kehadiran Guru</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <input type="text" class="form-control" placeholder="Cari berdasarkan nama guru">
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Guru</th>
                                    <th>Tanggal</th>
                                    <th>Waktu</th>
                                    <th>Status</th>
                                    <th>Foto</th>
                                </tr>
                            </thead>
                            <?php
                            $stmt = $pdo->query("SELECT guru.nama_guru, kehadiran.tanggal, kehadiran.waktu_hadir, kehadiran.status,kehadiran.foto_hadir FROM guru INNER JOIN kehadiran on guru.kode_guru = kehadiran.kode_guru ORDER BY kehadiran.tanggal DESC;");
                            ?>
                            <tbody>
                                <?php
                                if ($stmt->rowCount() > 0) {
                                    $no = 1;
                                    while ($baris = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo "<tr>";
                                        echo "<td>" . $no++ . "</td>";
                                        echo "<td>" . htmlspecialchars($baris['nama_guru']) . "</td>";
                                        echo "<td>" . htmlspecialchars($baris['tanggal']) . "</td>";
                                        echo "<td>" . htmlspecialchars($baris['waktu_hadir']) . "</td>";
                                        echo "<td>" . htmlspecialchars($baris['status']) . "</td>";
                                        echo "<td><img src='" . htmlspecialchars($baris['foto_hadir']) . "' alt='Foto Kehadiran' width='100'></td>";
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan = '4'><td>Tidak ada kehadiran</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>