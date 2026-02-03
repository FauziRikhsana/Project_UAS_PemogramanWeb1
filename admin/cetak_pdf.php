<?php
// ===============================
// LOAD DOMPDF
// ===============================
require_once __DIR__ . '/../dompdf-0.8.5/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// ===============================
// KONFIGURASI DOMPDF
// ===============================
$options = new Options();
$options->set('isRemoteEnabled', true); // agar bisa load CSS / gambar
$options->set('defaultFont', 'Arial');

$dompdf = new Dompdf($options);

// ===============================
// KONEKSI DATABASE (JIKA PERLU)
// ===============================
include '../config/db.php';

// ===============================
// AMBIL DATA DARI DATABASE (CONTOH)
// ===============================
$query = mysqli_query($conn, "SELECT * FROM laporan");

$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Kota Indah</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        h2 {
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        table, th, td {
            border: 1px solid #000;
        }
        th {
            background-color: #f2f2f2;
        }
        th, td {
            padding: 6px;
            text-align: center;
        }
    </style>
</head>
<body>

<h2>LAPORAN DATA KOTA INDAH</h2>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Judul</th>
            <th>Keterangan</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $html .= '
        <tr>
            <td>' . $no++ . '</td>
            <td>' . $row['judul'] . '</td>
            <td>' . $row['keterangan'] . '</td>
            <td>' . $row['tanggal'] . '</td>
        </tr>
    ';
}

$html .= '
    </tbody>
</table>

</body>
</html>
';

// ===============================
// GENERATE PDF
// ===============================
$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// ===============================
// OUTPUT PDF
// ===============================
$dompdf->stream(
    "laporan_kota_indah.pdf",
    ["Attachment" => false] // false = tampil di browser
);
