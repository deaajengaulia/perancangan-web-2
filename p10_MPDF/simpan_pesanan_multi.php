<?php
include "koneksi.php";
mysqli_set_charset($koneksi,'utf8mb4');

function rupiah($n){
    return "Rp".number_format($n,0,',','.');
}

// ===== Ambil data POST =====
$nama   = $_POST['nama_pelanggan'] ?? '';
$telp   = $_POST['telepon'] ?? '';
$alamat = $_POST['alamat'] ?? '';
$catatan= $_POST['catatan'] ?? '';
$lantai = $_POST['lantai'] ?? '';
$bangku = $_POST['kode_bangku'] ?? '';
$menu   = $_POST['menu'] ?? [];
$qty    = $_POST['qty'] ?? [];

// ===== SIMPAN KE PESANAN =====
mysqli_query($koneksi,"
    INSERT INTO pesanan
    (nama_pelanggan, telepon, alamat, catatan, lantai, kode_bangku, tanggal_pesan)
    VALUES
    ('$nama','$telp','$alamat','$catatan','$lantai','$bangku',NOW())
");

$id_pesanan = mysqli_insert_id($koneksi);

// ===== SIMPAN DETAIL PESANAN =====
$menu_detail = [];
$total = 0;

foreach($menu as $id_menu){
    $jumlah = intval($qty[$id_menu] ?? 1);

    $q = mysqli_query($koneksi,"
        SELECT id_menu, nama_menu, harga
        FROM menu
        WHERE id_menu='$id_menu'
    ");
    $m = mysqli_fetch_assoc($q);

    $subtotal = $m['harga'] * $jumlah;
    $total += $subtotal;

    mysqli_query($koneksi,"
        INSERT INTO detail_pesanan
        (id_pesanan, id_menu, qty, subtotal)
        VALUES
        ('$id_pesanan','$id_menu','$jumlah','$subtotal')
    ");

    $m['qty'] = $jumlah;
    $m['subtotal'] = $subtotal;
    $menu_detail[] = $m;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Detail Pesanan</title>
<style>
body{font-family:Arial;background:#f8f3ee;margin:0}
.container{max-width:700px;margin:auto;padding:20px}
.header{background:#7a4b2b;color:#fff;padding:18px;font-size:24px;
        text-align:center;border-radius:14px}
.box{background:#fff;margin-top:20px;padding:20px;
     border-radius:14px;box-shadow:0 8px 20px rgba(0,0,0,.08)}
.table{width:100%;border-collapse:collapse;margin-top:10px}
.table th,.table td{border:1px solid #ddd;padding:8px}
.total{text-align:right;font-weight:bold;color:#7a4b2b}
</style>
</head>

<body>
<div class="container">
<div class="header">🧾 Detail Pesanan</div>

<div class="box">
<p><b>Nama:</b> <?= htmlspecialchars($nama) ?></p>
<p><b>Telepon:</b> <?= htmlspecialchars($telp) ?></p>
<p><b>Bangku:</b> Lantai <?= $lantai ?> - <?= $bangku ?></p>

<table class="table">
<tr><th>No</th><th>Menu</th><th>Qty</th><th>Subtotal</th></tr>
<?php foreach($menu_detail as $i => $m): ?>
<tr>
<td><?= $i+1 ?></td>
<td><?= $m['nama_menu'] ?></td>
<td><?= $m['qty'] ?></td>
<td><?= rupiah($m['subtotal']) ?></td>
</tr>
<?php endforeach; ?>
</table>

<div class="total">Total : <?= rupiah($total) ?></div>
</div>
</div>
</body>
</html>
