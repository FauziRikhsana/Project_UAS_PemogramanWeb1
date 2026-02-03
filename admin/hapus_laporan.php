<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit;
}

$id = $_GET['id'] ?? null;

if (!$id) {
    header("Location: dashboard.php");
    exit;
}

// Ambil data laporan (buat hapus foto)
$data = mysqli_fetch_assoc(
    mysqli_query($conn, "SELECT foto FROM laporan WHERE id='$id'")
);

// Hapus foto jika ada
if (!empty($data['foto'])) {
    $file = "../uploads/" . $data['foto'];
    if (file_exists($file)) {
        unlink($file);
    }
}

// Hapus data laporan
mysqli_query($conn, "DELETE FROM laporan WHERE id='$id'");

header("Location: dashboard.php");
exit;
