<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Buat Laporan</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Buat Laporan</h5>
        </div>

        <div class="card-body">
            <form action="simpan.php" method="POST" enctype="multipart/form-data">

                <!-- ALAMAT + SHARE LOCATION -->
                <div class="mb-3">
                    <label class="form-label">Alamat</label>
                    <div class="input-group">
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                        <button type="button" class="btn btn-outline-primary" onclick="ambilLokasi()">
                            Ambil Lokasi Saya
                        </button>
                    </div>
                    <small class="text-muted">
                        Gunakan lokasi otomatis agar alamat lebih akurat
                    </small>
                </div>

                <div class="mb-3">
                    <label>Kendala</label>
                    <textarea name="kendala" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label>Foto Bukti</label>
                    <input type="file" name="foto" class="form-control">
                </div>

                <button class="btn btn-success w-100">
                    Kirim Laporan
                </button>

            </form>
        </div>
    </div>
</div>

<!-- SCRIPT LOKASI -->
<script>
function ambilLokasi() {
    if (!navigator.geolocation) {
        alert("Browser tidak mendukung lokasi");
        return;
    }

    navigator.geolocation.getCurrentPosition(
        function (pos) {
            let lat = pos.coords.latitude;
            let lon = pos.coords.longitude;

            fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById("alamat").value = data.display_name;
                })
                .catch(() => {
                    alert("Gagal mengambil alamat");
                });
        },
        function () {
            alert("Izin lokasi ditolak");
        }
    );
}
</script>

</body>
</html>
