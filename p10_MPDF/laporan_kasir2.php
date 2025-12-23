<?php
require __DIR__ . '/vendor/autoload.php';
include "koneksi.php";

use Mpdf\Mpdf;

// ================= QUERY =================
$q = mysqli_query($koneksi,"
    SELECT 
        p.id_pesanan,
        p.nama_pelanggan,
        p.telepon,
        p.lantai,
        p.kode_bangku,
        p.tanggal_pesan,
        SUM(d.subtotal) AS total_bayar
    FROM pesanan p
    JOIN detail_pesanan d ON d.id_pesanan = p.id_pesanan
    GROUP BY p.id_pesanan
    ORDER BY p.tanggal_pesan DESC
");

// ================= HTML PDF =================
$html = '
<style>
body{font-family:Arial;font-size:11px}
h2{text-align:center}
table{width:100%;border-collapse:collapse}
th,td{border:1px solid #000;padding:6px}
th{background:#eee}
</style>

<h2>LAPORAN KASIR<br>Caffe Decana</h2>

<table>
<tr>
    <th>No</th>
    <th>Nama</th>
    <th>Telepon</th>
    <th>Lantai</th>
    <th>Bangku</th>
    <th>Tanggal</th>
    <th>Total</th>
</tr>
';

$no = 1;
while($r = mysqli_fetch_assoc($q)){
    $html .= '
    <tr>
        <td>'.$no++.'</td>
        <td>'.$r['nama_pelanggan'].'</td>
        <td>'.$r['telepon'].'</td>
        <td>'.$r['lantai'].'</td>
        <td>'.$r['kode_bangku'].'</td>
        <td>'.date('d-m-Y H:i', strtotime($r['tanggal_pesan'])).'</td>
        <td>Rp '.number_format($r['total_bayar'],0,',','.').'</td>
    </tr>';
}

$html .= '</table>';

// ================= GENERATE PDF =================
$mpdf = new Mpdf(['format' => 'A4']);
$mpdf->WriteHTML($html);
$mpdf->Output('laporan_kasir.pdf', 'I');
