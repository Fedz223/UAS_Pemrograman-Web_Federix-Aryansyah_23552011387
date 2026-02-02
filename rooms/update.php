<?php
require '../middleware/auth.php';
require '../config/database.php';

if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  header("Location: /lumiere/rooms/index.php");
  exit;
}

$id = (int)($_POST['id'] ?? 0);
$name = trim($_POST['name'] ?? '');
$location = trim($_POST['location'] ?? '');
$capacity = (int)($_POST['capacity'] ?? 0);
$facilities = trim($_POST['facilities'] ?? '');

if ($id <= 0 || $name === '') die("Data tidak lengkap.");

$stmt = $conn->prepare("UPDATE rooms SET name=?, location=?, capacity=?, facilities=? WHERE id=?");
$stmt->bind_param("ssisi", $name, $location, $capacity, $facilities, $id);
$stmt->execute();

header("Location: /lumiere/rooms/index.php");
exit;
