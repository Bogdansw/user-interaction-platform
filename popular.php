<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$platform = platform_name();
$active_page = 'popular';

usort($posts, function ($a, $b) {
  return (int) ($b['upvotes'] ?? 0) <=> (int) ($a['upvotes'] ?? 0);
});
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Popular</title>
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
          <h1 data-i18n="popular">Popular</h1>
        </div>

        <div class="post-list">
          <?php if (count($posts) === 0): ?>
            <div class="feed-empty" data-i18n="noPopularPosts">Nu exista postari populare inca.</div>
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
