<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require '../dompdf/autoload.inc.php';
include '../config/db.php';

use Dompdf\Dompdf;

$dompdf = new Dompdf([
    'isRemoteEnabled' => true
]);

$query = mysqli_query($conn, "SELECT * FROM laporan ORDER BY id DESC");

if (!$query) {
    die(mysqli_error($conn));
}

$html = '
<h3 style="text-align:center;">LAPORAN DATA PENGADUAN</h3>
<hr>
<table border="1" width="100%" cellspacing="0" cellpadding="5">
<tr>
    <th>No</th>
    <th>Alamat</th>
    <th>Kendala</th>
    <th>Status</th>
    <th>Tanggal</th>
</tr>';

$no = 1;
while ($row = mysqli_fetch_assoc($query)) {
    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$row['alamat'].'</td>
        <td>'.$row['kendala'].'</td>
        <td>'.$row['status'].'</td>
        <td>'.date('d-m-Y', strtotime($row['created_at'])).'</td>
    </tr>';
}

$html .= '</table>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("laporan_pengaduan.pdf", ["Attachment" => false]);
