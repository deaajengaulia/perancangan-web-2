<?php
$host     = "localhost";
$user     = "root";      // default user XAMPP
$pass     = "";          // default password XAMPP biasanya kosong
$db       = "caffe_decana";

// Membuat koneksi
$koneksi = mysqli_connect($host, $user, $pass, $db);

// Cek koneksi
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

echo "Koneksi berhasil!";
?>
