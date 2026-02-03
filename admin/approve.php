<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;

$query = mysqli_query($conn, "SELECT * FROM laporan WHERE id='$id'");
$laporan = mysqli_fetch_assoc($query);

if (!$laporan) {
    echo "Data laporan tidak ditemukan";
    exit;
}

if (isset($_POST['simpan'])) {

    $status = $_POST['status'];

    // upload bukti
    if (!empty($_FILES['bukti']['name'])) {
        $namaFile = time() . '_' . $_FILES['bukti']['name'];
        $folder = "../uploads/bukti/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        move_uploaded_file($_FILES['bukti']['tmp_name'], $folder.$namaFile);
    } else {
        $namaFile = $laporan['bukti'];
    }

    mysqli_query($conn, "
        UPDATE laporan SET
        status='$status',
        bukti='$namaFile'
        WHERE id='$id'
    ");

    header("Location: dashboard.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Laporan</title>
     <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>

<body class="bg-light">

<nav class="navbar navbar-dark bg-success">
    <div class="container">
        <span class="navbar-brand">Admin Kota Indah</span>
        <a href="../auth/logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
</nav>

<div class="container mt-5 mb-5">
    <div class="card shadow p-4">

        <h4 class="mb-3">Detail Laporan</h4>

        <table class="table table-borderless">
            <tr>
                <th width="150">Alamat</th>
                <td><?= htmlspecialchars($laporan['alamat']) ?></td>
            </tr>
            <tr>
                <th>Kendala</th>
                <td><?= htmlspecialchars($laporan['kendala']) ?></td>
            </tr>
            <tr>
                <th>Status</th>
                <td>
                    <span class="badge bg-info"><?= $laporan['status'] ?></span>
                </td>
            </tr>
        </table>

        <?php if (!empty($laporan['foto'])) : ?>
            <div class="mb-3">
                <label class="form-label"><b>Foto Laporan</b></label><br>
                <img src="../uploads/<?= $laporan['foto'] ?>" 
                     class="img-fluid rounded" style="max-height:300px;">
            </div>
        <?php endif; ?>

        <hr>

        <form method="POST" enctype="multipart/form-data">

            <div class="mb-3">
                <label class="form-label">Ubah Status</label>
                <select name="status" class="form-select" required>
                    <option value="diproses" <?= $laporan['status']=='diproses'?'selected':'' ?>>Diproses</option>
                    <option value="ditinjau" <?= $laporan['status']=='sedang ditindak lanjuti'?'selected':'' ?>>ditindaklanjuti</option>
                    <option value="selesai" <?= $laporan['status']=='selesai'?'selected':'' ?>>selesai</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Upload Bukti Pengerjaan</label>
                <input type="file" name="bukti" class="form-control">
            </div>

            <?php if (!empty($laporan['bukti'])) : ?>
                <p>
                    <a href="../uploads/bukti/<?= $laporan['bukti'] ?>" 
                       target="_blank" 
                       class="btn btn-sm btn-info">
                        Lihat Bukti Sebelumnya
                    </a>
                </p>
            <?php endif; ?>

            <div class="d-flex justify-content-between">
                <a href="dashboard.php" class="btn btn-secondary">Kembali</a>
                <button type="submit" name="simpan" class="btn btn-success">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<footer class="text-center p-3 text-muted">
    © Kota Indah - Admin
</footer>

</body>
</html>
