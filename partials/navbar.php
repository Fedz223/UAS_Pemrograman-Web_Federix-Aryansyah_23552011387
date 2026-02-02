<?php
$user = $_SESSION['user'] ?? null;
?>
<div class="nav">
  <div class="container nav-inner">
    <div style="display:flex;align-items:center;gap:12px;">
      <a href="/lumiere/dashboard.php" style="display:flex;align-items:center;gap:10px;">
        <img src="/lumiere/assets/img/logo.svg" height="34" alt="Lumiere">
      </a>
      <span class="pill">LUMIERE • Penjadwalan Ruangan</span>
    </div>

    <div class="nav-links">
      <?php if ($user): ?>
        <a href="/lumiere/dashboard.php">Dasbor</a>
        <a href="/lumiere/schedule.php">Jadwal</a>
        <a href="/lumiere/bookings/index.php">Pemesanan</a>
        <?php if ($user['role'] === 'admin'): ?>
          <a href="/lumiere/rooms/index.php">Ruangan</a>
          <a href="/lumiere/reports/index.php">Laporan</a>
        <?php endif; ?>
        <span class="pill"><?= htmlspecialchars($user['name']) ?> • <?= htmlspecialchars($user['role']) ?></span>
        <a class="btn" href="/lumiere/auth/logout.php">Keluar</a>
      <?php else: ?>
        <a href="/lumiere/index.php#fitur">Fitur</a>
        <a href="/lumiere/index.php#cara-kerja">Cara Kerja</a>
        <a class="btn" href="/lumiere/login.php">Masuk</a>
        <a class="btn btn-primary" href="/lumiere/register.php">Mulai Sekarang</a>
      <?php endif; ?>
    </div>
  </div>
</div>
