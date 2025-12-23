<?php
include "koneksi.php";
mysqli_set_charset($koneksi,'utf8mb4');

function rupiah($n){
    return "Rp".number_format($n,0,',','.');
}

$q = mysqli_query($koneksi,"
    SELECT m.id_menu, m.nama_menu, m.harga, k.nama_kategori
    FROM menu m
    JOIN kategori_menu k ON k.id_kategori = m.id_kategori
    WHERE m.status != 'habis'
    ORDER BY k.nama_kategori, m.nama_menu
");

$data = [];
while($row = mysqli_fetch_assoc($q)){
    $data[$row['nama_kategori']][] = $row;
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<title>Pemesanan Menu</title>
<style>
body{font-family:Arial;background:#f8f3ee;margin:0}
.container{max-width:900px;margin:auto;padding:20px}
.header{background:#7a4b2b;color:#fff;padding:18px;font-size:26px;
        text-align:center;border-radius:14px}
.box{background:#fff;margin-top:20px;padding:20px;
     border-radius:14px;box-shadow:0 8px 20px rgba(0,0,0,.08)}
.kategori h3{color:#7a4b2b;border-bottom:2px solid #e6d7cc}
.item{display:grid;grid-template-columns:1fr auto auto;
      gap:10px;padding:8px 0;border-bottom:1px dashed #ddd}
input,textarea,select{width:100%;padding:8px;border-radius:8px;border:1px solid #ccc}
.total{font-size:18px;font-weight:bold;color:#7a4b2b;text-align:right;margin-top:15px}
button{margin-top:20px;background:#7a4b2b;color:#fff;border:none;
       padding:12px;width:100%;border-radius:10px;font-size:16px}
</style>
</head>

<body>
<div class="container">
<div class="header">🧾 Form Pemesanan</div>

<form method="post" action="simpan_pesanan_multi.php">
<div class="box">

<h3>📌 Data Pelanggan</h3>
<label>Nama Pelanggan</label>
<input type="text" name="nama_pelanggan" required>

<label>No. Telepon / WhatsApp</label>
<input type="text" name="telepon" required>

<label>Alamat</label>
<textarea name="alamat" rows="3" required></textarea>

<label>Catatan Pesanan</label>
<textarea name="catatan" rows="2"></textarea>

<hr>

<h3>🍽️ Pilih Menu</h3>

<?php foreach($data as $kategori => $menus): ?>
<div class="kategori">
<h3><?= htmlspecialchars($kategori) ?></h3>

<?php foreach($menus as $m): ?>
<div class="item">
<label>
  <input type="checkbox" name="menu[]" value="<?= $m['id_menu'] ?>"
         data-harga="<?= $m['harga'] ?>" onchange="hitungTotal()">
  <?= htmlspecialchars($m['nama_menu']) ?>
</label>

<div><?= rupiah($m['harga']) ?></div>

<input type="number" name="qty[<?= $m['id_menu'] ?>]" value="1" min="1"
       onchange="hitungTotal()">
</div>
<?php endforeach; ?>
</div>
<?php endforeach; ?>

<hr>

<h3>🪑 Pilih Bangku</h3>

<label>Lantai</label>
<select id="lantai" onchange="loadBangku()" required>
  <option value="">-- Pilih Lantai --</option>
  <option value="1">Lantai 1</option>
  <option value="2">Lantai 2</option>
  <option value="3">Lantai 3</option>
  <option value="4">Lantai 4</option>
  <option value="5">Lantai 5</option>
</select>

<label>Bangku</label>
<select name="kode_bangku" id="bangku" required>
  <option value="">-- Pilih Bangku Kosong --</option>
</select>

<div class="total" id="total">Total : Rp0</div>

<button type="submit">Kirim Pesanan</button>
</div>
</form>
</div>

<script>
const LS = 'decana_tables_simple';
const dataBangku = JSON.parse(localStorage.getItem(LS) || '[]');

function loadBangku(){
  const lantai = document.getElementById('lantai').value;
  const select = document.getElementById('bangku');
  select.innerHTML = '<option value="">-- Pilih Bangku Kosong --</option>';

  dataBangku
    .filter(b => b.floor == lantai && b.is_available == 1)
    .forEach(b => {
      let opt = document.createElement('option');
      opt.value = b.code;
      opt.textContent = `${b.code} (${b.seats} kursi)`;
      select.appendChild(opt);
    });
}

function hitungTotal(){
  let total = 0;
  document.querySelectorAll('input[type=checkbox]').forEach(cb=>{
    if(cb.checked){
      let harga = parseInt(cb.dataset.harga);
      let qty = cb.closest('.item').querySelector('input[type=number]').value;
      total += harga * qty;
    }
  });
  document.getElementById('total').innerHTML =
    "Total : Rp" + total.toLocaleString('id-ID');
}
</script>
</body>
</html>
