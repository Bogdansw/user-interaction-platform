<?php
require_once __DIR__ . '/php/functions.php';

$user = current_user();
$is_logged_in = $user !== null;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$platform = platform_name();
$active_page = 'communities';
$suggested = available_communities();
$managed = [];
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($is_logged_in) {
  $managed = array_values(array_filter($suggested, function ($community) use ($user) {
    return user_can_manage_community($community, $user);
  }));
}

if ($status === 'community_created') {
  $notice = 'Comunitatea a fost creata.';
  $notice_class = 'success';
} elseif ($status === 'community_updated') {
  $notice = 'Comunitatea a fost actualizata.';
  $notice_class = 'success';
} elseif ($status === 'community_deleted') {
  $notice = 'Comunitatea si postarile ei au fost sterse.';
  $notice_class = 'success';
} elseif ($status === 'joined') {
  $notice = 'Te-ai alaturat comunitatii.';
  $notice_class = 'success';
} elseif ($status === 'join_requested') {
  $notice = 'Cererea de acces a fost trimisa catre admini.';
  $notice_class = 'success';
} elseif ($status === 'already_member') {
  $notice = 'Esti deja membru in aceasta comunitate.';
  $notice_class = 'success';
} elseif ($status === 'community_not_found') {
  $notice = 'Comunitatea nu a fost gasita.';
  $notice_class = 'error';
} elseif ($status === 'not_allowed') {
  $notice = 'Poti gestiona doar comunitatile unde esti admin.';
  $notice_class = 'error';
} elseif ($status === 'save_failed') {
  $notice = 'Nu am putut salva modificarile.';
  $notice_class = 'error';
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - Communities</title>
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
          <h1 data-i18n="communities">Communities</h1>
          <?php if ($is_logged_in): ?>
            <a class="btn primary" href="community.php">
              <?= ui_icon('communities', 16) ?>
              <span data-i18n="createCommunity">Creeaza comunitate</span>
            </a>
          <?php endif; ?>
        </div>

        <?php if ($notice !== ''): ?>
          <div class="notice <?= htmlspecialchars($notice_class) ?>"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>

        <?php if ($is_logged_in): ?>
          <div class="panel">
            <div class="panel-title">Comunitati create de tine</div>
            <?php if (count($managed) === 0): ?>
              <p class="panel-empty">Nu administrezi nicio comunitate inca.</p>
            <?php else: ?>
              <?php foreach ($managed as $community): ?>
                <div class="community-row community-row-expanded">
                  <span class="community-dot" style="background: <?= htmlspecialchars($community['color']) ?>;">
                    <?php if ($community['iconUrl'] !== ''): ?>
                      <img src="<?= htmlspecialchars($community['iconUrl']) ?>" alt="">
                    <?php else: ?>
                      <?= htmlspecialchars($community['initial']) ?>
                    <?php endif; ?>
                  </span>
                  <div class="community-info">
                    <span class="community-name">
                      <?= htmlspecialchars($community['name']) ?>
                      <span class="community-visibility <?= htmlspecialchars($community['visibility']) ?>">
                        <?= $community['visibility'] === 'private' ? 'Privata' : 'Publica' ?>
                      </span>
                    </span>
                    <span class="community-description"><?= htmlspecialchars($community['description']) ?></span>
                  </div>
                  <div class="community-manage-actions">
                    <a class="btn small" href="community.php?id=<?= urlencode($community['id']) ?>">Edit</a>
                    <form method="post" action="php/communities.php" data-confirm-submit="Stergi comunitatea si toate postarile din ea?">
                      <input type="hidden" name="action" value="delete">
                      <input type="hidden" name="community_id" value="<?= htmlspecialchars($community['id']) ?>">
                      <button class="btn danger small" type="submit">Delete</button>
                    </form>
                  </div>
                </div>
              <?php endforeach; ?>
            <?php endif; ?>
          </div>
        <?php endif; ?>

        <div class="panel">
          <div class="panel-title" data-i18n="suggestedCommunities">Suggested communities</div>
          <?php foreach ($suggested as $community): ?>
            <div class="community-row community-row-expanded">
              <span class="community-dot" style="background: <?= htmlspecialchars($community['color']) ?>;">
                <?php if ($community['iconUrl'] !== ''): ?>
                  <img src="<?= htmlspecialchars($community['iconUrl']) ?>" alt="">
                <?php else: ?>
                  <?= htmlspecialchars($community['initial']) ?>
                <?php endif; ?>
              </span>
              <div class="community-info">
                <span class="community-name">
                  <?= htmlspecialchars($community['name']) ?>
                  <span class="community-visibility <?= htmlspecialchars($community['visibility']) ?>">
                    <?= $community['visibility'] === 'private' ? 'Privata' : 'Publica' ?>
                  </span>
                </span>
                <span class="community-description"><?= htmlspecialchars($community['description']) ?></span>
                <span class="community-members"><?= htmlspecialchars($community['members']) ?> <span data-i18n="members">members</span></span>
              </div>
              <?php if ($is_logged_in): ?>
                <?php
                  $is_admin = user_can_manage_community($community, $user);
                  $is_member = user_is_community_member($community, $user);
                  $has_pending = user_has_pending_community_request($community, $user);
                ?>
                <?php if ($is_admin): ?>
                  <button class="btn small is-disabled" type="button" disabled>Admin</button>
                <?php elseif ($is_member): ?>
                  <button class="btn small is-disabled" type="button" disabled>Membru</button>
                <?php elseif ($has_pending): ?>
                  <button class="btn small is-disabled" type="button" disabled>In asteptare</button>
                <?php else: ?>
                  <form class="community-join-form" method="post" action="php/communities.php">
                    <input type="hidden" name="action" value="join">
                    <input type="hidden" name="community_id" value="<?= htmlspecialchars($community['id']) ?>">
                    <button class="btn primary small" type="submit">
                      <?= $community['visibility'] === 'private' ? 'Cere acces' : 'Alatura-te' ?>
                    </button>
                  </form>
                <?php endif; ?>
              <?php else: ?>
                <button class="btn primary small is-disabled" type="button" disabled title="Autentifica-te pentru a te alatura" data-i18n="join" data-i18n-title="joinLoginRequired">Join</button>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
