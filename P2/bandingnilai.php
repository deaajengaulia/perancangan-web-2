<?php
// fileupload.php
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Form Upload File</title>
  <style>
    body{font-family:Arial, sans-serif; margin:30px;}
    .card{max-width:600px;margin:auto;padding:20px;border-radius:8px;border:1px solid #ccc;}
    label{display:block;margin-bottom:6px;font-weight:600}
    input[type=file]{width:100%}
    .btn{margin-top:12px;padding:10px 14px;border:1px solid #000;border-radius:6px;cursor:pointer}
    .note{font-size:13px;margin-top:8px}
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
