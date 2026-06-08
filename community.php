<?php
require_once __DIR__ . '/php/functions.php';

require_login('login.php');

$user = current_user();
$is_logged_in = true;
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$communities = read_json_file(__DIR__ . '/data/communities.json', []);
$platform = platform_name();
$active_page = 'communities';
$community_id = clean_value($_GET['id'] ?? '');
$editing = $community_id !== '';
$community = null;
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($status === 'missing_fields') {
	$notice = 'Completeaza numele si descrierea comunitatii.';
	$notice_class = 'error';
} elseif ($status === 'invalid_icon_url') {
	$notice = 'Linkul pentru iconita trebuie sa fie un URL valid.';
	$notice_class = 'error';
} elseif ($status === 'save_failed') {
	$notice = 'Nu am putut salva comunitatea. Incearca din nou.';
	$notice_class = 'error';
} elseif ($status === 'invalid_request') {
	$notice = 'Cerere invalida. Incearca din nou.';
	$notice_class = 'error';
}

if ($editing) {
	$community_index = find_community_index_by_id($communities, $community_id);
	if ($community_index === null) {
		redirect_with_status('communities.php', 'community_not_found');
	}
	$community = $communities[$community_index];
	if (!user_can_manage_community($community, $user)) {
		redirect_with_status('communities.php', 'not_allowed');
	}
}

$name = (string) ($community['name'] ?? '');
$description = (string) ($community['description'] ?? '');
$visibility = (string) ($community['visibility'] ?? 'public');
$icon_url = (string) ($community['iconUrl'] ?? '');
?>
<!DOCTYPE html>
<html lang="ro">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($platform) ?> - <?= $editing ? 'Editeaza comunitatea' : 'Comunitate noua' ?></title>
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
          <h1><?= $editing ? 'Editeaza comunitatea' : 'Comunitate noua' ?></h1>
        </div>

        <?php if ($notice !== ''): ?>
          <div class="notice <?= htmlspecialchars($notice_class) ?>"><?= htmlspecialchars($notice) ?></div>
        <?php endif; ?>

        <form class="post-form panel" method="post" action="php/communities.php">
          <input type="hidden" name="action" value="<?= $editing ? 'update' : 'create' ?>">
          <?php if ($editing): ?>
            <input type="hidden" name="community_id" value="<?= htmlspecialchars($community_id) ?>">
          <?php endif; ?>

          <div class="form-row">
            <label for="name">Nume comunitate</label>
            <input id="name" name="name" type="text" maxlength="80" value="<?= htmlspecialchars($name) ?>" required>
          </div>

          <div class="form-row">
            <label for="description">Descriere</label>
            <textarea id="description" name="description" rows="6" required><?= htmlspecialchars($description) ?></textarea>
          </div>

          <div class="form-row">
            <label for="visibility">Tip comunitate</label>
            <select id="visibility" name="visibility">
              <option value="public" <?= $visibility === 'public' ? 'selected' : '' ?>>Publica - oricine poate intra</option>
              <option value="private" <?= $visibility === 'private' ? 'selected' : '' ?>>Privata - doar membrii acceptati de admini pot intra</option>
            </select>
          </div>

          <div class="form-row">
            <label for="icon_url">Link imagine iconita</label>
            <input id="icon_url" name="icon_url" type="url" value="<?= htmlspecialchars($icon_url) ?>" placeholder="https://example.com/icon.png">
          </div>

          <div class="community-rule-note">
            Daca nu adaugi imagine, iconita va fi generata automat din prima litera a numelui si o culoare aleasa automat.
          </div>

          <div class="form-actions">
            <a class="btn ghost" href="communities.php">Renunta</a>
            <button class="btn primary" type="submit"><?= $editing ? 'Salveaza' : 'Creeaza comunitate' ?></button>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
