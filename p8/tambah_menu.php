<?php
// tambah_menu.php (versi diperbaiki)
include "koneksi.php";
mysqli_set_charset($koneksi, 'utf8mb4');

$errors = [];
$success = false;

/* -------------------------
   Ambil daftar kategori (jika ada)
   ------------------------- */
$kategori_list = [];
$kat_exists = false;
$kat_id_col = 'id_kategori';
$kat_name_col = 'nama_kategori';

$chk = @mysqli_query($koneksi, "SHOW TABLES LIKE 'kategori'");
if ($chk && mysqli_num_rows($chk) > 0) {
    $kat_exists = true;

    $qcols = mysqli_query($koneksi, "SHOW COLUMNS FROM `kategori`");
    $cols = [];
    while ($c = mysqli_fetch_assoc($qcols)) $cols[] = $c['Field'];
    mysqli_free_result($qcols);

    // Jika kolom default tidak ada, ambil nama kolom pertama/ke-2 sebagai fallback
    if (!in_array('id_kategori', $cols)) $kat_id_col = $cols[0] ?? 'id_kategori';
    if (!in_array('nama_kategori', $cols)) $kat_name_col = $cols[1] ?? $cols[0] ?? 'nama_kategori';

    // gunakan backticks untuk nama kolom (karena nama kolom berasal dari DB sendiri)
    $qr = "SELECT `$kat_id_col` AS idk, `$kat_name_col` AS name FROM `kategori` ORDER BY `$kat_name_col`";
    $r = mysqli_query($koneksi, $qr);
    if ($r) {
        while ($row = mysqli_fetch_assoc($r)) {
            $kategori_list[] = ['id' => $row['idk'], 'name' => $row['name']];
        }
        mysqli_free_result($r);
    }
}
if ($chk) mysqli_free_result($chk);

/* -------------------------
   Fungsi upload gambar
   Kembali: path relatif 'uploads/..' atau false jika gagal, '' jika tidak ada file
   ------------------------- */
function handle_upload_image($file_field = 'gambar') {
    if (!isset($_FILES[$file_field]) || empty($_FILES[$file_field]['name'])) return '';
    $file = $_FILES[$file_field];

    if ($file['error'] !== UPLOAD_ERR_OK) return false;

    // cek mime type
    $finfo = @finfo_open(FILEINFO_MIME_TYPE);
    $mime = $finfo ? finfo_file($finfo, $file['tmp_name']) : mime_content_type($file['tmp_name']);
    if ($finfo) finfo_close($finfo);

    $allowed = ['image/jpeg','image/png','image/gif','image/webp'];
    if (!in_array($mime, $allowed)) return false;

    // batas ukuran 3MB
    if ($file['size'] > 3 * 1024 * 1024) return false;

    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    // pastikan ekstensi konsisten dengan mime (opsional, di sini asumsikan user upload benar)
    $safe_name = 'menu_' . time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
    $upload_dir = __DIR__ . '/uploads';
    if (!is_dir($upload_dir)) {
        if (!mkdir($upload_dir, 0755, true)) return false;
    }
    $dest = $upload_dir . '/' . $safe_name;

    if (!move_uploaded_file($file['tmp_name'], $dest)) return false;

    // kembalikan path relatif
    return 'uploads/' . $safe_name;
}

/* -------------------------
   Default old values (untuk refill form jika error)
   ------------------------- */
$old = [
    'nama_menu' => '',
    'deskripsi' => '',
    'harga_raw' => '',
    'status' => 'masih ada',
    'id_kategori' => ''
];

