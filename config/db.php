<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "sql100.infinityfree.com";
$user = "if0_41050920";
$password = "wU0OeYuPyWkoh";
$database = "if0_41050920_kota_indah";

try {
    $conn = mysqli_connect($host, $user, $password, $database);
    mysqli_set_charset($conn, "utf8");
} catch (mysqli_sql_exception $e) {
    die("Koneksi database gagal: " . $e->getMessage());
}
