<?php
require '../middleware/auth.php';
require '../config/database.php';

if ($_SESSION['user']['role'] !== 'admin') {
  die("Akses ditolak.");
}

$id = (int)($_GET['id'] ?? 0);
$room = $conn->query("SELECT * FROM rooms WHERE id=$id")->fetch_assoc();

if (!$room) {
  die("Data ruangan tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Edit Ruangan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">
  <div class="card" style="padding:18px;max-width:720px;">
    <h2 style="margin:0 0 12px;">Edit Ruangan</h2>

    <form method="POST" action="update.php" style="display:grid;gap:12px;">
      <input type="hidden" name="id" value="<?= (int)$room['id'] ?>">

      <input
        class="input"
        name="name"
        value="<?= htmlspecialchars($room['name']) ?>"
        placeholder="Nama Ruangan"
        required
      >

      <input
        class="input"
        name="location"
        value="<?= htmlspecialchars($room['location']) ?>"
        placeholder="Lokasi"
      >

      <input
        class="input"
        type="number"
        name="capacity"
        value="<?= (int)$room['capacity'] ?>"
        placeholder="Kapasitas"
      >

      <input
        class="input"
        name="facilities"
        value="<?= htmlspecialchars($room['facilities']) ?>"
        placeholder="Fasilitas"
      >

      <div style="display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a class="btn" href="index.php">Kembali</a>
      </div>
    </form>
  </div>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by
  23552011387_Federix_aryansyah_TIF-RP23_CNS_A_UASWEB1
</div>

</body>
</html>
