<?php
require_once __DIR__ . '/php/functions.php';

$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($status === 'registered') {
  $notice = 'Cont creat cu succes. Te poti autentifica.';
  $notice_class = 'success';
} elseif ($status === 'login_required') {
  $notice = 'Trebuie sa fii autentificat pentru a accesa pagina.';
  $notice_class = 'error';
} elseif ($status === 'logged_out') {
  $notice = 'Ai fost deconectat.';
  $notice_class = 'success';
} elseif ($status === 'missing_fields') {
  $notice = 'Completeaza toate campurile pentru autentificare.';
  $notice_class = 'error';
} elseif ($status === 'invalid_credentials') {
  $notice = 'Email sau parola incorecta.';
  $notice_class = 'error';
} elseif ($status === 'invalid_request') {
  $notice = 'Cerere invalida. Incearca din nou.';
  $notice_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars(platform_name()) ?> - Autentificare</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/style.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/auth.css')) ?>">
</head>
<body class="auth-body">
  <div class="auth-wrapper">
    <a class="auth-back" href="index.php">
      <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M19 12H5" />
        <path d="M12 19l-7-7 7-7" />
      </svg>
      Inapoi acasa
    </a>

    <div class="auth-card">
      <div class="auth-header">
        <div class="auth-brand">up</div>
        <h1 class="auth-title">Bine ai revenit</h1>
        <p class="auth-subtitle">Autentifica-te in contul tau</p>
      </div>

      <?php if ($notice !== ''): ?>
        <div class="auth-notice <?= htmlspecialchars($notice_class) ?>">
          <?php if ($notice_class === 'success'): ?>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M22 11.08V12a10 10 0 11-5.93-9.14" />
              <path d="M22 4L12 14.01l-3-3" />
            </svg>
          <?php else: ?>
            <svg viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <circle cx="12" cy="12" r="10" />
              <line x1="12" y1="8" x2="12" y2="12" />
              <line x1="12" y1="16" x2="12.01" y2="16" />
            </svg>
          <?php endif; ?>
          <span><?= htmlspecialchars($notice) ?></span>
        </div>
      <?php endif; ?>

      <form class="auth-form" method="post" action="php/auth.php">
        <input type="hidden" name="action" value="login">

        <div class="form-group">
          <label for="login-email">Email</label>
          <div class="input-wrapper">
            <svg class="input-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
              <path d="M22 6l-10 7L2 6" />
            </svg>
            <input id="login-email" name="email" type="email" placeholder="nume@email.com" required>
          </div>
        </div>

        <div class="form-group">
          <label for="login-password">Parola</label>
          <div class="input-wrapper">
            <svg class="input-icon" viewBox="0 0 24 24" width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
              <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
              <path d="M7 11V7a5 5 0 0110 0v4" />
            </svg>
            <input id="login-password" name="password" type="password" placeholder="••••••••" required>
          </div>
        </div>

        <button class="auth-submit" type="submit">Autentifica-te</button>
      </form>

      <div class="auth-footer">
        <p>Nu ai cont? <a class="auth-link" href="register.php">Creeaza unul acum</a></p>
      </div>
    </div>

    <div class="auth-extra-links">
      <a href="contact.php">Contact</a>
      <span style="color:#252d40;">&middot;</span>
      <a href="index.php">Acasa</a>
    </div>
  </div>
</body>
</html>
