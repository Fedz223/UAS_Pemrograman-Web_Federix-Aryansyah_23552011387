<?php
require '../middleware/auth.php';
require '../config/database.php';

$user = $_SESSION['user'];

$room_id = (int)($_POST['room_id'] ?? 0);
$title = trim($_POST['title'] ?? '');
$person = trim($_POST['person'] ?? '');
$date = $_POST['date'] ?? '';
$start = $_POST['start_time'] ?? '';
$end = $_POST['end_time'] ?? '';

if ($room_id<=0 || $title==='' || $person==='' || $date==='' || $start==='' || $end==='') {
  die("Data tidak lengkap.");
}

if ($start >= $end) {
  die("Waktu mulai harus lebih kecil dari waktu selesai.");
}

$stmt = $conn->prepare("
  SELECT id FROM bookings
  WHERE room_id = ?
    AND date = ?
    AND status != 'cancelled'
    AND (? < end_time AND ? > start_time)
  LIMIT 1
");
$stmt->bind_param("isss", $room_id, $date, $start, $end);
$stmt->execute();
$conflict = $stmt->get_result()->fetch_assoc();

if ($conflict) {
  die("Bentrok jadwal terdeteksi. Silakan pilih waktu lain.");
}

$stmt = $conn->prepare("
  INSERT INTO bookings (room_id, title, person_in_charge, date, start_time, end_time, status, created_by)
  VALUES (?, ?, ?, ?, ?, ?, 'pending', ?)
");
$stmt->bind_param("isssssi", $room_id, $title, $person, $date, $start, $end, $user['id']);
$stmt->execute();

header("Location: /lumiere/bookings/index.php");
exit;
