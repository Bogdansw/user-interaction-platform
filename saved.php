<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$platform = platform_name();
$active_page = 'saved';
$saved_posts = [];

if ($is_logged_in) {
  $user_id = (string) ($user['id'] ?? '');
  $saved_posts = array_values(array_filter($posts, function ($post) use ($user_id) {
    return in_array($user_id, normalize_id_list($post['savedBy'] ?? []), true);
  }));
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Saved</title>
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
          <h1 data-i18n="saved">Saved</h1>
        </div>

        <div class="post-list">
          <?php if (!$is_logged_in): ?>
            <div class="panel">
              <p class="panel-empty">Autentifica-te pentru a vedea postarile salvate.</p>
            </div>
          <?php elseif (count($saved_posts) === 0): ?>
            <div class="panel">
              <div class="panel-title" data-i18n="savedPosts">Postari salvate</div>
              <p class="panel-empty" data-i18n="noSavedPosts">Nu ai postari salvate momentan.</p>
            </div>
          <?php else: ?>
            <?php foreach ($saved_posts as $post): ?>
              <?php
                $can_interact = true;
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
