<?php
require '../middleware/auth.php';
require '../config/database.php';
$user = $_SESSION['user'];

$id = (int)($_GET['id'] ?? 0);

if ($user['role'] === 'admin') {
  $b = $conn->query("SELECT * FROM bookings WHERE id=$id")->fetch_assoc();
} else {
  $b = $conn->query("SELECT * FROM bookings WHERE id=$id AND created_by={$user['id']}")->fetch_assoc();
}
if (!$b) die("Data pemesanan tidak ditemukan / akses ditolak.");

$rooms = $conn->query("SELECT * FROM rooms WHERE is_active=1 ORDER BY name");
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Edit Pemesanan</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php include '../partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">
  <div class="card" style="padding:18px;max-width:920px;">
    <h2 style="margin:0 0 12px;">Edit Pemesanan</h2>

    <form method="POST" action="update.php" style="display:grid;gap:12px;grid-template-columns:repeat(3,1fr);">
      <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">

      <select name="room_id" required>
        <?php while($r = $rooms->fetch_assoc()): ?>
          <option value="<?= (int)$r['id'] ?>" <?= ((int)$b['room_id']===(int)$r['id'] ? 'selected' : '') ?>>
            <?= htmlspecialchars($r['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>

      <input class="input" name="title" value="<?= htmlspecialchars($b['title']) ?>" required>
      <input class="input" name="person" value="<?= htmlspecialchars($b['person_in_charge']) ?>" required>

      <input class="input" type="date" name="date" value="<?= htmlspecialchars($b['date']) ?>" required>
      <input class="input" type="time" name="start_time" value="<?= htmlspecialchars($b['start_time']) ?>" required>
      <input class="input" type="time" name="end_time" value="<?= htmlspecialchars($b['end_time']) ?>" required>

      <div style="grid-column:1/-1;display:flex;gap:10px;flex-wrap:wrap;">
        <button class="btn btn-primary" type="submit">Simpan Perubahan</button>
        <a class="btn" href="index.php">Kembali</a>
      </div>
    </form>
  </div>
</div>

</body>
</html>
