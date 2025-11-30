<?php
session_start();
?>
<html>
<body>
<h2>Anda memasuki halaman kedua</h2>
<?php
if (isset($_SESSION["nama"]) && isset($_SESSION["umur"]) && isset($_SESSION["email"])) {
    echo "Nama Anda: " . $_SESSION["nama"] . "<br>";
    echo "Umur Anda saat ini adalah: " . $_SESSION["umur"] . " tahun<br>";
    echo "Alamat email Anda adalah: " . $_SESSION["email"] . "<br>";
} else {
    echo "Data session tidak ditemukan!<br>";
}
?>
<br>
<a href="data.php">Klik disini</a> untuk menuju ke halaman awal.
<?php
session_destroy();
?>
</body>
</html>
