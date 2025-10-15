<?php
// postfileupload.php
// Debug: tampilkan error PHP (hilangkan di production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Folder uploads (relatif terhadap file ini)
$uploadDir = __DIR__ . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR;

// Batasan
$maxFileSize = 5 * 1024 * 1024; // 5 MB

// utility
function human_filesize($bytes){
    if ($bytes < 1024) return $bytes . ' B';
    if ($bytes < 1024*1024) return round($bytes/1024,2) . ' KB';
    return round($bytes/(1024*1024),2) . ' MB';
}

// Jika bukan POST => redirect ke form
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: fileupload.php');
    exit;
}

// buat folder uploads kalau belum ada
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) {
        $error = "Gagal membuat folder uploads pada: $uploadDir. Periksa permission.";
        die($error);
    }
}

// cek permission
if (!is_writable($uploadDir)) {
    die("Folder uploads tidak writable: $uploadDir. Ubah permission (contoh: chmod 775 uploads).");
}

// Tampilkan informasi environment penting (bantu debugging)
$phpInfo = [
    'upload_max_filesize' => ini_get('upload_max_filesize'),
    'post_max_size' => ini_get('post_max_size'),
    'max_file_uploads' => ini_get('max_file_uploads'),
    'max_execution_time' => ini_get('max_execution_time'),
    'display_errors' => ini_get('display_errors'),
    'upload_dir_realpath' => realpath($uploadDir)
];

// Proses file
$result = [
    'success' => false,
    'messages' => []
];

if (!isset($_FILES['file1'])) {
    $result['messages'][] = "Tidak ada file dikirim. Pastikan form memiliki enctype='multipart/form-data' dan input name='file1'.";
} else {
    $f = $_FILES['file1'];

    // peta error
    $errMap = [
        UPLOAD_ERR_OK => 'No error',
        UPLOAD_ERR_INI_SIZE => 'Lebih besar dari upload_max_filesize di php.ini',
        UPLOAD_ERR_FORM_SIZE => 'Lebih besar dari MAX_FILE_SIZE pada form HTML',
        UPLOAD_ERR_PARTIAL => 'Terupload sebagian (partial)',
        UPLOAD_ERR_NO_FILE => 'Tidak ada file yang diupload',
        UPLOAD_ERR_NO_TMP_DIR => 'Tidak ada folder sementara (NO_TMP_DIR)',
        UPLOAD_ERR_CANT_WRITE => 'Gagal menulis ke disk (CANT_WRITE)',
        UPLOAD_ERR_EXTENSION => 'Dihentikan oleh ekstensi PHP'
    ];

    $result['messages'][] = "Kode error upload: {$f['error']} - " . ($errMap[$f['error']] ?? 'Unknown');

    if ($f['error'] !== UPLOAD_ERR_OK) {
        // hentikan, tampilkan pesan
        $result['messages'][] = "Upload gagal: " . ($errMap[$f['error']] ?? 'Error tidak diketahui');
    } else {
        // ukuran
        $result['file_size_bytes'] = $f['size'];
        $result['file_size_readable'] = human_filesize($f['size']);
        if ($f['size'] > $maxFileSize) {
            $result['messages'][] = "File terlalu besar. Maks: " . human_filesize($maxFileSize) . ". Ukuran file: " . human_filesize($f['size']);
        } else {
            // buat nama file aman dan unik
            $originalName = basename($f['name']);
            $safeName = preg_replace('/[^\w\.\-]/', '_', $originalName);
            $uniq = date('YmdHis') . '_' . substr(md5(uniqid('', true)),0,6);
            $finalName = $uniq . '_' . $safeName;
            $targetPath = $uploadDir . $finalName;
            $relativePath = 'uploads/' . $finalName; // untuk ditampilkan di browser

            // pindahkan
            if (move_uploaded_file($f['tmp_name'], $targetPath)) {
                $result['success'] = true;
                $result['messages'][] = "File berhasil dipindahkan ke: $targetPath";
                $result['file'] = [
                    'original_name' => $originalName,
                    'saved_name' => $finalName,
                    'size_bytes' => $f['size'],
                    'size_readable' => human_filesize($f['size']),
                    'relative_path' => $relativePath,
                    'uploaded_at' => date('Y-m-d H:i:s')
                ];
            } else {
                $result['messages'][] = "Gagal memindahkan file ke folder uploads. Cek permission dan path. targetPath=$targetPath";
            }
        }
    }
}

