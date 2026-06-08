<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$notification_count = $is_logged_in ? count($messages) : 0;
$platform = platform_name();
$active_page = 'home';
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

$joined_servers = [];
$suggested = available_communities();

if ($status === 'post_created') {
  $notice = 'Postarea a fost publicata.';
  $notice_class = 'success';
} elseif ($status === 'post_updated') {
  $notice = 'Postarea a fost actualizata.';
  $notice_class = 'success';
} elseif ($status === 'post_not_found') {
  $notice = 'Postarea nu a fost gasita.';
  $notice_class = 'error';
} elseif ($status === 'not_allowed') {
  $notice = 'Poti edita doar postarile publicate de tine.';
  $notice_class = 'error';
}

?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Feed</title>
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/style.css')) ?>">
  <link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/layout.css')) ?>">
  <script src="<?= htmlspecialchars(asset_version('js/script.js')) ?>" defer></script>
</head>
<body class="layout-body">
  <?php include __DIR__ . '/php/partials/top_bar.php'; ?>

  <div class="layout">
    <?php include __DIR__ . '/php/partials/sidebar_left.php'; ?>

    <main class="feed-column" role="feed">
      <div class="feed-inner">
        <div class="feed-header">
          <h1 data-i18n="feed">Feed</h1>
          <div class="feed-header-actions">
            <?php if ($is_logged_in): ?>
              <a class="btn primary new-post" href="post.php" aria-label="Create new post" data-i18n-aria-label="newPost">
                <?= ui_icon('new', 16) ?>
                <span data-i18n="newPost">New post</span>
              </a>
            <?php endif; ?>
            <?php if ($is_logged_in): ?>
              <a class="btn community-create-btn" href="community.php">
                <?= ui_icon('communities', 16) ?>
                <span data-i18n="createCommunity">Creeaza comunitate</span>
              </a>
            <?php else: ?>
              <a class="btn community-create-btn" href="login.php">
                <?= ui_icon('communities', 16) ?>
                <span data-i18n="createCommunity">Creeaza comunitate</span>
              </a>
            <?php endif; ?>
          </div>
        </div>

        <?php if ($notice !== ''): ?>
          <div class="notice <?= htmlspecialchars($notice_class) ?>"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>

        <section class="layout-card intro-panel">
          <span class="intro-kicker" data-i18n="startKicker">Platforma sociala</span>
          <h2 data-i18n="startTitle">Comunitati, postari si discutii intr-un singur loc</h2>
          <p data-i18n="startBody">
            user-platform este un spatiu unde utilizatorii pot crea comunitati, pot publica postari si pot interactiona prin comentarii, reactii si continut salvat.
          </p>
        </section>

        <div class="sort-tabs" role="tablist">
          <button class="sort-tab active" type="button" data-sort="hot" aria-label="Sort hot">
            <?= ui_icon('popular', 14) ?>
            <span data-i18n="hot">Hot</span>
          </button>
          <button class="sort-tab" type="button" data-sort="new" aria-label="Sort new">
            <?= ui_icon('new', 14) ?>
            <span data-i18n="new">New</span>
          </button>
          <button class="sort-tab" type="button" data-sort="top" aria-label="Sort top">
            <?= ui_icon('top', 14) ?>
            <span data-i18n="top">Top</span>
          </button>
        </div>

        <div class="post-list" id="post-list">
          <?php if (count($posts) === 0): ?>
            <div class="feed-empty" data-i18n="noPosts">No posts yet</div>
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

    <aside class="sidebar sidebar-right">
      <div class="panel">
        <div class="panel-header">
          <div class="panel-title" data-i18n="trendingToday">Trending today</div>
          <?= ui_icon('top', 16) ?>
        </div>
        <div class="trend-list">
          <?php if (count($posts) > 0): ?>
            <?php foreach (array_slice($posts, 0, 4) as $index => $trend): ?>
              <div class="trend-item">
                <div class="trend-index"><?= $index + 1 ?></div>
                <div class="trend-text">
                  <div class="trend-category"><?= htmlspecialchars((string) ($trend['type'] ?? 'discussion')) ?></div>
                  <div class="trend-title"><?= htmlspecialchars((string) ($trend['title'] ?? '')) ?></div>
                  <div class="trend-upvotes"><?= htmlspecialchars((string) ($trend['upvotes'] ?? 0)) ?> <span data-i18n="upvotes">upvotes</span></div>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p class="panel-empty" data-i18n="noTrends">Nicio tendinta inca.</p>
          <?php endif; ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-title" data-i18n="suggestedCommunities">Suggested communities</div>
        <?php foreach ($suggested as $community): ?>
          <div class="community-row">
            <span class="community-dot" style="background: <?= htmlspecialchars($community['color']) ?>;">
              <?php if (($community['iconUrl'] ?? '') !== ''): ?>
                <img src="<?= htmlspecialchars($community['iconUrl']) ?>" alt="">
              <?php else: ?>
                <?= htmlspecialchars($community['initial']) ?>
              <?php endif; ?>
            </span>
            <div class="community-info">
              <span class="community-name"><?= htmlspecialchars($community['name']) ?></span>
              <span class="community-members"><?= htmlspecialchars($community['members']) ?> <span data-i18n="members">members</span></span>
            </div>
            <?php if ($is_logged_in): ?>
              <button class="btn primary small" type="button" data-i18n="join">Join</button>
            <?php else: ?>
              <button class="btn primary small is-disabled" type="button" disabled title="Autentifica-te pentru a te alatura" data-i18n="join" data-i18n-title="joinLoginRequired">Join</button>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      </div>
    </aside>
  </div>
</body>
</html>
