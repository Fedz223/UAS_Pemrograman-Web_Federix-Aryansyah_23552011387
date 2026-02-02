<?php
require 'middleware/auth.php';
require 'config/database.php';

$user = $_SESSION['user'];

$totalRooms = (int)($conn->query("SELECT COUNT(*) total FROM rooms")->fetch_assoc()['total'] ?? 0);
$todayBookings = (int)($conn->query("SELECT COUNT(*) total FROM bookings WHERE date = CURDATE()")->fetch_assoc()['total'] ?? 0);
$weeklyBookings = (int)($conn->query("SELECT COUNT(*) total FROM bookings WHERE date BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 7 DAY)")->fetch_assoc()['total'] ?? 0);
$myBookings = (int)($conn->query("SELECT COUNT(*) total FROM bookings WHERE created_by = {$user['id']}")->fetch_assoc()['total'] ?? 0);

$conflicts = 0;
if ($user['role'] === 'admin') {
  $conflicts = (int)($conn->query("
    SELECT COUNT(*) total FROM bookings b1
    JOIN bookings b2 ON b1.room_id=b2.room_id
      AND b1.id<>b2.id
      AND b1.date=b2.date
      AND (b1.start_time < b2.end_time AND b1.end_time > b2.start_time)
  ")->fetch_assoc()['total'] ?? 0);
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Dasbor</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">

  <?php if ($user['role'] === 'admin'): ?>
    <h2 style="margin:0 0 6px;">Dasbor Admin</h2>
    <p style="color:#a1a1aa;margin:0 0 18px;">Kelola ruangan, pemesanan, dan laporan.</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;">
      <div class="card feature">
        <h3>Total Ruangan</h3>
        <p style="font-size:34px;margin:8px 0 0;"><?= $totalRooms ?></p>
      </div>
      <div class="card feature">
        <h3>Pemesanan Hari Ini</h3>
        <p style="font-size:34px;margin:8px 0 0;"><?= $todayBookings ?></p>
      </div>
      <div class="card feature">
        <h3>Pemesanan 7 Hari</h3>
        <p style="font-size:34px;margin:8px 0 0;"><?= $weeklyBookings ?></p>
      </div>
    </div>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:18px;">
      <div class="card" style="padding:18px;">
        <h3 style="margin:0 0 10px;">Manajemen Ruangan </h3>
        <p style="color:#a1a1aa;margin:0;">Tambah, edit, hapus data ruangan.</p>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <a class="btn" href="rooms/index.php">Lihat (Read)</a>
          <a class="btn btn-primary" href="rooms/index.php#form-room">Tambah (Create)</a>
        </div>
      </div>

      <div class="card" style="padding:18px;">
        <h3 style="margin:0 0 10px;">Pemesanan </h3>
        <p style="color:#a1a1aa;margin:0;">Setujui/Batalkan dan kelola booking.</p>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <a class="btn btn-primary" href="bookings/index.php">Kelola Pemesanan</a>
        </div>
      </div>

      <div class="card" style="padding:18px;">
        <h3 style="margin:0 0 10px;">Laporan </h3>
        <p style="color:#a1a1aa;margin:0;">Unduh laporan berdasarkan periode.</p>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <a class="btn btn-primary" href="reports/index.php">Buka Laporan</a>
        </div>
      </div>
    </div>

    <div class="card" style="padding:18px;margin-top:18px;border:1px solid rgba(239,68,68,.45);">
      <h3 style="margin:0;">Deteksi Bentrokan Jadwal</h3>
      <p style="color:#a1a1aa;margin:10px 0 0;">Indikasi bentrok: <b style="color:#ef4444;"><?= $conflicts ?></b></p>
      <p style="color:#71717a;margin:6px 0 0;font-size:13px;">Bentrokan terjadi jika waktu overlap pada ruangan & tanggal yang sama.</p>
    </div>

  <?php else: ?>
    <h2 style="margin:0 0 6px;">Dasbor Pengguna</h2>
    <p style="color:#a1a1aa;margin:0 0 18px;">Kelola pemesanan ruangan dan pantau status pengajuan.</p>

    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:18px;">
      <div class="card" style="padding:18px;">
        <h3 style="margin:0 0 10px;">Pemesanan Saya</h3>
        <div style="font-size:38px;font-weight:700;"><?= $myBookings ?></div>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <a class="btn" href="bookings/index.php">Lihat (Read)</a>
          <a class="btn btn-primary" href="bookings/index.php#form-booking">Tambah (Create)</a>
        </div>
      </div>

      <div class="card" style="padding:18px;">
        <h3 style="margin:0 0 10px;">Jadwal Ruangan</h3>
        <p style="color:#a1a1aa;margin:0;">Cek ketersediaan sebelum memesan.</p>
        <div style="margin-top:14px;display:flex;gap:10px;flex-wrap:wrap;">
          <a class="btn btn-primary" href="schedule.php">Buka Jadwal</a>
        </div>
      </div>

      <div class="card" style="padding:18px;">
  <h3 style="margin:0 0 10px;">Status Pemesanan</h3>
  <p style="color:#a1a1aa;margin:0;">
    Kelola pemesanan Anda di menu <b>Pemesanan</b>.
  </p>
</div>

      </div>
    </div>
  <?php endif; ?>

</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