// TAMPILKAN HALAMAN OUTPUT (debug + hasil)
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Hasil Upload — Debug</title>
  <style>
    body{font-family:Arial, sans-serif;margin:30px;background:#f4f6f8}
    .wrap{max-width:900px;margin:auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 10px rgba(0,0,0,0.06)}
    .ok{background:#e9f8ee;padding:12px;border:1px solid #c6eed1;color:#145a2f;border-radius:6px}
    .err{background:#fff0f0;padding:12px;border:1px solid #f0c2c2;color:#7a1a1a;border-radius:6px}
    pre{background:#f7f7f7;padding:12px;border-radius:6px;overflow:auto}
    table{width:100%;border-collapse:collapse;margin-top:10px}
    th,td{padding:8px;border-bottom:1px solid #eee;text-align:left}
    a.btn{display:inline-block;padding:8px 12px;background:#0b6;color:#fff;border-radius:6px;text-decoration:none}
  </style>
</head>
<body>
  <div class="wrap">
    <h2>Hasil Proses Upload</h2>

    <?php if ($result['success']): ?>
      <div class="ok">✅ Upload berhasil.</div>
      <h3>Info File</h3>
      <table>
        <tr><th>Nama asli</th><td><?=htmlspecialchars($result['file']['original_name'])?></td></tr>
        <tr><th>Nama disimpan</th><td><?=htmlspecialchars($result['file']['saved_name'])?></td></tr>
        <tr><th>Ukuran</th><td><?=htmlspecialchars($result['file']['size_readable'])?> (<?=htmlspecialchars($result['file']['size_bytes'])?> bytes)</td></tr>
        <tr><th>Path relatif (untuk link)</th><td><?=htmlspecialchars($result['file']['relative_path'])?></td></tr>
        <tr><th>Waktu upload</th><td><?=htmlspecialchars($result['file']['uploaded_at'])?></td></tr>
      </table>

      <?php
        // preview jika gambar
        $ext = strtolower(pathinfo($result['file']['saved_name'], PATHINFO_EXTENSION));
        if (in_array($ext, ['jpg','jpeg','png','gif'])):
      ?>
        <h4>Preview:</h4>
        <img src="<?=htmlspecialchars($result['file']['relative_path'])?>" alt="preview" style="max-width:100%;border:1px solid #ddd;padding:6px;border-radius:6px">
      <?php endif; ?>

      <p style="margin-top:14px;">
        <a class="btn" href="<?=htmlspecialchars($result['file']['relative_path'])?>" target="_blank">Buka / Download</a>
        <a class="btn" href="fileupload.php" style="background:#888;margin-left:8px">Unggah Lagi</a>
      </p>

    <?php else: ?>
      <div class="err">❌ Upload gagal. Lihat pesan di bawah untuk detil.</div>
      <h3>Pesan</h3>
      <ul>
        <?php foreach($result['messages'] as $m): ?>
          <li><?=htmlspecialchars($m)?></li>
        <?php endforeach; ?>
      </ul>
      <p><a class="btn" href="fileupload.php">Kembali ke Form</a></p>
    <?php endif; ?>

    <hr>
    <h3>Debug environment (bantu troubleshooting)</h3>
    <table>
      <?php foreach($phpInfo as $k=>$v): ?>
        <tr><th><?=htmlspecialchars($k)?></th><td><?=htmlspecialchars($v)?></td></tr>
      <?php endforeach; ?>
    </table>

    <h4>$_FILES (raw)</h4>
    <pre><?=htmlspecialchars(var_export($_FILES, true))?></pre>

  </div>
</body>
</html>
