<?php
require '../middleware/auth.php';
require '../config/database.php';

if ($_SESSION['user']['role'] !== 'admin') {
  die("Akses ditolak.");
}

$from = $_GET['from'] ?? '';
$to   = $_GET['to'] ?? '';

if (!$from || !$to) {
  die("Periode tidak valid.");
}

if ($from > $to) {
  die("Periode mulai tidak boleh lebih besar dari periode selesai.");
}

// Ambil data booking
$stmt = $conn->prepare("
  SELECT b.id, r.name AS room_name, b.date, b.start_time, b.end_time,
         b.title, b.person_in_charge, b.status
  FROM bookings b
  JOIN rooms r ON b.room_id = r.id
  WHERE b.date BETWEEN ? AND ?
  ORDER BY b.date ASC, b.start_time ASC
");
$stmt->bind_param("ss", $from, $to);
$stmt->execute();
$res = $stmt->get_result();

// Output sebagai Excel (CSV yang kompatibel Excel)
$filename = "lumiere_laporan_ruangan_{$from}_sd_{$to}.csv";

header("Content-Type: text/csv; charset=UTF-8");
header("Content-Disposition: attachment; filename=\"$filename\"");
header("Pragma: no-cache");
header("Expires: 0");

// BOM UTF-8 supaya Excel Windows kebaca rapi
echo "\xEF\xBB\xBF";

$out = fopen("php://output", "w");

// Header kolom
fputcsv($out, ["ID", "Ruangan", "Tanggal", "Mulai", "Selesai", "Kegiatan", "Penanggung Jawab", "Status"]);

// Isi data
while ($row = $res->fetch_assoc()) {
  fputcsv($out, [
    $row['id'],
    $row['room_name'],
    $row['date'],
    $row['start_time'],
    $row['end_time'],
    $row['title'],
    $row['person_in_charge'],
    $row['status'],
  ]);
}

fclose($out);
exit;
