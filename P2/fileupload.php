<?php
// fileupload.php
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Form Upload File</title>
  <style>
    body{font-family:Arial, sans-serif; margin:30px; background:#f7f7f7}
    .card{max-width:600px;margin:auto;background:#fff;padding:20px;border-radius:8px;box-shadow:0 2px 8px rgba(0,0,0,0.06)}
    label{display:block;margin-bottom:6px;font-weight:600}
    input[type=file]{width:100%}
    .btn{margin-top:12px;background:#0b6;color:#fff;padding:10px 14px;border:none;border-radius:6px;cursor:pointer}
    .note{font-size:13px;color:#555;margin-top:8px}
  </style>
</head>
<body>
  <div class="card">
    <h2>Input nama file untuk Upload</h2>
    <form action="postfileupload.php" method="post" enctype="multipart/form-data">
      <label for="file1">Pilih file:</label>
      <input type="file" name="file1" id="file1" required>
      <br>
      <button class="btn" type="submit">Upload</button>
    </form>
    <p class="note">Jika masih error, lihat halaman hasil (postfileupload.php) — skrip menampilkan informasi debug yang membantu.</p>
  </div>
</body>
</html>
