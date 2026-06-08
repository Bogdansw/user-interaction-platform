<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$notification_count = $is_logged_in ? count($messages) : 0;
$platform = platform_name();
$active_page = 'about';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Despre</title>
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
          <h1 data-i18n="about">Despre</h1>
        </div>

        <section class="layout-card intro-panel">
          <span class="intro-kicker" data-i18n="aboutKicker">Platforma sociala</span>
          <h2 data-i18n="aboutTitle">Un spatiu pentru comunitati si discutii</h2>
          <p data-i18n="aboutBody">
            user-platform ajuta utilizatorii sa creeze comunitati, sa publice postari si sa pastreze conversatiile organizate intr-un singur loc.
          </p>
        </section>

        <section class="panel">
          <div class="panel-title" data-i18n="projectPurpose">Scopul aplicatiei</div>
          <div class="panel-placeholder" data-i18n="projectPurposeOne">Conecteaza utilizatorii in jurul unor comunitati publice sau private.</div>
          <div class="panel-placeholder" data-i18n="projectPurposeTwo">Permite publicarea de continut doar pentru conturi autentificate.</div>
          <div class="panel-placeholder" data-i18n="projectPurposeThree">Pastreaza datele in fisiere JSON pentru conturi, comunitati, postari si mesaje.</div>
        </section>
      </div>
    </main>
  </div>
</body>
</html>
