<?php
session_start();
include '../config/db.php';

if (isset($_POST['register'])) {

    $nama     = $_POST['nama'];
    $email    = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // WAJIB sebutkan kolom
    mysqli_query($conn, "
        INSERT INTO users (nama, email, password, role)
        VALUES ('$nama', '$email', '$password', 'user')
    ");

    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Register</title>
  <!-- Bootstrap -->
  <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>
<div class="container mt-5">
  <div class="card p-4 shadow col-md-5 mx-auto">
    <h3 class="text-center">Register</h3>
    <form method="POST">
      <input name="nama" class="form-control mb-2" placeholder="Nama" required>
      <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
      <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
      <button name="register" class="btn btn-primary w-100">Register</button>
    </form>
  </div>
</div>
</body>
</html>
