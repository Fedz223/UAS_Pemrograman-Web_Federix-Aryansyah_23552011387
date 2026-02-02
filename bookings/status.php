<?php
require '../middleware/auth.php';
require '../config/database.php';

if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

$id = (int)($_POST['id'] ?? 0);
$status = $_POST['status'] ?? '';

$allowed = ['approved','cancelled','pending'];
if (!in_array($status, $allowed, true)) die("Status tidak valid.");

$stmt = $conn->prepare("UPDATE bookings SET status=? WHERE id=?");
$stmt->bind_param("si", $status, $id);
$stmt->execute();

header("Location: /lumiere/bookings/index.php");
exit;
