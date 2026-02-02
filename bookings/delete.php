<?php
require '../middleware/auth.php';
require '../config/database.php';

$id = (int)($_POST['id'] ?? 0);
$conn->query("DELETE FROM bookings WHERE id=$id");

header("Location: /lumiere/bookings/index.php");
exit;
