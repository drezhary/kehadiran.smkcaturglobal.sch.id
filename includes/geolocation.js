// Lokasi referensi
const referenceLatitude = -6.2152191; // Latitude lokasi referensi
const referenceLongitude = 106.9947312; // Longitude lokasi referensi
const radiusThreshold = 600; // Radius batas dalam meter

// Fungsi untuk menghitung jarak menggunakan Haversine Formula
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371000; // Radius bumi dalam meter
    const toRadians = (deg) => deg * (Math.PI / 180);
    const dLat = toRadians(lat2 - lat1);
    const dLon = toRadians(lon2 - lon1);
    const a =
        Math.sin(dLat / 2) * Math.sin(dLat / 2) +
        Math.cos(toRadians(lat1)) * Math.cos(toRadians(lat2)) *
        Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Hasil dalam meter
}

// Fungsi untuk memeriksa lokasi
function checkUserLocation() {
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function (position) {
                const userLatitude = position.coords.latitude;
                const userLongitude = position.coords.longitude;

                // Hitung jarak dari lokasi referensi
                const distance = calculateDistance(userLatitude, userLongitude, referenceLatitude, referenceLongitude);
                console.log(distance);
                // Tampilkan hasil
                if (distance <= radiusThreshold) {
                    resolve(true);
                } else {
                    alert('Anda tidak berada di lokasi');
                    resolve(false);
                }
            }, function (error) {
                alert('Gagal mendapatkan lokasi : ${error.message}');
                reject(error);
            });
        } else {
            alert('Geolokasi tidak didukung oleh browser ini.');
            reject(new Error('Geolocation tidak didukung oleh browser ini.'));
        }
    });
}

// // Pastikan fungsi bisa diakses dari file HTML lain
// export { checkUserLocation };
