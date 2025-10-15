<!DOCTYPE html>
<html>
<head>
  <title>Proses Input</title>
</head>
<body>
  <h1>Hasil Input Login</h1>
  <hr>
  <?php
  $username = $_POST["username"];
  $password = $_POST["password"];
  ?>
  <p>Username : <strong><?php echo htmlspecialchars($username); ?></strong></p>
  <p>Password : <strong><?php echo htmlspecialchars($password); ?></strong></p>
</body>
</html>
