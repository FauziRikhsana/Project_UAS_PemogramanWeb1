<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$data = mysqli_query($conn, "
    SELECT alamat, kendala, status, foto
    FROM laporan
    WHERE user_id = '$user_id'
    ORDER BY id DESC
");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Saya</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand">Kota Indah</span>
        <a href="../auth/logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h5>Status Laporan Saya</h5>
        </div>
        <div class="card-body">

            <a href="tambah.php" class="btn btn-primary mb-3">
                + Buat Laporan
            </a>

            <table class="table table-bordered align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Alamat</th>
                        <th>Status</th>
                        <th>Kendala</th>
                        <th>Bukti</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($data) > 0): ?>
                    <?php while($l = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= htmlspecialchars($l['alamat']) ?></td>
                            <td>
                                <?php
                                if ($l['status'] == 'menunggu') echo '<span class="badge bg-secondary">Menunggu</span>';
                                elseif ($l['status'] == 'diproses') echo '<span class="badge bg-warning text-dark">Diproses</span>';
                                else echo '<span class="badge bg-success">Selesai</span>';
                                ?>
                            </td>
                            <td><?= htmlspecialchars($l['kendala']) ?></td>
                            <td>
                                <?php if ($l['foto']): ?>
                                    <a href="../uploads/<?= $l['foto'] ?>" target="_blank" class="btn btn-info btn-sm">
                                        Lihat Foto
                                    </a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada laporan
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
   <a href="../user/dashboard_user.php" class="btn btn-secondary btn-kembali">
    Kembali
</a>
</body>
</html>
