<?php
session_start();
include '../config/db.php';

$id = $_POST['id'];
$lokasi = $_POST['lokasi'];
$deskripsi = $_POST['deskripsi'];

if ($_FILES['foto']['name']) {
  $foto = time() . $_FILES['foto']['name'];
  move_uploaded_file($_FILES['foto']['tmp_name'], "../uploads/".$foto);
  mysqli_query($conn, "UPDATE laporan SET lokasi='$lokasi', deskripsi='$deskripsi', foto='$foto' WHERE id=$id");
} else {
  mysqli_query($conn, "UPDATE laporan SET lokasi='$lokasi', deskripsi='$deskripsi' WHERE id=$id");
}

header("Location: index.php");
