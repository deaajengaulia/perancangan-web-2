<?php
// login.php
session_start();
$usersFile = __DIR__ . DIRECTORY_SEPARATOR . 'users.json';

// Ensure users.json exists and create default admin if needed
function ensure_users_and_admin($usersFile) {
    $users = [];
    if (file_exists($usersFile)) {
        $raw = @file_get_contents($usersFile);
        $decoded = json_decode($raw, true);
        if (is_array($decoded)) $users = $decoded;
    }
    // create default admin if missing
    $hasAdmin = false;
    foreach ($users as $u) {
        if (!empty($u['role']) && $u['role'] === 'admin') { $hasAdmin = true; break; }
    }
    if (!$hasAdmin) {
        $key = mb_strtolower('admin@decana.com');
        $users[$key] = [
            'email' => 'admin@decana.com',
            'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('c')
        ];
        $tmp = $usersFile . '.tmp';
        file_put_contents($tmp, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        @rename($tmp, $usersFile);
    }
    return $users;
}

$users = ensure_users_and_admin($usersFile);

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';

    if ($email === '' || $password === '') {
        $error = 'Email dan password wajib diisi.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Format email tidak valid.';
    } else {
        $key = mb_strtolower($email);
        if (!isset($users[$key])) {
            $error = 'Email atau password salah.';
        } else {
            $user = $users[$key];
            $verified = false;

            if (!empty($user['password_hash'])) {
                if (password_verify($password, $user['password_hash'])) {
                    $verified = true;
                    if (password_needs_rehash($user['password_hash'], PASSWORD_DEFAULT)) {
                        $users[$key]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                        $tmp = $usersFile . '.tmp';
                        file_put_contents($tmp, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                        @rename($tmp, $usersFile);
                    }
                }
            } elseif (!empty($user['password'])) {
                // legacy plain password: fallback (upgrade)
                if ($password === $user['password']) {
                    $verified = true;
                    $users[$key]['password_hash'] = password_hash($password, PASSWORD_DEFAULT);
                    unset($users[$key]['password']);
                    $tmp = $usersFile . '.tmp';
                    file_put_contents($tmp, json_encode($users, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
                    @rename($tmp, $usersFile);
                }
            } else {
                $error = 'Akun tidak dapat diautentikasi.';
            }

            if ($verified) {
                $_SESSION['user_email'] = $user['email'];
                $_SESSION['user_role'] = isset($user['role']) ? $user['role'] : 'user';
                $_SESSION['logged_in_at'] = time();

                // Redirect by role:
                // - admin -> admin.php
                // - karyawan -> karyawan.php
                // - user -> index.php (beranda)
                if ($_SESSION['user_role'] === 'admin') {
                    header('Location: admin.php');
                    exit;
                } elseif ($_SESSION['user_role'] === 'karyawan') {
                    header('Location: karyawan.php');
                    exit;
                } else {
                    header('Location: index.php');
                    exit;
                }
            } else {
                if ($error === '') $error = 'Email atau password salah.';
            }
        }
    }
}

$msg = '';
if (!empty($_GET['msg'])) {
    $msg = htmlspecialchars($_GET['msg'], ENT_QUOTES | ENT_SUBSTITUTE);
}
?>
<!doctype html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - DECANA Caffe & Resto</title>
  <style>
    body{font-family:Arial,Helvetica,sans-serif;background:#f8eee2;display:flex;align-items:center;justify-content:center;height:100vh;margin:0}
    .container{background:#fff;padding:24px;border-radius:10px;box-shadow:0 6px 20px rgba(0,0,0,.12);width:360px}
    h2{text-align:center;color:#7b3f00;margin:0 0 12px}
    label{display:block;margin-top:8px;font-weight:600}
    input{width:100%;padding:10px;border-radius:6px;border:1px solid #ccc;box-sizing:border-box;margin-top:6px}
    button{background:#7b3f00;color:#fff;padding:10px;border:none;border-radius:6px;width:100%;margin-top:12px;cursor:pointer;font-weight:700}
    .link{text-align:center;margin-top:12px}
    .msg{margin-top:8px;text-align:center;min-height:18px}
    .msg.error{color:#b02a2a}
    .msg.ok{color:#1b7a2b}
  </style>
</head>
<body>
  <div class="container">
    <h2>Login ke DECANA</h2>

    <?php if ($msg !== ''): ?>
      <div class="msg ok"><?= $msg ?></div>
    <?php endif; ?>

    <?php if ($error !== ''): ?>
      <div class="msg error"><?= htmlspecialchars($error, ENT_QUOTES | ENT_SUBSTITUTE) ?></div>
    <?php endif; ?>

    <form method="post" action="login.php" autocomplete="off" novalidate>
      <label for="email">Email</label>
      <input id="email" name="email" type="email" placeholder="name@domain.com" required>

      <label for="password">Password</label>
      <input id="password" name="password" type="password" placeholder="Masukkan password" required>

      <button type="submit">Masuk</button>
    </form>

    <div class="link">Belum punya akun? <a href="register.php">Daftar di sini</a></div>
  </div>
</body>
</html>
