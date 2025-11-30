<?php
session_start();
$nama  = isset($_POST["nama"]) ? $_POST["nama"] : "";
$umur  = isset($_POST["umur"]) ? $_POST["umur"] : "";
$email = isset($_POST["email"]) ? $_POST["email"] : "";
$waktu = isset($_POST["waktu"]) ? $_POST["waktu"] : "";
$_SESSION["nama"]  = $nama;
$_SESSION["umur"]  = $umur;
$_SESSION["email"] = $email;
$_SESSION["waktu"] = $waktu;
?>
<html>
<body>
<?php
echo "<h1>Hallo " . $_SESSION["nama"] . "</h1>";
?>
<h2>Selamat Datang Di Situs Kami</h2>
<?php
echo "Umur Anda saat ini adalah " . $_SESSION["umur"] . " tahun <br>";
echo "Alamat email Anda adalah " . $_SESSION["email"] . "<br>";
?>
<br>
<a href="http://localhost/praktikweb2/praktik6/next.php">Klik di sini</a> untuk menuju ke halaman berikutnya.
</body>
</html>
