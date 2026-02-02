<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Daftar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>

<?php include 'partials/navbar.php'; ?>

<div class="container" style="min-height:calc(100vh - 90px);display:flex;align-items:center;justify-content:center;padding:30px 0;">
  <div class="card" style="padding:28px;width:420px;">
    <div style="text-align:center;margin-bottom:18px;">
      <img src="assets/img/logo.svg" height="40" alt="Lumiere">
      <p style="color:#a1a1aa;margin-top:8px;">Buat akun untuk mengajukan pemesanan ruangan</p>
    </div>

    <form method="POST" action="auth/register.php" style="display:grid;gap:12px;">
      <input class="input" type="text" name="name" placeholder="Nama Lengkap" required>
      <input class="input" type="email" name="email" placeholder="Email" required>
      <input class="input" type="password" name="password" placeholder="Password" required>
      <button class="btn btn-primary" type="submit" style="width:100%;">Daftar</button>
    </form>

    <p style="margin-top:14px;color:#a1a1aa;font-size:14px;text-align:center;">
      Sudah punya akun? <a href="login.php" style="color:#a5b4fc;">Masuk</a>
    </p>
  </div>
</div>

<div class="footer">
  © <?= date('Y') ?> @Copyright by 23552011387_Federix aryansyah_TIF-RP23 CNS A_UASWEB1
</div>
</body>
</html>
