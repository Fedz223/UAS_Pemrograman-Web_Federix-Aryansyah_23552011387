<?php
require '../config/database.php';
session_start();

$email = trim($_POST['email'] ?? '');
$pass = $_POST['password'] ?? '';

$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if ($user && password_verify($pass, $user['password'])) {
  $_SESSION['user'] = [
    'id' => (int)$user['id'],
    'name' => $user['name'],
    'role' => $user['role']
  ];
  header("Location: /lumiere/dashboard.php");
  exit;
}

echo "Login gagal. Periksa email/password.";
