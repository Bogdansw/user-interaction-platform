<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$platform = platform_name();
$active_page = 'support';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Support</title>
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
          <h1 data-i18n="support">Support</h1>
          <a class="btn primary" href="contact.php">Contact</a>
        </div>

        <div class="panel">
          <div class="panel-title" data-i18n="quickHelp">Ajutor rapid</div>
          <div class="panel-placeholder" data-i18n="supportTipSettings">Verifica datele contului in Settings.</div>
          <div class="panel-placeholder" data-i18n="supportTipContact">Trimite un mesaj prin pagina de contact.</div>
          <div class="panel-placeholder" data-i18n="supportTipFeed">Revino in feed pentru actualizari noi.</div>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
