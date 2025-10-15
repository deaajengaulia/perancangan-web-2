<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <title>Hasil Banding Nilai</title>
</head>
<body>
  <h1>Hasil Banding Nilai</h1>

  <?php
    // Ambil data dari form
    $bil1 = isset($_POST['bil1']) ? trim($_POST['bil1']) : '';
    $bil2 = isset($_POST['bil2']) ? trim($_POST['bil2']) : '';

    if ($bil1 === '' || $bil2 === '') {
        echo "<p><b>Silakan isi kedua bilangan terlebih dahulu.</b></p>";
    } elseif (!is_numeric(str_replace(',', '.', $bil1)) || !is_numeric(str_replace(',', '.', $bil2))) {
        echo "<p><b>Input harus berupa angka. Contoh: 5, 3.14, atau 10.</b></p>";
    } else {
        // Ubah koma menjadi titik agar bisa terbaca sebagai desimal
        $bil1 = str_replace(',', '.', $bil1);
        $bil2 = str_replace(',', '.', $bil2);

        $num1 = $bil1 + 0;
        $num2 = $bil2 + 0;

        echo "<p>Bilangan I: <b>$num1</b></p>";
        echo "<p>Bilangan II: <b>$num2</b></p>";

        if ($num1 > $num2) {
            echo "<p><b>Bilangan I lebih besar dari Bilangan II.</b></p>";
        } elseif ($num1 < $num2) {
            echo "<p><b>Bilangan II lebih besar dari Bilangan I.</b></p>";
        } else {
            echo "<p><b>Kedua bilangan sama nilainya.</b></p>";
        }
    }
  ?>

  <p><a href="formbandingnilai.php">← Kembali ke Form</a></p>
</body>
</html>
