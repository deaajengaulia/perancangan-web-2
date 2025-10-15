<html>
<head>
    <title>Contoh Form dengan POST</title>
</head>
<body style="font-family: Arial; margin: 40px;">
    <h1 align="center">Buku Tamu</h1>
    <p align="center">
        Komentar dan saran sangat kami butuhkan untuk meningkatkan kualitas situs kami.
    </p>
    <hr><br>

    <form action="postbukutamu.php" method="post">
        <table cellpadding="8" cellspacing="5" align="center" border="0">
            <tr>
                <td>Nama Anda</td>
                <td>:</td>
                <td><input type="text" name="nama" size="30" maxlength="50"></td>
            </tr>
            <tr>
                <td>Email Address</td>
                <td>:</td>
                <td><input type="text" name="email" size="30" maxlength="50"></td>
            </tr>
            <tr>
                <td>Komentar</td>
                <td>:</td>
                <td><textarea name="komentar" cols="40" rows="5"></textarea></td>
            </tr>
            <tr align="center">
                <td colspan="3">
                    <input type="submit" value="Kirim">
                    &nbsp;&nbsp;
                    <input type="reset" value="Ulangi">
                </td>
            </tr>
        </table>
    </form>
</body>
</html>
