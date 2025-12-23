<?php
include "koneksi.php";
mysqli_set_charset($koneksi,'utf8mb4');

function rupiah($n){
    return "Rp".number_format($n,0,',','.');
}

// ================= AMBIL DATA PESANAN =================
$q = mysqli_query($koneksi,"
    SELECT 
        p.id_pesanan,
        p.nama_pelanggan,
        p.telepon,
        p.lantai,
        p.kode_bangku,
        p.tanggal_pesan,
        m.nama_menu,
        d.qty,
        d.subtotal
    FROM pesanan p
    JOIN detail_pesanan d ON p.id_pesanan = d.id_pesanan
    JOIN menu m ON d.id_menu = m.id_menu
    ORDER BY p.id_pesanan DESC
");

$pesanan = [];
while($r = mysqli_fetch_assoc($q)){
    $id = $r['id_pesanan'];

    if(!isset($pesanan[$id])){
        $pesanan[$id] = [
            'nama' => $r['nama_pelanggan'],
            'telp' => $r['telepon'],
            'lantai' => $r['lantai'],
            'bangku' => $r['kode_bangku'],
            'tanggal' => $r['tanggal_pesan'],
            'total' => 0,
            'items' => []
        ];
    }

    $pesanan[$id]['items'][] = $r;
    $pesanan[$id]['total'] += $r['subtotal'];
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Laporan Kasir</title>
<style>
body{font-family:Arial;background:#f4f6f9;padding:20px}
h1{text-align:center;color:#7a4b2b}
.btn{
    padding:10px 20px;
    background:#7a4b2b;
    color:#fff;
    border:none;
    border-radius:8px;
    cursor:pointer;
    font-size:15px
}
.card{
    background:#fff;
    margin-bottom:25px;
    padding:15px;
    border-radius:12px;
    box-shadow:0 6px 16px rgba(0,0,0,.1)
}
table{width:100%;border-collapse:collapse;margin-top:10px}
th{background:#7a4b2b;color:#fff;padding:8px}
td{padding:8px;border-bottom:1px solid #ddd}
.total{text-align:right;font-weight:bold;color:#b91c1c;margin-top:8px}
.info{margin-bottom:10px;font-size:14px}
</style>
</head>
<body>

<h1>☕ Laporan Kasir</h1>

<!-- TOMBOL EXPORT PDF -->
<form action="laporan_kasir2.php" method="get" target="_blank" style="text-align:center;margin-bottom:25px">
    <button type="submit" class="btn">
        📄 Export PDF Laporan Kasir
    </button>
</form>

<?php foreach($pesanan as $id => $p): ?>
<div class="card">
    <div class="info">
        <b>Pesanan #<?= $id ?></b><br>
        👤 <?= $p['nama'] ?> | 📞 <?= $p['telp'] ?><br>
        🏢 Lantai : <?= $p['lantai'] ?><br>
        🪑 Bangku : <?= $p['bangku'] ?><br>
        🕒 <?= $p['tanggal'] ?>
    </div>

    <table>
        <tr>
            <th>No</th>
            <th>Menu</th>
            <th>Qty</th>
            <th>Subtotal</th>
        </tr>
        <?php foreach($p['items'] as $i => $it): ?>
        <tr>
            <td><?= $i+1 ?></td>
            <td><?= $it['nama_menu'] ?></td>
            <td><?= $it['qty'] ?></td>
            <td><?= rupiah($it['subtotal']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>

    <div class="total">
        Total : <?= rupiah($p['total']) ?>
    </div>
</div>
<?php endforeach; ?>

</body>
</html>
