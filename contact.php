<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$notification_count = $is_logged_in ? count($messages) : 0;
$platform = platform_name();
$active_page = 'contact';
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($status === 'sent') {
  $notice = 'Mesaj trimis. Revenim cat mai curand.';
  $notice_class = 'success';
} elseif ($status === 'missing_fields') {
  $notice = 'Completeaza toate campurile.';
  $notice_class = 'error';
} elseif ($status === 'invalid_email') {
  $notice = 'Email invalid. Verifica formatul.';
  $notice_class = 'error';
} elseif ($status === 'save_failed') {
  $notice = 'Nu am putut trimite mesajul. Incearca din nou.';
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
  <title><?= htmlspecialchars($platform) ?> - Contact</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/style.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/layout.css')) ?>">
  <script src="<?= htmlspecialchars(asset_version('js/script.js')) ?>" defer></script>
</head>
<body class="layout-body layout-single-page">
  <?php include __DIR__ . '/php/partials/top_bar.php'; ?>

  <div class="layout layout-single">
    <?php include __DIR__ . '/php/partials/sidebar_left.php'; ?>

    <main class="feed-column">
      <div class="feed-inner">
        <div class="feed-header">
          <h1 data-i18n="contact">Contact</h1>
        </div>

        <?php if ($notice !== ''): ?>
          <div class="notice <?= htmlspecialchars($notice_class) ?>">
            <?= htmlspecialchars($notice) ?>
          </div>
        <?php endif; ?>

        <section class="layout-card">
          <form class="post-form" method="post" action="php/save_data.php">
            <input type="hidden" name="action" value="contact">

            <div class="form-row">
              <label for="contact-name">Nume</label>
              <input id="contact-name" name="name" type="text" required>
            </div>

            <div class="form-row">
              <label for="contact-email">Email</label>
              <input id="contact-email" name="email" type="email" required>
            </div>

            <div class="form-row">
              <label for="contact-subject">Subiect</label>
              <input id="contact-subject" name="subject" type="text" required>
            </div>

            <div class="form-row">
              <label for="contact-message">Mesaj</label>
              <textarea id="contact-message" name="message" required></textarea>
            </div>

            <div class="form-actions">
              <button class="btn primary" type="submit">Trimite mesajul</button>
            </div>
          </form>
        </section>
      </div>
    </main>
  </div>
</body>
</html>
