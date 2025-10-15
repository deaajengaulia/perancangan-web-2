<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Banding Nilai</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background:#f4f6f8;
      margin: 60px;
    }
    .card {
      width: 520px;
      max-width: 95%;
      margin: auto;
      background: #fff;
      padding: 28px 30px;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    h1 {
      margin: 0 0 12px 0;
      text-align: center;
      color: #333;
    }
    p.lead {
      margin: 0 0 20px 0;
      text-align: center;
      color: #555;
      font-size: 14px;
    }
    .row {
      display: flex;
      gap: 12px;
      margin-bottom: 14px;
      align-items: center;
    }
    .row label {
      width: 130px;
      font-weight: 600;
      color: #333;
    }
    input[type="text"] {
      flex: 1;
      padding: 10px 12px;
      border: 1px solid #cfd8dc;
      border-radius: 6px;
      font-size: 14px;
    }
    .actions {
      text-align: center;
      margin-top: 18px;
    }
    input[type="submit"], input[type="reset"] {
      padding: 10px 18px;
      border-radius: 6px;
      border: none;
      cursor: pointer;
      font-weight: 600;
    }
    input[type="submit"] {
      background: #007bff;
      color: #fff;
      margin-right: 10px;
    }
    input[type="reset"] {
      background: #6c757d;
      color: #fff;
    }
    .note {
      margin-top: 14px;
      color: #666;
      font-size: 13px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Banding Nilai</h1>
    <p class="lead">Masukkan dua bilangan. Sistem akan menampilkan mana yang lebih besar / kecil atau jika sama.</p>

    <form action="postbandingnilai.php" method="post" autocomplete="off">
      <div class="row">
        <label for="bil1">Bilangan I</label>
        <input id="bil1" name="bil1" type="text" placeholder="Masukkan bilangan pertama">
      </div>

      <div class="row">
        <label for="bil2">Bilangan II</label>
        <input id="bil2" name="bil2" type="text" placeholder="Masukkan bilangan kedua">
      </div>

      <div class="actions">
        <input type="submit" value="Bandingkan">
        <input type="reset" value="Bersihkan">
      </div>

      <div class="note">Format angka boleh bilangan bulat atau desimal (contoh: 10 atau 3.14).</div>
    </form>
  </div>
</body>
</html>
