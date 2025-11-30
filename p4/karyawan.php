<?php
// karyawan.php
session_start();

// proteksi: hanya user login, dengan role karyawan atau admin
if (empty($_SESSION['user_email'])) {
    header('Location: login.php');
    exit;
}
$role = $_SESSION['user_role'] ?? 'user';
if (!in_array($role, ['karyawan', 'admin'])) {
    // jika bukan karyawan atau admin, kembalikan ke beranda
    header('Location: index.php');
    exit;
}

$usersFile = __DIR__ . DIRECTORY_SEPARATOR . 'users.json';
$attendanceFile = __DIR__ . DIRECTORY_SEPARATOR . 'attendance.json';

// ambil profil user dari users.json bila tersedia
$userEmail = mb_strtolower($_SESSION['user_email']);
$profile = ['email' => $userEmail, 'role' => $role];
if (file_exists($usersFile)) {
    $raw = @file_get_contents($usersFile);
    $decoded = json_decode($raw, true);
    if (is_array($decoded) && isset($decoded[$userEmail])) {
        $profile = $decoded[$userEmail];
    }
}

// ambil attendance
$attendance = [];
if (file_exists($attendanceFile)) {
    $raw2 = @file_get_contents($attendanceFile);
    $dec2 = json_decode($raw2, true);
    if (is_array($dec2)) $attendance = $dec2;
}
$userRecords = isset($attendance[$userEmail]) ? $attendance[$userEmail] : [];

function h($s){ return htmlspecialchars($s, ENT_QUOTES|ENT_SUBSTITUTE); }
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Halaman Pegawai - DECANA</title>
<style>
  body{font-family:Arial,Helvetica,sans-serif;background:#fffaf3;margin:0;padding:18px;color:#222}
  header{background:#5c3d2e;color:#fff;padding:12px;border-radius:8px}
  .wrap{max-width:900px;margin:18px auto}
  .card{background:#fff;padding:14px;border-radius:10px;box-shadow:0 6px 18px rgba(0,0,0,0.06);margin-bottom:12px}
  .btn{display:inline-block;padding:8px 10px;border-radius:8px;text-decoration:none;background:#7b3f00;color:#fff}
  .btn.alt{background:#fff;color:#7b3f00;border:1px solid #e8d9c9}
  .btn.ghost{background:transparent;color:#fff;border:1px solid rgba(255,255,255,0.2)}
  table{width:100%;border-collapse:collapse;margin-top:10px}
  th,td{padding:8px;border:1px solid #eee;text-align:left}
  th{background:#f5e8da}
  .small{font-size:13px;color:#666}
  .top-actions{display:flex;gap:8px;align-items:center;flex-wrap:wrap}
</style>
</head>
<body>
  <header>
    <strong>Portal Pegawai — DECANA</strong>
    <span style="float:right">
      <a class="btn" href="index.php">Ke Beranda</a>
      <a class="btn alt" href="logout.php">Logout</a>
    </span>
  </header>

  <div class="wrap">
    <div class="card">
      <h3>Profil Pegawai</h3>
      <p><strong>Email:</strong> <?= h($profile['email'] ?? $userEmail) ?></p>
      <p><strong>Role:</strong> <?= h($profile['role'] ?? $role) ?></p>
      <p class="small">Halaman ini hanya untuk pegawai (role <code>karyawan</code>) dan admin.</p>
    </div>

    <div class="card">
      <h3>Absensi / Kehadiran</h3>
      <div class="top-actions">
        <form method="post" action="attendance_action.php" style="display:inline-block;margin:0">
          <input type="hidden" name="action" value="clock_in">
          <button class="btn" type="submit">Clock In</button>
        </form>

        <form method="post" action="attendance_action.php" style="display:inline-block;margin:0">
          <input type="hidden" name="action" value="clock_out">
          <button class="btn alt" type="submit">Clock Out</button>
        </form>

        <a class="btn ghost" href="index.php">Lihat Menu & Beranda</a>
      </div>

      <h4 style="margin-top:12px">Riwayat Kehadiran Terakhir</h4>
      <?php if (empty($userRecords)): ?>
        <p class="small">Belum ada catatan hadir.</p>
      <?php else: ?>
        <table>
          <thead><tr><th>#</th><th>Tanggal / Waktu</th><th>Tipe</th></tr></thead>
          <tbody>
            <?php $i=0; foreach (array_reverse($userRecords) as $r): $i++; ?>
              <tr>
                <td><?= $i ?></td>
                <td><?= h($r['ts']) ?></td>
                <td><?= h($r['type']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </div>

    <div class="card">
      <h3>Tugas / Catatan</h3>
      <p class="small">Kolom ini bisa dipakai sebagai nota tugas, daftar pesanan, atau pengingat shift. Mau saya tambahkan modul task/shift di sini?</p>
    </div>
  </div>
</body>
</html>
