<?php
session_start();
require 'koneksi.php';

// Ambil data dari form
$email = trim($_POST['email']);
$password = $_POST['password'];

// Cek user di database
$sql = "SELECT * FROM user WHERE email = ?";
$stmt = $koneksi->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verifikasi password
    if (password_verify($password, $user['password'])) {
        // Login sukses
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_role'] = $user['role'];

        // Redirect sesuai role
        if ($user['role'] == 'admin') {
            header("Location: index2.php");
        } elseif ($user['role'] == 'karyawan') {
            header("Location: index2.php");
        } else {
            header("Location: index2.php");
        }
        exit;
    } else {
        // Password salah
        echo "<script>alert('Password salah');window.location='login.php';</script>";
    }
} else {
    // Email tidak ditemukan
    echo "<script>alert('Email tidak terdaftar');window.location='login.php';</script>";
}
?>
