<?php
session_start();
require_once "../config/db.php";

if (isset($_POST['login'])) {

    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($user = mysqli_fetch_assoc($result)) {

        if (password_verify($password, $user['password'])) {

            $_SESSION['login']   = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nama']    = $user['nama'];
            $_SESSION['role']    = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../user/dashboard_user.php");
            }
            exit;

        } else {
            $error = "Password salah";
        }

    } else {
        $error = "Email tidak ditemukan";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <link rel="stylesheet" href="../bootstrap-5.3.8-dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="../assets/css/custom.css">
</head>
<body>

<div class="login-page">
  <div class="container">
    <div class="card p-4 shadow col-md-4 mx-auto overlay">
      <h3 class="text-center">Login</h3>

      <?php if(isset($error)) : ?>
        <div class="alert alert-danger"><?= $error ?></div>
      <?php endif; ?>

      <form method="POST">
        <input name="email" type="email" class="form-control mb-2" placeholder="Email" required>
        <input name="password" type="password" class="form-control mb-2" placeholder="Password" required>
        <button name="login" class="btn btn-primary w-100">Login</button>
      </form>

      <p class="text-center mt-2">
        Belum punya akun? <a href="register.php">Daftar</a>
      </p>
    </div>
  </div>
</div>

</body>
</html>
