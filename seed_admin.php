<?php
require 'config/database.php';

$name = "Admin Lumiere";
$email = "admin@lumiere.com";
$passwordPlain = "admin123";
$hash = password_hash($passwordPlain, PASSWORD_DEFAULT);

$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$exists = $stmt->get_result()->fetch_assoc();

if ($exists) {
  echo "Admin sudah ada. Email: admin@lumiere.com | Password: admin123";
  exit;
}

$stmt = $conn->prepare("INSERT INTO users (name, email, password, role) VALUES (?,?,?, 'admin')");
$stmt->bind_param("sss", $name, $email, $hash);
$stmt->execute();

echo "Sukses buat admin. Email: admin@lumiere.com | Password: admin123";
