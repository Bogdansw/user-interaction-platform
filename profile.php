<?php
require_once __DIR__ . '/php/functions.php';

require_login('login.php');

$user = current_user();
$users = read_json_file(__DIR__ . '/data/users.json', []);
$messages = read_json_file(__DIR__ . '/data/messages.json', []);
$posts = read_json_file(__DIR__ . '/data/items.json', []);

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

		<section class="card">
			<h2>Date cont</h2>
			<div class="profile-row">
				<span class="label">Nume</span>
				<span class="value"><?= htmlspecialchars((string) ($user['name'] ?? 'User')) ?></span>
			</div>
			<div class="profile-row">
				<span class="label">Email</span>
				<span class="value"><?= htmlspecialchars((string) ($user['email'] ?? '')) ?></span>
			</div>
		</section>

		<section class="card">
			<h2>Statistici</h2>
			<div class="stats-grid">
				<div class="stat">
					<span class="stat-value"><?= count($users) ?></span>
					<span class="stat-label">Utilizatori inregistrati</span>
				</div>
				<div class="stat">
					<span class="stat-value"><?= count($user_posts) ?></span>
					<span class="stat-label">Postari asociate</span>
				</div>
				<div class="stat">
					<span class="stat-value"><?= count($user_messages) ?></span>
					<span class="stat-label">Mesaje trimise</span>
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
