<?php
require '../middleware/auth.php';
if ($_SESSION['user']['role'] !== 'admin') {
  die("Access denied");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Laporan Pemesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">

  <!-- HEADER + NAVIGASI -->
  <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
    <div>
      <div style="color:#71717a;font-size:13px;margin-bottom:4px;">
        Dashboard / Laporan
      </div>
      <h2 style="margin:0;">Laporan Pemesanan</h2>
      <p style="margin:6px 0 0;color:#a1a1aa;">
        Ekspor laporan pemesanan ruangan berdasarkan rentang tanggal.
      </p>
    </div>

    <a href="/lumiere/dashboard.php" class="btn">
      ← Kembali ke Dashboard
    </a>
  </div>

  <!-- CARD LAPORAN -->
  <div class="card" style="padding:20px;max-width:720px;">

    <form method="GET" style="display:grid;gap:16px;">

      <!-- FILTER TANGGAL -->
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;">
        <div>
          <label style="font-size:13px;color:#a1a1aa;">Dari Tanggal</label>
          <input
            type="date"
            name="from"
            required
            class="input"
            style="width:100%;"
          >
        </div>

        <div>
          <label style="font-size:13px;color:#a1a1aa;">Sampai Tanggal</label>
          <input
            type="date"
            name="to"
            required
            class="input"
            style="width:100%;"
          >
        </div>
      </div>

      <!-- AKSI EXPORT -->
      <div style="display:flex;gap:12px;flex-wrap:wrap;margin-top:6px;">
        <button
          formaction="pdf.php"
          formmethod="GET"
          class="btn btn-primary"
        >
          Export PDF
        </button>

        <button
          formaction="excel.php"
          formmethod="GET"
          class="btn"
        >
          Export Excel
        </button>
      </div>

    </form>

    <p style="color:#71717a;font-size:12px;margin-top:14px;">
      Laporan berisi data: ruangan, tanggal, waktu, kegiatan, penanggung jawab, dan status pemesanan.
    </p>

  </div>

</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
