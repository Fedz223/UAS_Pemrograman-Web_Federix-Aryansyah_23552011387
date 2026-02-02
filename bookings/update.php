<?php
require '../middleware/auth.php';
require '../config/database.php';

$user = $_SESSION['user'];

$id       = (int)($_POST['id'] ?? 0);
$room_id  = (int)($_POST['room_id'] ?? 0);
$title    = trim($_POST['title'] ?? '');
$person   = trim($_POST['person'] ?? '');
$date     = $_POST['date'] ?? '';
$start    = $_POST['start_time'] ?? '';
$end      = $_POST['end_time'] ?? '';

if ($id <= 0 || $room_id <= 0 || $title === '' || $person === '' || $date === '' || $start === '' || $end === '') {
  die("Data tidak lengkap.");
}

if ($start >= $end) {
  die("Waktu mulai harus lebih kecil dari waktu selesai.");
}

/**
 * Ambil data booking yang akan diubah + validasi akses:
 * - Admin: boleh edit semua
 * - User: hanya boleh edit miliknya, dan hanya jika status masih pending
 */
if ($user['role'] === 'admin') {
  $stmt = $conn->prepare("SELECT id, status, created_by FROM bookings WHERE id=? LIMIT 1");
  $stmt->bind_param("i", $id);
  $stmt->execute();
  $old = $stmt->get_result()->fetch_assoc();
} else {
  $stmt = $conn->prepare("SELECT id, status, created_by FROM bookings WHERE id=? AND created_by=? LIMIT 1");
  $stmt->bind_param("ii", $id, $user['id']);
  $stmt->execute();
  $old = $stmt->get_result()->fetch_assoc();
}

if (!$old) {
  die("Pemesanan tidak ditemukan atau akses ditolak.");
}

if ($user['role'] !== 'admin' && $old['status'] !== 'pending') {
  die("Pemesanan sudah diproses, tidak dapat diubah.");
}

/**
 * Cek bentrok jadwal:
 * Bentrok jika overlap waktu pada ruangan & tanggal yang sama (kecuali dirinya sendiri).
 * Abaikan status cancelled.
 */
$stmt = $conn->prepare("
  SELECT id
  FROM bookings
  WHERE room_id = ?
    AND date = ?
    AND status != 'cancelled'
    AND id != ?
    AND (? < end_time AND ? > start_time)
  LIMIT 1
");
$stmt->bind_param("isiss", $room_id, $date, $id, $start, $end);
$stmt->execute();
$conflict = $stmt->get_result()->fetch_assoc();

if ($conflict) {
  die("Bentrok jadwal terdeteksi. Silakan pilih waktu lain.");
}

/**
 * Update data
 */
$stmt = $conn->prepare("
  UPDATE bookings
  SET room_id=?, title=?, person_in_charge=?, date=?, start_time=?, end_time=?
  WHERE id=?
");
$stmt->bind_param("isssssi", $room_id, $title, $person, $date, $start, $end, $id);
$stmt->execute();

header("Location: /lumiere/bookings/index.php");
exit;
