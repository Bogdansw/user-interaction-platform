<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$platform = platform_name();
$active_page = 'explore';
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Explore</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/style.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/layout.css')) ?>">
  <script src="<?= htmlspecialchars(asset_version('js/script.js')) ?>" defer></script>
</head>
<body class="layout-body layout-single-page">
  <?php include __DIR__ . '/php/partials/top_bar.php'; ?>

  <div class="layout layout-single">
    <?php include __DIR__ . '/php/partials/sidebar_left.php'; ?>

    <main class="feed-column" role="feed">
      <div class="feed-inner">
        <div class="feed-header">
          <h1 data-i18n="explore">Explore</h1>
        </div>

        <div class="sort-tabs" role="tablist">
          <button class="sort-tab active" type="button"><?= ui_icon('popular', 14) ?><span data-i18n="trending">Trending</span></button>
          <button class="sort-tab" type="button"><?= ui_icon('new', 14) ?><span data-i18n="fresh">Fresh</span></button>
          <button class="sort-tab" type="button"><?= ui_icon('top', 14) ?><span data-i18n="top">Top</span></button>
        </div>

        <div class="post-list">
          <?php if (count($posts) === 0): ?>
            <div class="feed-empty" data-i18n="noExploreContent">Nu exista continut de explorat inca.</div>
          <?php else: ?>
            <?php foreach ($posts as $post): ?>
              <?php
                $can_interact = $is_logged_in;
                $current_user = $user;
                include __DIR__ . '/php/partials/post_card.php';
              ?>
            <?php endforeach; ?>
          <?php endif; ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
