<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kota Indah | Layanan Laporan Masyarakat</title>
    <link rel="stylesheet" href="bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <style>
        .hero {
            background: linear-gradient(rgba(0,0,0,.5), rgba(0,0,0,.5)),
                        url('assets/img/ilustrasi.png') center/cover no-repeat;
            color: white;
            padding: 120px 0;
        }
        .icon-box {
            font-size: 40px;
        }
    </style>
</head>

<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Kota Indah</a>
        <div class="ms-auto">
            <a href="auth/login.php" class="btn btn-outline-light btn-sm me-2">Login</a>
            <a href="auth/register.php" class="btn btn-success btn-sm">Daftar</a>
        </div>
    </div>
</nav>

<!-- HERO -->
<section class="hero text-center">
    <div class="container">
        <h1 class="fw-bold">Laporkan Masalah Lingkungan Sekitar Anda</h1>
        <p class="lead mt-3">
            Kota Indah adalah platform layanan masyarakat untuk melaporkan
            masalah lingkungan seperti jalan rusak, sampah, lampu mati, dan lainnya.
        </p>
        <a href="auth/login.php" class="btn btn-success btn-lg mt-3">
            Laporkan Sekarang
        </a>
    </div>
</section>

<!-- FITUR -->
<section class="py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-4">Kenapa Kota Indah?</h3>
        <div class="row">
            <div class="col-md-4">
                <div class="icon-box">📍</div>
                <h5 class="fw-bold">Lokasi Akurat</h5>
                <p>Laporan dilengkapi alamat lokasi yang jelas.</p>
            </div>
            <div class="col-md-4">
                <div class="icon-box">📸</div>
                <h5 class="fw-bold">Foto Bukti</h5>
                <p>Masyarakat dapat mengunggah foto sebagai bukti laporan.</p>
            </div>
            <div class="col-md-4">
                <div class="icon-box">⚙️</div>
                <h5 class="fw-bold">Proses Cepat</h5>
                <p>Laporan diteruskan ke admin untuk segera ditindaklanjuti.</p>
            </div>
        </div>
    </div>
</section>

<!-- CARA KERJA -->
<section class="bg-light py-5">
    <div class="container text-center">
        <h3 class="fw-bold mb-4">Cara Menggunakan</h3>
        <div class="row">
            <div class="col-md-3">1️⃣ Daftar Akun</div>
            <div class="col-md-3">2️⃣ Login</div>
            <div class="col-md-3">3️⃣ Buat Laporan</div>
            <div class="col-md-3">4️⃣ Pantau Status</div>
        </div>
    </div>
</section>

<!-- FOOTER -->
<footer class="bg-dark text-white text-center p-3">
    © <?= date('Y') ?> Kota Indah | Layanan Laporan Masyarakat  
    <br>
    @Copyright by 23552011030_Fauzi Rikhshana_CNS-A_UASWEB1
</footer>

</body>
</html>
