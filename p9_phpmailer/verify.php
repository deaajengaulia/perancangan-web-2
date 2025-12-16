<?php
include "koneksi.php";

if(isset($_GET['token'])){
    $token = $_GET['token'];

    // Periksa kolom verify_token, bukan token
    $stmt = $koneksi->prepare("SELECT * FROM user WHERE verify_token=?");
    if(!$stmt){
        die("Prepare failed: " . $koneksi->error);
    }

    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows === 1){
        $stmt = $koneksi->prepare("UPDATE user SET is_verified=1 WHERE verify_token=?");
        if(!$stmt){
            die("Prepare failed: " . $koneksi->error);
        }
        $stmt->bind_param("s", $token);
        $stmt->execute();
        echo "<script>alert('Akun berhasil diverifikasi!');window.location='login.php';</script>";
    } else {
        echo "Token tidak valid";
    }
} else {
    echo "Token kosong";
}
?>
