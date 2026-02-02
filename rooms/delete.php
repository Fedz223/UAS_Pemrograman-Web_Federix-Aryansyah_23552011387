<?php
require '../middleware/auth.php';
require '../config/database.php';
if ($_SESSION['user']['role'] !== 'admin') die("Akses ditolak.");

$id = (int)($_POST['id'] ?? 0);
$conn->query("DELETE FROM rooms WHERE id = $id");

header("Location: /lumiere/rooms/index.php");
exit;
