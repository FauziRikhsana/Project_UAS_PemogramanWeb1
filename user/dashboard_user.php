<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'")
);

$laporan = mysqli_query($conn, "
    SELECT * FROM laporan 
    WHERE user_id='$user_id' 
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard User</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>

<body class="bg-light d-flex flex-column min-vh-100">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Kota Indah</span>
        <a href="../auth/logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4 mb-5 flex-grow-1">

    <!-- PROFILE CARD -->
    <div class="card shadow mb-4">
        <div class="card-body d-flex align-items-center gap-4">

            <img src="../uploads/profile/<?= $user['foto'] ?? 'default.png' ?>" 
                 class="rounded-circle border"
                 width="100" height="100"
                 style="object-fit:cover;">

            <div>
                <h5 class="mb-1"><?= htmlspecialchars($user['nama']) ?></h5>
                <p class="mb-2 text-muted"><?= htmlspecialchars($user['email']) ?></p>

                <a href="edit_profile.php" class="btn btn-outline-primary btn-sm">
                    Edit Profil
                </a>
            </div>
        </div>
    </div>

    <!-- RIWAYAT LAPORAN -->
    <div class="card shadow">
        <div class="card-header bg-primary text-white d-flex justify-content-between">
            <span>Riwayat Laporan Saya</span>
            <a href="../laporan/tambah.php" class="btn btn-light btn-sm">
                + Buat Laporan
            </a>
        </div>

        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Tanggal</th>
                        <th>Alamat</th>
                        <th>Kendala</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($laporan) > 0): ?>
                    <?php while ($l = mysqli_fetch_assoc($laporan)): ?>
                        <tr>
                            <td><?= date('d-m-Y', strtotime($l['created_at'])) ?></td>
                            <td><?= htmlspecialchars($l['alamat']) ?></td>
                            <td><?= htmlspecialchars($l['kendala']) ?></td>
                            <td>
                                <?php
                                    $badge = 'secondary';
                                    if ($l['status'] == 'diproses') $badge = 'warning';
                                    if ($l['status'] == 'selesai') $badge = 'success';
                                    if ($l['status'] == 'ditolak') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge ?>">
                                    <?= $l['status'] ?>
                                </span>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Kamu belum membuat laporan
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</div>

<footer class="bg-light text-center p-3 mt-auto">
    © Copyright by Fauzi_TIF23_PemrogramanWeb1
</footer>

</body>
</html>
