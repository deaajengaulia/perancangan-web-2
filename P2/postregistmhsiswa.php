<?php
// Pastikan data dikirim via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nim = $_POST['nim'];
  $nama = $_POST['nama'];
  $prodi = $_POST['prodi'];
  $email = $_POST['email'];
  $alamat = $_POST['alamat'];
} else {
  echo "Data tidak dikirim dengan benar!";
  exit;
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Data Registrasi Mahasiswa</title>
</head>
<body>
  <h2>Data Registrasi Mahasiswa Baru</h2>
  <hr>
  <p><b>NIM:</b> <?php echo $nim; ?></p>
  <p><b>Nama Lengkap:</b> <?php echo $nama; ?></p>
  <p><b>Program Studi:</b> <?php echo $prodi; ?></p>
  <p><b>Email:</b> <?php echo $email; ?></p>
  <p><b>Alamat:</b> <?php echo $alamat; ?></p>

  <br>
  <a href="registrasimhsiswa.php">← Kembali ke Form Registrasi</a>
</body>
</html>
