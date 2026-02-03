<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$data = mysqli_query($conn, "SELECT * FROM laporan ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/custom.css">
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <span class="navbar-brand fw-bold">Admin Kota Indah</span>
        <a href="../auth/logout.php" 
           class="btn btn-outline-light btn-sm"
           onclick="return confirm('Yakin ingin logout?')">
            Logout
        </a>
    </div>
</nav>

<!-- CONTENT -->
<div class="container mt-4 mb-5">
    <div class="card shadow">

        <!-- HEADER CARD -->
        <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Kelola Laporan Masyarakat</h5>

            <div class="btn-group">
                <a href="cetak_pdf.php" target="_blank" class="btn btn-light btn-sm">
                    Cetak PDF
                </a>
                <a href="cetak_exel.php" class="btn btn-success btn-sm">
                    Excel
                </a>
            </div>
        </div>

        <!-- BODY CARD -->
        <div class="card-body">
            <table class="table table-bordered align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>Alamat</th>
                        <th>Kendala</th>
                        <th>Foto</th>
                        <th>Status</th>
                        <th width="180">Aksi</th>
                    </tr>
                </thead>
                <tbody>

                <?php if (mysqli_num_rows($data) > 0): ?>
                    <?php while ($l = mysqli_fetch_assoc($data)): ?>
                        <tr>
                            <td><?= htmlspecialchars($l['alamat']) ?></td>
                            <td><?= htmlspecialchars($l['kendala']) ?></td>

                            <td class="text-center">
                                <?php if (!empty($l['foto'])): ?>
                                    <a href="../uploads/<?= $l['foto'] ?>" 
                                       target="_blank" 
                                       class="btn btn-info btn-sm">
                                        Lihat
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">-</span>
                                <?php endif; ?>
                            </td>

                            <td class="text-center">
                                <?php
                                $badge = 'secondary';
                                if ($l['status'] == 'menunggu') $badge = 'secondary';
                                if ($l['status'] == 'diproses') $badge = 'warning';
                                if ($l['status'] == 'selesai') $badge = 'success';
                                if ($l['status'] == 'ditolak') $badge = 'danger';
                                ?>
                                <span class="badge bg-<?= $badge ?>">
                                    <?= $l['status'] ?>
                                </span>
                            </td>

                            <!-- AKSI -->
                            <td class="text-center">
                                <div class="d-grid gap-1">
                                    <a href="approve.php?id=<?= $l['id'] ?>" 
                                       class="btn btn-primary btn-sm">
                                        Ubah Status
                                    </a>

                                    <a href="hapus_laporan.php?id=<?= $l['id'] ?>"
                                       class="btn btn-danger btn-sm">
                                        Hapus
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center text-muted">
                            Data laporan belum tersedia
                        </td>
                    </tr>
                <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>
