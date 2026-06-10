<?php
require_once __DIR__ . '/functions.php';

require_login('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirect_with_status('../profile.php', 'invalid_request');
}

$action = clean_value($_POST['action'] ?? '');
if ($action !== 'update_avatar') {
	redirect_with_status('../profile.php', 'invalid_request');
}

$user = current_user();
$avatar_url = clean_value($_POST['avatar_url'] ?? '');

if (!is_valid_http_url($avatar_url)) {
	redirect_with_status('../profile.php', 'invalid_avatar_url');
}

$users_path = __DIR__ . '/../data/users.json';
$users = read_json_file($users_path, []);
$user_index = find_user_index($users, (string) ($user['id'] ?? ''), (string) ($user['email'] ?? ''));

if ($user_index === null) {
	redirect_with_status('../profile.php', 'user_not_found');
}

$users[$user_index]['avatarUrl'] = $avatar_url;

if (!write_json_file($users_path, $users)) {
	redirect_with_status('../profile.php', 'save_failed');
}

$_SESSION['user'] = array_merge($user, [
	'avatarUrl' => $avatar_url,
]);

$posts_path = __DIR__ . '/../data/items.json';
$posts = read_json_file($posts_path, []);
$changed_posts = false;
foreach ($posts as $index => $post) {
	if ((string) ($post['authorId'] ?? '') === (string) ($user['id'] ?? '')) {
		$posts[$index]['authorAvatarUrl'] = $avatar_url;
		$changed_posts = true;
	}
}

if ($changed_posts && !write_json_file($posts_path, $posts)) {
	redirect_with_status('../profile.php', 'save_failed');
}

redirect_with_status('../profile.php', 'avatar_updated');
