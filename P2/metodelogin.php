<!DOCTYPE html>
<html>
<head>
  <title>Contoh Form dengan POST</title>
</head>
<body>
  <h1>Only for authorized user</h1>
  <hr>
  <form action="proc_login.php" method="post">
    <p>
      Username :
      <input type="text" name="username">
    </p>
    <p>
      Password :
      <input type="password" name="password">
    </p>
    <p>
      <input type="submit" value="Login">
    </p>
  </form>
</body>
</html>
