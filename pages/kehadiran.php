<?php
session_start();
require '../config/db_connection.php';


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
    <script src="../includes/geolocation.js"></script>
    <script>
        function submitAttendanceForm(event) {
            event.preventDefault();
            checkUserLocation().then(isWithinRadius => {
                if (!isWithinRadius) {
                    alert('Proses pengiriman data dibatalkan karena anda tidak berada di lingkungan sekolah');
                } else {
                    document.getElementById('attendanceForm').submit();
                }
            }).catch(error => {
                alert('Terjadi kesalahan dalam memeriksa lokasi' + error.message);
            });
        }
    </script>
</head>

<body class="bg-light">
    <div class="container my-5">
        <h2 class="mb-4">Selamat Datang, <?php echo htmlspecialchars($_SESSION['nama_guru']); ?></h2>

        <!-- Form Kehadiran -->
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-title">Catat Kehadiran</h5>
                <form id="attendanceForm" action="../process/attendance_action.php" method="POST" enctype="multipart/form-data" onsubmit="submitAttendanceForm(event)">
                    <div class="mb-3">
                        <label for="kodeGuru" class="form-label">Kode Guru</label>
                        <input type="text" class="form-control" id="kodeGuru" name="kode_guru" readonly value="<?php echo $_SESSION['kode_guru']; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="fotoKehadiran" class="form-label">Foto Kehadiran</label>
                        <input type="file" class="form-control" id="fotoKehadiran" accept="image/*" name="foto_hadir" capture="environment" required>
                    </div>
                    <button type="submit" class="btn btn-success" id="submit">Hadir</button>
                    <a href="../process/logout_action.php" class="btn btn-danger">Logout</a>
                </form>
            </div>
        </div>

        <!-- Tabel Kehadiran -->
        <?php
        $stmt = $pdo->query("SELECT * FROM kehadiran");

        ?>
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
                                <th>Status</th>
                                <th>Foto</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $stmt = $pdo->query("SELECT * FROM kehadiran WHERE kode_guru = '" . htmlspecialchars($_SESSION['kode_guru']) . "'");
                            if ($stmt->rowCount() > 0) {
                                $no = 1;
                                while ($baris = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo "<tr>";
                                    echo "<td>" . $no++ . "</td>";
                                    echo "<td>" . htmlspecialchars($baris['tanggal']) . "</td>";
                                    echo "<td>" . htmlspecialchars($baris['waktu_hadir']) . "</td>";
                                    echo "<td>" . htmlspecialchars($baris['status']) . "</td>";
                                    echo "<td><img src='" . htmlspecialchars($baris['foto_hadir']) . "' alt='Foto Kehadiran' width='100'></td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='4'>Tidak ada data kehadiran</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>