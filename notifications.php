<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$platform = platform_name();
$active_page = 'notifications';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Notifications</title>
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
          <h1 data-i18n="notifications">Notifications</h1>
        </div>

        <div class="panel">
          <div class="panel-title" data-i18n="notificationsRo">Notificari</div>
          <?php if (!$is_logged_in): ?>
            <p class="panel-empty" data-i18n="loginForNotifications">Autentifica-te pentru a vedea notificarile.</p>
          <?php elseif (count($messages) === 0): ?>
            <p class="panel-empty" data-i18n="noNotifications">Nu ai notificari noi.</p>
          <?php else: ?>
            <?php foreach ($messages as $message): ?>
              <div class="panel-placeholder"><?= htmlspecialchars((string) ($message['subject'] ?? 'Mesaj nou')) ?></div>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
