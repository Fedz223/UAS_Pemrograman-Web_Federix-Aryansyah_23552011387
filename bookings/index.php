<?php
require '../middleware/auth.php';
require '../config/database.php';

$user = $_SESSION['user'];

function badge($status){
  $color = "#a1a1aa";
  if ($status === 'approved') $color = "#22c55e";
  if ($status === 'pending') $color = "#f59e0b";
  if ($status === 'cancelled') $color = "#ef4444";
  return '<span class="badge" style="color:'.$color.'">'.htmlspecialchars($status).'</span>';
}

$rooms = $conn->query("SELECT * FROM rooms WHERE is_active=1 ORDER BY name");

if ($user['role'] === 'admin') {
  $bookings = $conn->query("
    SELECT b.*, r.name AS room_name
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    ORDER BY b.date DESC, b.start_time DESC
  ");
} else {
  $bookings = $conn->query("
    SELECT b.*, r.name AS room_name
    FROM bookings b
    JOIN rooms r ON b.room_id = r.id
    WHERE b.created_by = {$user['id']}
    ORDER BY b.date DESC, b.start_time DESC
  ");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Pemesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include '../partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">
  <div style="display:flex;align-items:flex-end;justify-content:space-between;gap:16px;flex-wrap:wrap;">
    <div>
      <h2 style="margin:0 0 8px;">Pemesanan Ruangan</h2>
      <p style="margin:0;color:#a1a1aa;">
        
      </p>
    </div>

    <a class="btn" href="/lumiere/schedule.php">Lihat Jadwal</a>
  </div>

  <!-- FORM CREATE -->
  <div class="card" style="padding:18px;margin:18px 0 16px;">
    <div style="display:flex;align-items:center;justify-content:space-between;gap:12px;flex-wrap:wrap;">
      <h3 style="margin:0;">Ajukan Pemesanan</h3>
      <span style="color:#a1a1aa;font-size:12px;">
        Tips: cek jadwal dulu agar tidak bentrok
      </span>
    </div>

    <form id="form-booking" class="form-grid" method="POST" action="store.php" style="margin-top:12px;">
      <select name="room_id" class="input" required>
        <option value="">Pilih Ruangan</option>
        <?php while($r = $rooms->fetch_assoc()): ?>
          <option value="<?= (int)$r['id'] ?>"><?= htmlspecialchars($r['name']) ?></option>
        <?php endwhile; ?>
      </select>

      <input class="input" name="title" placeholder="Kegiatan (contoh: Rapat UKM / Kuliah Pengganti)" required>
      <input class="input" name="person" placeholder="Penanggung Jawab (PIC)" required>

      <input class="input" type="date" name="date" required>
      <input class="input" type="time" name="start_time" required>
      <input class="input" type="time" name="end_time" required>

      <div style="grid-column:1/-1;display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn btn-primary" type="submit">Ajukan Pemesanan (Create)</button>
        <a class="btn" href="#tabel">Lihat Data (Read)</a>
      </div>
    </form>

    <p style="color:#71717a;font-size:12px;margin:10px 0 0;">
      Sistem menolak pemesanan jika waktu overlap pada ruangan & tanggal yang sama (anti bentrok).
    </p>
  </div>

  <!-- TABLE READ -->
  <div id="tabel" class="card" style="padding:0;overflow:hidden;">
    <table class="table">
      <tr>
        <th>Ruangan</th>
        <th>Tanggal</th>
        <th>Waktu</th>
        <th>Kegiatan</th>
        <th>PIC</th>
        <th>Status</th>
        <th>Aksi</th>
      </tr>

      <?php while($b = $bookings->fetch_assoc()): ?>
        <?php
          $isLockedForUser = ($user['role'] !== 'admin' && $b['status'] !== 'pending');
        ?>
        <tr class="row-hover">
          <td><?= htmlspecialchars($b['room_name']) ?></td>
          <td><?= htmlspecialchars($b['date']) ?></td>
          <td><?= htmlspecialchars($b['start_time']) ?> - <?= htmlspecialchars($b['end_time']) ?></td>
          <td><?= htmlspecialchars($b['title']) ?></td>
          <td><?= htmlspecialchars($b['person_in_charge']) ?></td>
          <td><?= badge($b['status']) ?></td>

          <td style="display:flex;gap:10px;flex-wrap:wrap;align-items:center;">
            <?php if (!$isLockedForUser): ?>
              <a class="btn" href="edit.php?id=<?= (int)$b['id'] ?>">Edit (Update)</a>

              <form method="POST" action="delete.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                <button class="btn" type="submit" onclick="return confirm('Hapus pemesanan?')">
                  Hapus (Delete)
                </button>
              </form>
            <?php else: ?>
              <span style="color:#a1a1aa;font-size:12px;">Terkunci (sudah diproses)</span>
            <?php endif; ?>

            <?php if ($user['role'] === 'admin'): ?>
              <form method="POST" action="status.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                <input type="hidden" name="status" value="approved">
                <button class="btn" type="submit">Setujui</button>
              </form>

              <form method="POST" action="status.php" style="display:inline;">
                <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                <input type="hidden" name="status" value="cancelled">
                <button class="btn" type="submit">Batalkan</button>
              </form>
            <?php endif; ?>
          </td>
        </tr>
      <?php endwhile; ?>

    </table>
  </div>

  <p style="color:#71717a;font-size:12px;margin-top:10px;">
    Catatan: User hanya dapat mengubah pemesanan saat status masih <b>pending</b>. Admin dapat memproses persetujuan.
  </p>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
