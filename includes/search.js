$(document).ready(function () {
    // Saat pengguna mengetik di input pencarian
    $('#search').on('keyup', function () {
        let query = $(this).val(); // Ambil nilai input

        // Kirim permintaan AJAX ke search.php
        $.ajax({
            url: '../includes/search.php', // Lokasi file PHP
            type: 'GET', // Gunakan metode GET
            data: { query: query }, // Data yang dikirim ke server
            success: function (response) {
                // Bersihkan tabel
                let tableBody = $('#result');
                tableBody.empty();

                // Jika ada hasil
                if (response.length > 0) {
                    // Tambahkan baris ke tabel untuk setiap data
                    response.forEach((row, index) => {
                        tableBody.append(`
                            <tr>
                                <td>${index + 1}</td>
                                <td>${row.nama_guru}</td>
                                <td>${row.tanggal}</td>
                                <td>${row.waktu_hadir}</td>
                                <td>${row.status}</td>
                                <td><img src="${row.foto_hadir}" alt="Foto Kehadiran" width="100"></td>
                            </tr>
                        `);
                    });
                } else {
                    // Jika tidak ada hasil
                    tableBody.append(`
                        <tr>
                            <td colspan="6">Tidak ada hasil ditemukan</td>
                        </tr>
                    `);
                }
            },
            error: function () {
                alert('Terjadi kesalahan saat memproses data!');
            },
        });
    });
});
