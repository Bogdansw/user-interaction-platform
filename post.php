<?php
require_once __DIR__ . '/php/functions.php';

require_login('login.php');

$user = current_user();
$is_logged_in = true;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$communities = available_communities();
$has_communities = count($communities) > 0;
$platform = platform_name();
$active_page = 'home';
$post_id = clean_value($_GET['id'] ?? '');
$editing = $post_id !== '';
$post = null;
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($status === 'missing_fields') {
	$notice = 'Alege comunitatea si completeaza titlul si continutul.';
	$notice_class = 'error';
} elseif ($status === 'save_failed') {
	$notice = 'Nu am putut salva postarea. Incearca din nou.';
	$notice_class = 'error';
} elseif ($status === 'invalid_request') {
	$notice = 'Cerere invalida. Incearca din nou.';
	$notice_class = 'error';
}

if ($editing) {
	$post_index = find_post_index_by_id($posts, $post_id);
	if ($post_index === null) {
		redirect_with_status('index.php', 'post_not_found');
	}
	$post = $posts[$post_index];
	if ((string) ($post['authorId'] ?? '') !== (string) ($user['id'] ?? '')) {
		redirect_with_status('index.php', 'not_allowed');
	}
}

$selected_community = (string) ($post['communityId'] ?? ($communities[0]['id'] ?? ''));
$title = (string) ($post['title'] ?? '');
$excerpt = (string) ($post['excerpt'] ?? '');
$type = (string) ($post['type'] ?? 'discussion');
$media_url = (string) ($post['mediaUrl'] ?? '');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - <?= $editing ? 'Editeaza postarea' : 'Postare noua' ?></title>
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
          <h1><?= $editing ? 'Editeaza postarea' : 'Postare noua' ?></h1>
        </div>

        <?php if ($notice !== ''): ?>
          <div class="notice <?= htmlspecialchars($notice_class) ?>"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>

        <form class="post-form panel" method="post" action="php/posts.php">
          <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
          <?php if ($editing): ?>
            <input type="hidden" name="post_id" value="<?= htmlspecialchars($post_id) ?>">
          <?php endif; ?>

          <div class="form-row">
            <label for="community_id">Comunitate / server</label>
            <?php if ($has_communities): ?>
              <select id="community_id" name="community_id" required>
                <?php foreach ($communities as $community): ?>
                  <option value="<?= htmlspecialchars($community['id']) ?>" <?= $selected_community === $community['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($community['name']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            <?php else: ?>
              <div class="community-rule-note">Creeaza o comunitate inainte de a publica o postare.</div>
            <?php endif; ?>
          </div>

          <div class="form-row">
            <label for="title">Titlu</label>
            <input id="title" name="title" type="text" maxlength="120" value="<?= htmlspecialchars($title) ?>" required>
          </div>

          <div class="form-row">
            <label for="excerpt">Continut</label>
            <textarea id="excerpt" name="excerpt" rows="7" required><?= htmlspecialchars($excerpt) ?></textarea>
          </div>

          <div class="form-row">
            <label for="type">Tip postare</label>
            <select id="type" name="type">
              <option value="discussion" <?= $type === 'discussion' ? 'selected' : '' ?>>Discussion</option>
              <option value="photo" <?= $type === 'photo' ? 'selected' : '' ?>>Photo</option>
              <option value="audio" <?= $type === 'audio' ? 'selected' : '' ?>>Audio</option>
            </select>
          </div>

          <div class="form-row">
            <label for="media_url">Link media optional</label>
            <input id="media_url" name="media_url" type="url" value="<?= htmlspecialchars($media_url) ?>" placeholder="https://...">
          </div>

          <div class="form-actions">
            <a class="btn ghost" href="index.php">Renunta</a>
            <button class="btn primary" type="submit"<?= $has_communities ? '' : ' disabled' ?>><?= $editing ? 'Salveaza' : 'Publica' ?></button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
