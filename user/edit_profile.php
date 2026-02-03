<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'user') {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Ambil data user
$user = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT * FROM users WHERE id='$user_id'")
);

// Proses simpan
if (isset($_POST['simpan'])) {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);

    // Default: pakai foto lama
    $fotoBaru = $user['foto'];

    // Jika upload foto baru
    if (!empty($_FILES['foto']['name'])) {
        $folder = "../uploads/profile/";

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $fotoBaru = time() . '_' . $user_id . '.' . $ext;

        move_uploaded_file($_FILES['foto']['tmp_name'], $folder . $fotoBaru);
    }

    mysqli_query($conn, "
        UPDATE users SET 
        nama='$nama',
        foto='$fotoBaru'
        WHERE id='$user_id'
    ");

    // Update session nama biar langsung berubah
    $_SESSION['nama'] = $nama;

    header("Location: dashboard.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil</title>
    <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Edit Profil</h5>
        </div>

        <div class="card-body">

            <!-- FOTO PROFIL -->
            <div class="text-center mb-4">
                <img src="../uploads/profile/<?= $user['foto'] ?? 'default.png' ?>"
                     class="rounded-circle border"
                     width="120" height="120"
                     style="object-fit:cover;">
            </div>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input type="text"
                           name="nama"
                           class="form-control"
                           value="<?= htmlspecialchars($user['nama']) ?>"
                           required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Foto Profil</label>
                    <input type="file" name="foto" class="form-control">
                    <small class="text-muted">
                        Kosongkan jika tidak ingin mengganti foto
                    </small>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="dashboard.php" class="btn btn-secondary">
                        Kembali
                    </a>
                    <button type="submit" name="simpan" class="btn btn-success">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

</body>
</html>
