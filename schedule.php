<?php
require 'middleware/auth.php';
require 'config/database.php';

$date = $_GET['date'] ?? date('Y-m-d');
$roomFilter = $_GET['room_id'] ?? '';

$rooms = $conn->query("SELECT * FROM rooms WHERE is_active=1 ORDER BY name");

$dateSafe = $conn->real_escape_string($date);

$sql = "
  SELECT b.*, r.name AS room_name
  FROM bookings b
  JOIN rooms r ON b.room_id=r.id
  WHERE b.date='$dateSafe' AND b.status!='cancelled'
";
if ($roomFilter !== '') $sql .= " AND b.room_id=".(int)$roomFilter;
$sql .= " ORDER BY r.name, b.start_time";

$res = $conn->query($sql);
$grouped = [];
while($b = $res->fetch_assoc()){
  $grouped[$b['room_name']][] = $b;
}

function badgeColor($status){
  if ($status==='approved') return "#22c55e";
  if ($status==='pending') return "#f59e0b";
  if ($status==='cancelled') return "#ef4444";
  return "#a1a1aa";
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Jadwal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="container" style="padding:28px 0;">
  <h2 style="margin:0 0 8px;">Jadwal Ruangan</h2>
  <p style="margin:0 0 18px;color:#a1a1aa;">Tampilan penggunaan ruangan berdasarkan tanggal.</p>

  <div class="card" style="padding:18px;margin-bottom:16px;">
    <form method="GET" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
      <input class="input" style="max-width:220px" type="date" name="date" value="<?= htmlspecialchars($date) ?>">
      <select name="room_id" style="max-width:260px">
        <option value="">Semua Ruangan</option>
        <?php while($r=$rooms->fetch_assoc()): ?>
          <option value="<?= (int)$r['id'] ?>" <?= ($roomFilter==$r['id']?'selected':'') ?>>
            <?= htmlspecialchars($r['name']) ?>
          </option>
        <?php endwhile; ?>
      </select>
      <button class="btn btn-primary" type="submit">Terapkan</button>
    </form>
  </div>

  <?php if (empty($grouped)): ?>
    <div class="card" style="padding:18px;color:#a1a1aa;">Tidak ada pemesanan pada tanggal ini.</div>
  <?php endif; ?>

  <?php foreach($grouped as $roomName => $items): ?>
    <div class="card" style="padding:18px;margin-bottom:14px;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:10px;">
        <h3 style="margin:0;"><?= htmlspecialchars($roomName) ?></h3>
        <span class="pill">Total: <?= count($items) ?> pemesanan</span>
      </div>

      <?php foreach($items as $b): $c = badgeColor($b['status']); ?>
        <div style="padding:14px;border-radius:14px;border:1px solid rgba(255,255,255,.10);background:rgba(255,255,255,.03);margin-bottom:10px;display:flex;justify-content:space-between;gap:12px;">
          <div>
            <div style="font-weight:700;">
              <?= htmlspecialchars($b['title']) ?>
              <span class="badge" style="color:<?= $c ?>;margin-left:8px;"><?= htmlspecialchars($b['status']) ?></span>
            </div>
            <div style="color:#a1a1aa;font-size:13px;margin-top:6px;">
              <?= htmlspecialchars($b['start_time']) ?> - <?= htmlspecialchars($b['end_time']) ?> • PJ: <?= htmlspecialchars($b['person_in_charge']) ?>
            </div>
          </div>
          <div style="color:#71717a;font-size:12px;">#<?= (int)$b['id'] ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
