<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$notification_count = $is_logged_in ? count($messages) : 0;
$platform = platform_name();
$active_page = 'features';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Functionalitati</title>
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
          <h1 data-i18n="features">Functionalitati</h1>
        </div>

        <section class="panel">
          <div class="panel-title" data-i18n="mainFeatures">Functionalitati principale</div>
          <div class="panel-placeholder" data-i18n="featureAuth">Conturi cu inregistrare, autentificare, deconectare si sesiune de utilizator.</div>
          <div class="panel-placeholder" data-i18n="featurePosts">Postari create de utilizatori autentificati, editabile doar de autor.</div>
          <div class="panel-placeholder" data-i18n="featureCommunities">Comunitati publice sau private, cu iconita prin link si administrare pentru creator.</div>
          <div class="panel-placeholder" data-i18n="featureInteractions">Reactii, comentarii, raspunsuri si salvare pentru postari.</div>
          <div class="panel-placeholder" data-i18n="featurePreferences">Tema dark/light si schimbarea limbii in romana, engleza sau rusa.</div>
        </section>
      </div>
    </main>
  </div>
</body>
</html>
