<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>LUMIERE — Sistem Penjadwalan Ruangan</title>
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="container hero">
  <div class="pill" style="margin:0 auto;justify-content:center;">
    ✨ Modern • Terstruktur • Andal
  </div>

  <h1>
    Sistem Penjadwalan Ruangan<br/>
    
  </h1>

  <p>
    <b>LUMIERE</b> dirancang untuk membantu institusi dalam mengelola penggunaan
    ruangan secara terorganisir. Setiap pemesanan dicatat dengan jelas,
    sehingga jadwal lebih tertib dan mudah dipantau.
  </p>

  <div style="display:flex;justify-content:center;gap:12px;flex-wrap:wrap;">
    <a href="auth/register.php" class="btn btn-primary">Mulai Sekarang</a>
    <a href="login.php" class="btn">Masuk</a>
  </div>
</div>

<div class="container section" id="fitur">
  <h2 class="section-title">Fitur Utama</h2>
  <p class="section-sub">
    Fitur inti yang mendukung pengelolaan jadwal ruangan secara efisien.
  </p>

  <div class="grid-3">
    <div class="card feature">
      <h3>Manajemen Pemesanan</h3>
      <p>
        Mengelola pengajuan pemesanan ruangan dengan alur yang jelas dan terstruktur.
      </p>
    </div>

    <div class="card feature">
      <h3>Jadwal Terpusat</h3>
      <p>
        Seluruh aktivitas penggunaan ruangan dapat dilihat dalam satu tampilan jadwal.
      </p>
    </div>

    <div class="card feature">
      <h3>Kontrol Akses</h3>
      <p>
        Peran pengguna dan admin dibedakan untuk menjaga keteraturan dan keamanan data.
      </p>
    </div>
  </div>
</div>

<div class="container section" id="cara-kerja">
  <h2 class="section-title">Alur Penggunaan</h2>
  <p class="section-sub">
    Proses sederhana yang mudah dipahami oleh pengguna maupun pengelola.
  </p>

  <div class="grid-3">
    <div class="card feature">
      <h3>1) Akses Sistem</h3>
      <p>
        Pengguna masuk ke sistem menggunakan akun yang telah terdaftar.
      </p>
    </div>

    <div class="card feature">
      <h3>2) Ajukan Pemesanan</h3>
      <p>
        Pemesanan ruangan dilakukan sesuai kebutuhan dan ketersediaan jadwal.
      </p>
    </div>

    <div class="card feature">
      <h3>3) Pengelolaan Jadwal</h3>
      <p>
        Pengelola memastikan penggunaan ruangan berjalan tertib sesuai jadwal.
      </p>
    </div>
  </div>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>

</body>
</html>
