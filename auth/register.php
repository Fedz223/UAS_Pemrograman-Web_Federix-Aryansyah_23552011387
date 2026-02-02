<?php
session_start();
if (isset($_SESSION['user'])) {
  header("Location: /lumiere/dashboard.php");
  exit;
}

$error = $_GET['error'] ?? '';
$success = $_GET['success'] ?? '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>LUMIERE — Daftar</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="/lumiere/assets/css/style.css" rel="stylesheet">
</head>
<body>

<div style="min-height:100vh;display:grid;place-items:center;padding:26px;">
  <div class="card" style="width:min(520px, 100%);padding:26px;border-radius:18px;">

    <div style="display:flex;align-items:center;justify-content:center;gap:10px;margin-bottom:10px;">
      <span style="width:12px;height:12px;border-radius:999px;background:#6366f1;box-shadow:0 0 0 5px rgba(99,102,241,.18)"></span>
      <div style="font-weight:800;letter-spacing:.10em;">LUMIERE</div>
    </div>

    <div style="text-align:center;color:#a1a1aa;margin-bottom:16px;">
      Buat akun untuk mengajukan pemesanan ruangan
    </div>

    <?php if ($error): ?>
      <div class="card" style="padding:12px 14px;border:1px solid rgba(239,68,68,.45);margin-bottom:12px;">
        <div style="color:#fecaca;font-size:14px;">
          <?= htmlspecialchars($error) ?>
        </div>
      </div>
    <?php endif; ?>

    <?php if ($success): ?>
      <div class="card" style="padding:12px 14px;border:1px solid rgba(34,197,94,.45);margin-bottom:12px;">
        <div style="color:#bbf7d0;font-size:14px;">
          <?= htmlspecialchars($success) ?>
        </div>
      </div>
    <?php endif; ?>

    <form method="POST" action="/lumiere/auth/register_process.php" style="display:grid;gap:12px;">

      <!-- INPUT PUTIH seperti LOGIN -->
      <input
        type="text"
        name="name"
        placeholder="Nama Lengkap"
        required
        style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid rgba(0,0,0,.08);background:#fff;color:#111;"
      >

      <input
        type="email"
        name="email"
        placeholder="Email"
        required
        style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid rgba(0,0,0,.08);background:#fff;color:#111;"
      >

      <input
        type="password"
        name="password"
        placeholder="Password"
        minlength="6"
        required
        style="width:100%;padding:12px 14px;border-radius:12px;border:1px solid rgba(0,0,0,.08);background:#fff;color:#111;"
      >

      <button class="btn btn-primary" type="submit" style="width:100%;margin-top:6px;">
        Daftar
      </button>

      <div style="text-align:center;color:#a1a1aa;margin-top:2px;">
        Sudah punya akun? <a href="/lumiere/login.php" style="color:#a78bfa;text-decoration:none;">Masuk</a>
      </div>

    </form>
  </div>
</div>

</body>
</html>
