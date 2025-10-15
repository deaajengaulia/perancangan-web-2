<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Hasil Banding Nilai</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <style>
    body {
      font-family: Arial, sans-serif;
      background:#f4f6f8;
      margin: 60px;
    }
    .card {
      width: 620px;
      max-width: 95%;
      margin: auto;
      background: #fff;
      padding: 28px 30px;
      border-radius: 10px;
      box-shadow: 0 6px 18px rgba(0,0,0,0.06);
    }
    h1 {
      margin: 0 0 10px 0;
      text-align: center;
      color: #333;
    }
    .table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 18px;
    }
    .table td {
      padding: 10px 12px;
      vertical-align: top;
      border-bottom: 1px solid #eef1f4;
    }
    .label {
      width: 160px;
      font-weight: 700;
      color: #444;
    }
    .value {
      color: #222;
    }
    .result {
      margin-top: 18px;
      padding: 14px;
      border-radius: 8px;
      background: #f1f8ff;
      color: #0b66d1;
      font-weight: 700;
      text-align: center;
    }
    .back {
      margin-top: 20px;
      text-align: center;
    }
    .btn {
      display: inline-block;
      padding: 10px 16px;
      border-radius: 6px;
      background: #007bff;
      color: #fff;
      text-decoration: none;
      font-weight: 600;
    }
    .error {
      margin-top: 12px;
      padding: 12px;
      background: #fff4f4;
      color: #b71c1c;
      border-radius: 8px;
      text-align:center;
      font-weight:600;
    }
  </style>
</head>
<body>
  <div class="card">
    <h1>Hasil Banding Nilai</h1>

    <?php
      // ambil data POST dengan aman
      $raw1 = isset($_POST['bil1']) ? trim($_POST['bil1']) : '';
      $raw2 = isset($_POST['bil2']) ? trim($_POST['bil2']) : '';

      // fungsi bantu untuk menampilkan aman ke HTML
      function h($s) { return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }

      // validasi: pastikan input tidak kosong
      if ($raw1 === '' || $raw2 === '') {
        echo '<div class="error">Silakan isi kedua bilangan terlebih dahulu.</div>';
      } else {
        // cek apakah keduanya angka (boleh desimal), pakai filter_var setelah mengganti koma dengan titik
        $norm1 = str_replace(',', '.', $raw1);
        $norm2 = str_replace(',', '.', $raw2);

        $isNum1 = is_numeric($norm1);
        $isNum2 = is_numeric($norm2);

        if (! $isNum1 || ! $isNum2) {
          echo '<div class="error">Input harus berupa angka (contoh: 10, 3.14 atau 2,5). Periksa kembali.</div>';
        } else {
          // konversi ke float atau int sesuai kebutuhan
          $num1 = $norm1 + 0; // otomatis jadi int/float
          $num2 = $norm2 + 0;

          // tampilkan nilai asli yang dimasukkan
          echo '<table class="table">';
          echo '<tr><td class="label">Bilangan I</td><td class="value">'.h($raw1).'</td></tr>';
          echo '<tr><td class="label">Bilangan II</td><td class="value">'.h($raw2).'</td></tr>';
          echo '</table>';

          // bandingkan dengan penanganan desimal
          if ($num1 > $num2) {
            $pesan = "Bilangan I lebih besar dari Bilangan II.";
          } elseif ($num1 < $num2) {
            $pesan = "Bilangan II lebih besar dari Bilangan I.";
          } else {
            $pesan = "Kedua bilangan sama nilainya.";
          }

          echo '<div class="result">'.h($pesan).'</div>';
        }
      }
    ?>

    <div class="back">
      <a class="btn" href="formbandingnilai.html">&larr; Kembali ke Form</a>
    </div>
  </div>
</body>
</html>
