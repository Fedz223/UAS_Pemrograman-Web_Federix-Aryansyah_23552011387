<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Masuk</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<div style="min-height:100vh;display:flex;align-items:center;justify-content:center;">
  <div class="card" style="padding:32px;width:380px;">

    <div style="text-align:center;margin-bottom:24px;">
      <img src="assets/img/logo.svg" height="40" alt="Lumiere">
      <p style="color:#a1a1aa;margin-top:10px;">
        Masuk ke Sistem Lumiere
      </p>
    </div>

    <form method="POST" action="auth/login.php">
      <input 
        type="email" 
        name="email" 
        placeholder="Email"
        required
        style="width:100%;padding:12px;border-radius:10px;margin-bottom:12px;"
      >

      <input 
        type="password" 
        name="password" 
        placeholder="Password"
        required
        style="width:100%;padding:12px;border-radius:10px;margin-bottom:18px;"
      >

      <button type="submit" class="btn btn-primary" style="width:100%;">
        Masuk
      </button>
    </form>

    <p style="margin-top:18px;text-align:center;color:#a1a1aa;font-size:14px;">
      Belum punya akun?
      <a href="register.php" style="color:#6366f1;">Daftar</a>
    </p>

  </div>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
