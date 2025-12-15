<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Register | Caffe Decana</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex justify-content-center align-items-center" style="height:100vh">
<div class="col-md-4">
<div class="card shadow">
<div class="card-body">
<h4 class="text-center mb-3">Daftar Akun</h4>
<form action="proses_register.php" method="post">
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Password</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button class="btn btn-success w-100" type="submit" name="register">Register</button>
</form>
<p class="text-center mt-3">
<a href="login.php">Sudah punya akun?</a>
</p>
</div>
</div>
</div>
</body>
</html>
