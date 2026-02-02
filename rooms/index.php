<?php
require '../middleware/auth.php';
require '../config/database.php';
if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

$rooms = $conn->query("SELECT * FROM rooms ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Ruangan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">
  <h2 style="margin:0 0 8px;">Manajemen Ruangan</h2>
  <p style="margin:0 0 18px;color:#a1a1aa;"></p>

  <div class="card" style="padding:18px;margin-bottom:16px;">
    <form id="form-room" method="POST" action="store.php" style="display:grid;gap:12px;grid-template-columns:repeat(4,1fr);">
      <input class="input" name="name" placeholder="Nama Ruangan" required>
      <input class="input" name="location" placeholder="Lokasi">
      <input class="input" type="number" name="capacity" placeholder="Kapasitas">
      <input class="input" name="facilities" placeholder="Fasilitas (AC, Proyektor)">
      <div style="grid-column:1/-1;">
        <button class="btn btn-primary" type="submit">Tambah Ruangan (Create)</button>
      </div>
    </form>
  </div>

  <div class="card" style="padding:0;overflow:hidden;">
    <table class="table">
      <tr>
        <th>Nama</th><th>Lokasi</th><th>Kapasitas</th><th>Fasilitas</th><th>Aksi</th>
      </tr>

      <?php while($r = $rooms->fetch_assoc()): ?>
        <tr class="row-hover">
          <td><?= htmlspecialchars($r['name']) ?></td>
          <td><?= htmlspecialchars($r['location']) ?></td>
          <td><?= (int)$r['capacity'] ?></td>
          <td><?= htmlspecialchars($r['facilities']) ?></td>
          <td style="display:flex;gap:10px;flex-wrap:wrap;">
            <a class="btn" href="edit.php?id=<?= (int)$r['id'] ?>">Edit (Update)</a>

            <form method="POST" action="delete.php" style="display:inline;">
              <input type="hidden" name="id" value="<?= (int)$r['id'] ?>">
              <button class="btn" type="submit" onclick="return confirm('Hapus ruangan?')">Hapus (Delete)</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>

    </table>
  </div>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
