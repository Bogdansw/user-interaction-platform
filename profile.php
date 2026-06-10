<?php
require_once __DIR__ . '/php/functions.php';

require_login('login.php');

$user = current_user();
$users = read_json_file(__DIR__ . '/data/users.json', []);
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$posts = read_json_file(__DIR__ . '/data/items.json', []);
$user_index = find_user_index($users, (string) ($user['id'] ?? ''), (string) ($user['email'] ?? ''));
$profile_user = $user_index !== null ? $users[$user_index] : $user;
$avatar_url = clean_value($profile_user['avatarUrl'] ?? '');
$status = $_GET['status'] ?? '';
$notice = '';
$notice_class = '';

if ($status === 'avatar_updated') {
	$notice = 'Poza de profil a fost actualizata.';
	$notice_class = 'success';
} elseif ($status === 'invalid_avatar_url') {
	$notice = 'Linkul pentru poza de profil trebuie sa fie un URL valid http sau https.';
	$notice_class = 'error';
} elseif ($status === 'save_failed') {
	$notice = 'Nu am putut salva poza de profil. Incearca din nou.';
	$notice_class = 'error';
} elseif ($status === 'invalid_request') {
	$notice = 'Cerere invalida. Incearca din nou.';
	$notice_class = 'error';
} elseif ($status === 'user_not_found') {
	$notice = 'Utilizatorul nu a fost gasit.';
	$notice_class = 'error';
}

$user_email = strtolower((string) ($user['email'] ?? ''));
$user_messages = array_values(array_filter($messages, function ($message) use ($user_email) {
	$email = strtolower((string) ($message['email'] ?? ''));
	return $email !== '' && $email === $user_email;
}));

$user_posts = array_values(array_filter($posts, function ($post) use ($user) {
	$author_id = (string) ($post['authorId'] ?? '');
	if ($author_id !== '') {
		return $author_id === (string) ($user['id'] ?? '');
	}
	$author = strtolower((string) ($post['author'] ?? ''));
	$name = strtolower((string) ($user['name'] ?? ''));
	return $author !== '' && $author === $name;
}));

$likes_received = 0;
$dislikes_received = 0;
foreach ($user_posts as $post) {
	$likes_received += count(normalize_id_list($post['likedBy'] ?? []));
	$dislikes_received += count(normalize_id_list($post['dislikedBy'] ?? []));
}

$count_user_comments = function ($comments) use (&$count_user_comments, $user) {
	if (!is_array($comments)) {
		return 0;
	}

	$count = 0;
	foreach ($comments as $comment) {
		if ((string) ($comment['authorId'] ?? '') === (string) ($user['id'] ?? '')) {
			$count++;
		}
		$count += $count_user_comments($comment['replies'] ?? []);
	}

	return $count;
};

$comments_left = 0;
foreach ($posts as $post) {
	$comments_left += $count_user_comments($post['commentsList'] ?? []);
}
?>
<!DOCTYPE html>
<html lang="ro">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= htmlspecialchars(platform_name()) ?> - Profil</title>
	<link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/style.css')) ?>">
	<link rel="stylesheet" href="<?= htmlspecialchars(asset_version('css/layout.css')) ?>">
	<script src="<?= htmlspecialchars(asset_version('js/script.js')) ?>" defer></script>
</head>
<body style="background:#0f1117;">
	<main class="container profile-page">
		<div class="profile-header">
			<h1>Profil utilizator</h1>
			<div class="profile-actions">
				<a class="btn" href="index.php">Feed</a>
				<a class="btn ghost" href="logout.php">Logout</a>
			</div>
		</div>

		<?php if ($notice !== ''): ?>
			<div class="notice <?= htmlspecialchars($notice_class) ?>"><?= htmlspecialchars($notice) ?></div>
		<?php endif; ?>

		<section class="card">
			<h2>Date cont</h2>
			<div class="profile-picture-panel">
				<div class="profile-avatar-large">
					<?php if ($avatar_url !== ''): ?>
						<img src="<?= htmlspecialchars($avatar_url) ?>" alt="Poza de profil">
					<?php else: ?>
						<?= htmlspecialchars(user_initials((string) ($profile_user['name'] ?? 'User'), 'US')) ?>
					<?php endif; ?>
				</div>
				<form class="profile-picture-form" method="post" action="php/profile.php">
					<input type="hidden" name="action" value="update_avatar">
					<label for="avatar_url">Link poza de profil</label>
					<div class="profile-picture-controls">
						<input id="avatar_url" name="avatar_url" type="url" value="<?= htmlspecialchars($avatar_url) ?>" placeholder="https://example.com/avatar.jpg">
						<button class="btn primary" type="submit">Salveaza poza</button>
					</div>
					<p class="muted">Lasa campul gol ca sa revii la initiale.</p>
				</form>
			</div>
			<div class="profile-row">
				<span class="label">Nume</span>
				<span class="value"><?= htmlspecialchars((string) ($profile_user['name'] ?? 'User')) ?></span>
			</div>
			<div class="profile-row">
				<span class="label">Email</span>
				<span class="value"><?= htmlspecialchars((string) ($profile_user['email'] ?? '')) ?></span>
			</div>
		</section>

		<section class="card">
			<h2>Statistici</h2>
			<div class="stats-grid">
				<div class="stat">
					<span class="stat-value"><?= htmlspecialchars((string) $likes_received) ?></span>
					<span class="stat-label">Like-uri primite</span>
				</div>
				<div class="stat">
					<span class="stat-value"><?= htmlspecialchars((string) $dislikes_received) ?></span>
					<span class="stat-label">Dislike-uri primite</span>
				</div>
				<div class="stat">
					<span class="stat-value"><?= htmlspecialchars((string) $comments_left) ?></span>
					<span class="stat-label">Comentarii lasate</span>
				</div>
			</div>
		</section>

		<section class="card">
			<h2>Mesaje din contact</h2>
			<?php if (count($user_messages) === 0): ?>
				<p class="muted">Nu exista mesaje asociate acestui cont.</p>
			<?php else: ?>
				<ul class="data-list">
					<?php foreach ($user_messages as $message): ?>
						<li>
							<div class="list-title"><?= htmlspecialchars((string) ($message['subject'] ?? 'Subiect')) ?></div>
							<div class="list-meta"><?= htmlspecialchars((string) ($message['createdAt'] ?? '')) ?></div>
							<p class="list-body"><?= htmlspecialchars((string) ($message['message'] ?? '')) ?></p>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>
		</section>
	</main>
</body>
</html>
