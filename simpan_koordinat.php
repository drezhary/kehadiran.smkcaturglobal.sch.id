<?php
// simpan_koordinat.php

// Ambil data JSON dari request body
$data = file_get_contents("php://input");
$koordinat = json_decode($data, true);

// Periksa apakah data diterima
if (isset($koordinat['latitude']) && isset($koordinat['longitude'])) {
    $latitude = $koordinat['latitude'];
    $longitude = $koordinat['longitude'];

    // Simpan atau proses data koordinat sesuai kebutuhan
    // Contoh: menyimpan ke file atau database
    $response = "Latitude: $latitude, Longitude: $longitude berhasil diterima.";
    echo $response;

    // Contoh jika ingin menyimpan ke database
    /*
    $conn = new mysqli('localhost', 'username', 'password', 'database');
    if ($conn->connect_error) {
        die("Koneksi gagal: " . $conn->connect_error);
    }
    $sql = "INSERT INTO koordinat (latitude, longitude) VALUES ('$latitude', '$longitude')";
    if ($conn->query($sql) === TRUE) {
        echo "Data koordinat berhasil disimpan.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $conn->close();
    */
} else {
    echo "Data koordinat tidak valid.";
}
