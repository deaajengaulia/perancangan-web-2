<html>
<head>
    <title>Buku Tamu</title>
</head>
<body style="font-family: Arial; margin: 40px;">
    <?php
        $nama     = $_POST["nama"];
        $email    = $_POST["email"];
        $komentar = $_POST["komentar"];
    ?>

    <h1 align="center">Data Buku Tamu</h1>
    <hr><br>

    <table cellpadding="8" cellspacing="5" align="center" border="0">
        <tr>
            <td><strong>Nama Anda</strong></td>
            <td>:</td>
            <td><?php echo $nama; ?></td>
        </tr>
        <tr>
            <td><strong>Email Address</strong></td>
            <td>:</td>
            <td><?php echo $email; ?></td>
        </tr>
        <tr valign="top">
            <td><strong>Komentar</strong></td>
            <td>:</td>
            <td>
                <textarea name="komentar" cols="40" rows="5" readonly><?php echo $komentar; ?></textarea>
            </td>
        </tr>
    </table>
</body>
</html>
