<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['login'])) {
    header("Location: ../auth/login.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$alamat  = $_POST['alamat'];
$kendala = $_POST['kendala'];

$foto = null;
if (!empty($_FILES['foto']['name'])) {
    $foto = time().'_'.$_FILES['foto']['name'];
    move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/".$foto);
}

mysqli_query($conn, "
    INSERT INTO laporan (user_id, alamat, kendala, foto)
    VALUES ('$user_id', '$alamat', '$kendala', '$foto')
");

header("Location: index.php");