/* -------------------------
   Proses form POST
   ------------------------- */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $old['nama_menu']  = trim($_POST['nama_menu'] ?? '');
    $old['deskripsi']  = trim($_POST['deskripsi'] ?? '');
    $harga_raw         = str_replace('.', '', trim($_POST['harga_raw'] ?? '0')); // hapus pemisah ribuan
    $old['harga_raw']  = $harga_raw;
    $harga             = is_numeric($harga_raw) ? (float)$harga_raw : null;
    $old['status']     = (($_POST['status'] ?? 'masih ada') === 'habis') ? 'habis' : 'masih ada';
    $old['id_kategori']= $_POST['id_kategori'] ?? '';
    $status            = $old['status'];

    // tentukan id_kategori (default 0 jika tidak ada/tidak dipilih)
    $id_kategori = 0;
    if ($kat_exists && !empty($_POST['id_kategori'])) {
        $id_kategori = (int) $_POST['id_kategori'];
    } elseif ($kat_exists) {
        // cari atau buat kategori "Umum"
        $cname = 'Umum';
        $sql_check = "SELECT `$kat_id_col` FROM `kategori` WHERE `$kat_name_col` = ?";
        $cek = mysqli_prepare($koneksi, $sql_check);
        if ($cek) {
            mysqli_stmt_bind_param($cek, "s", $cname);
            mysqli_stmt_execute($cek);
            $rescek = mysqli_stmt_get_result($cek);
            $rowc = mysqli_fetch_assoc($rescek);
            mysqli_stmt_close($cek);
            if ($rowc && isset($rowc[$kat_id_col])) {
                $id_kategori = (int)$rowc[$kat_id_col];
            } else {
                $ins = mysqli_prepare($koneksi, "INSERT INTO `kategori` (`$kat_name_col`) VALUES (?)");
                if ($ins) {
                    mysqli_stmt_bind_param($ins, "s", $cname);
                    mysqli_stmt_execute($ins);
                    $id_kategori = mysqli_insert_id($koneksi);
                    mysqli_stmt_close($ins);
                } else {
                    $id_kategori = 0;
                }
            }
        } else {
            $id_kategori = 0;
        }
    } else {
        $id_kategori = 0;
    }

    // validasi sederhana
    if ($old['nama_menu'] === '') $errors[] = "Nama menu wajib diisi.";
    if ($harga === null) $errors[] = "Harga tidak valid, masukkan angka (mis. 25000).";

    // handle gambar jika ada
    $gambar_db = '';
    if (isset($_FILES['gambar']) && !empty($_FILES['gambar']['name'])) {
        $upload_res = handle_upload_image('gambar');
        if ($upload_res === false) {
            $errors[] = "Upload gambar gagal, tipe/ukuran tidak diizinkan (max 3MB, jpg/png/gif/webp).";
        } else {
            $gambar_db = $upload_res;
        }
    }

    if (empty($errors)) {
        // format harga ke string 2 desimal (gunakan string agar binding aman)
        $harga_str = number_format($harga, 2, '.', '');

        $sql = "INSERT INTO `menu` (id_kategori, nama_menu, deskripsi, harga, status, gambar)
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($koneksi, $sql);
        if (!$stmt) {
            $errors[] = "Gagal menyiapkan query: " . mysqli_error($koneksi);
        } else {
            $g = $gambar_db ?: '';
            // binding: i = int (id_kategori), s = string (lainnya)
            mysqli_stmt_bind_param($stmt, "isssss", $id_kategori, $old['nama_menu'], $old['deskripsi'], $harga_str, $status, $g);
            if (mysqli_stmt_execute($stmt)) {
                mysqli_stmt_close($stmt);
                // redirect supaya refresh tidak mengirim ulang form
                header("Location: tambah_menu.php?added=1");
                exit;
            } else {
                $errors[] = "Gagal menyimpan: " . mysqli_stmt_error($stmt);
                mysqli_stmt_close($stmt);
            }
        }
    }
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8"/>
<title>Tambah Menu</title>
<style>
/* gaya minimal agar rapi */
body{font-family:Arial,Helvetica,sans-serif;background:#fffaf6;color:#333;padding:18px}
.form{max-width:720px;margin:0 auto;background:#fff;padding:18px;border-radius:8px;box-shadow:0 8px 24px rgba(0,0,0,0.05)}
label{display:block;margin-top:10px;font-weight:600}
input, textarea, select{width:100%;padding:8px;border-radius:6px;border:1px solid #e6dcd3;margin-top:6px}
.btn{margin-top:12px;padding:10px 14px;background:#7a4b2b;color:#fff;border:0;border-radius:8px;cursor:pointer}
.err{background:#ffecec;color:#b30000;padding:10px;border-radius:6px}
.ok{background:#eaffef;color:#0a663a;padding:10px;border-radius:6px}
.small{font-size:0.9rem;color:#6b5146}
</style>
</head>
<body>
  <div class="form">
    <h2>Tambah Menu</h2>

    <?php if (!empty($errors)): ?>
      <div class="err"><ul><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul></div>
    <?php endif; ?>

    <?php if (isset($_GET['added'])): ?>
      <div class="ok">Menu berhasil ditambahkan. <a href="menu.php">Lihat di menu</a></div>
    <?php endif; ?>

    <form method="post" enctype="multipart/form-data" onsubmit="prepareHarga()">
      <label>Nama Menu</label>
      <input type="text" name="nama_menu" required value="<?php echo htmlspecialchars($old['nama_menu']); ?>">

      <label>Deskripsi</label>
      <textarea name="deskripsi" rows="4"><?php echo htmlspecialchars($old['deskripsi']); ?></textarea>

      <label>Harga (ketik angka, contoh: 25000)</label>
      <input type="text" id="harga_view" oninput="formatHargaView()" placeholder="25000" value="<?php echo htmlspecialchars(number_format((float)$old['harga_raw'],0,'.','.')); ?>" />
      <input type="hidden" name="harga_raw" id="harga_raw" value="<?php echo htmlspecialchars($old['harga_raw']); ?>">

      <label>Status</label>
      <select name="status">
        <option value="masih ada" <?php echo $old['status'] === 'masih ada' ? 'selected' : ''; ?>>Masih Ada</option>
        <option value="habis" <?php echo $old['status'] === 'habis' ? 'selected' : ''; ?>>Habis</option>
      </select>

      <label>Kategori</label>
      <?php if (!empty($kategori_list)): ?>
        <select name="id_kategori">
          <option value="">-- Pilih kategori (opsional) --</option>
          <?php foreach($kategori_list as $k): ?>
            <option value="<?php echo (int)$k['id']; ?>" <?php echo ((string)$k['id'] === (string)$old['id_kategori']) ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($k['name']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      <?php else: ?>
        <div class="small">Tabel kategori tidak ditemukan. Sistem akan menyetkan id_kategori = 0.</div>
      <?php endif; ?>

      <label>Tambah gambar (opsional)</label>
      <input type="file" name="gambar" accept="image/*">

      <button class="btn" type="submit">Simpan</button>
    </form>
  </div>

<script>
function formatNumber(n){ return n.replace(/\D/g,"").replace(/\B(?=(\d{3})+(?!\d))/g,"."); }
function formatHargaView(){
  var v = document.getElementById('harga_view').value;
  v = v.replace(/[^\d]/g,'');
  document.getElementById('harga_view').value = formatNumber(v);
  document.getElementById('harga_raw').value = v;
}
function prepareHarga(){
  var raw = document.getElementById('harga_raw').value;
  if (!raw){
    var v = document.getElementById('harga_view').value.replace(/[^\d]/g,'');
    document.getElementById('harga_raw').value = v;
  }
}
</script>
</body>
</html>
