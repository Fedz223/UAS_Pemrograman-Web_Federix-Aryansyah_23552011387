<?php
require '../middleware/auth.php';
require '../config/database.php';
if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

$name = trim($_POST['name'] ?? '');
$location = trim($_POST['location'] ?? '');
$capacity = (int)($_POST['capacity'] ?? 0);
$facilities = trim($_POST['facilities'] ?? '');

$stmt = $conn->prepare("INSERT INTO rooms (name, location, capacity, facilities) VALUES (?,?,?,?)");
$stmt->bind_param("ssis", $name, $location, $capacity, $facilities);
$stmt->execute();

header("Location: /lumiere/rooms/index.php");
exit;
