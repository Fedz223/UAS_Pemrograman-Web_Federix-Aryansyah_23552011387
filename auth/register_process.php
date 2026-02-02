<?php
require '../config/database.php';
session_start();

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if ($name === '' || $email === '' || $password === '') {
  header("Location: /lumiere/auth/register.php?error=Data%20wajib%20diisi.");
  exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
  header("Location: /lumiere/auth/register.php?error=Format%20email%20tidak%20valid.");
  exit;
}

if (strlen($password) < 6) {
  header("Location: /lumiere/auth/register.php?error=Password%20minimal%206%20karakter.");
  exit;
}

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ? LIMIT 1");
$stmt->bind_param("s", $email);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();

if ($exists) {
  header("Location: /lumiere/auth/register.php?error=Email%20sudah%20terdaftar,%20silakan%20masuk.");
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'user')");
$stmt->bind_param("sss", $name, $email, $hash);
$stmt->execute();

header("Location: /lumiere/login.php?success=Akun%20berhasil%20dibuat,%20silakan%20masuk.");
exit;
