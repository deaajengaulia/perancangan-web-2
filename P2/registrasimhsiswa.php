<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Form Registrasi Mahasiswa Baru</title>
</head>
<body>
  <h2>Form Registrasi Mahasiswa Baru</h2>
  <hr>
  <form action="postregistmhsiswa.php" method="post">
    <label>NIM:</label><br>
    <input type="text" name="nim"><br><br>

    <label>Nama Lengkap:</label><br>
    <input type="text" name="nama"><br><br>

    <label>Program Studi:</label><br>
    <input type="text" name="prodi"><br><br>

    <label>Email:</label><br>
    <input type="email" name="email"><br><br>

    <label>Alamat:</label><br>
    <textarea name="alamat" rows="4" cols="30"></textarea><br><br>

    <input type="submit" value="Daftar Sekarang">
  </form>
</body>
</html>
