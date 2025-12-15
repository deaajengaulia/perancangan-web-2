<?php
include "koneksi.php";
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['register'])){
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $token = md5(uniqid());

    $simpan = mysqli_query($koneksi, "INSERT INTO user (email,password,verify_token,is_verified) VALUES ('$email','$password','$token',0)");

    if(!$simpan){
        die("Gagal register: ".mysqli_error($koneksi));
    }

    // Kirim email verifikasi
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'deaaulia326@gmail.com';
        $mail->Password = 'oagfsxpeedrqlvcd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('deaaulia326@gmail.com','Caffe Decana');
        $mail->addAddress($email);

        $link = "http://localhost/webdea/verify.php?token=$token";
        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Akun Caffe Decana';
        $mail->Body = "<h3>Verifikasi Akun</h3><p>Klik link berikut:</p><a href='$link'>$link</a>";
        $mail->send();

        echo "<script>alert('Registrasi berhasil! Cek email untuk verifikasi.');window.location='login.php';</script>";
    } catch (Exception $e){
        echo "Email gagal dikirim: {$mail->ErrorInfo}";
    }
}
?>
