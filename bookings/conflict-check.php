<?php
require '../config/database.php';

$stmt = $conn->prepare("
  SELECT * FROM bookings
  WHERE room_id = ?
  AND date = ?
  AND status != 'cancelled'
  AND (
    (? < end_time AND ? > start_time)
  )
");
$stmt->bind_param(
  "isss",
  $_POST['room_id'],
  $_POST['date'],
  $_POST['start_time'],
  $_POST['end_time']
);
$stmt->execute();

$result = $stmt->get_result();
echo json_encode(['conflict' => $result->num_rows > 0]);
