<?php
require_once __DIR__ . '/functions.php';

require_login('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirect_with_status('../post.php', 'invalid_request');
}

$user = current_user();
$action = clean_value($_POST['action'] ?? '');
$post_id = clean_value($_POST['post_id'] ?? '');
$community_id = clean_value($_POST['community_id'] ?? '');
$title = clean_value($_POST['title'] ?? '');
$excerpt = clean_value($_POST['excerpt'] ?? '');
$type = clean_value($_POST['type'] ?? 'discussion');
$media_url = clean_value($_POST['media_url'] ?? '');
$community = find_community($community_id);
$posts_path = __DIR__ . '/../data/items.json';
$posts = read_json_file($posts_path, []);

if (!in_array($action, ['create', 'update'], true)) {
	redirect_with_status('../post.php', 'invalid_request');
}

if (!$community || $title === '' || $excerpt === '') {
	$redirect = $action === 'update' && $post_id !== '' ? '../post.php?id=' . urlencode($post_id) : '../post.php';
	redirect_with_status($redirect, 'missing_fields');
}

if (!in_array($type, ['discussion', 'photo', 'audio'], true)) {
	$type = 'discussion';
}

if ($action === 'create') {
	$posts[] = [
		'id' => uniqid('post_', true),
		'title' => $title,
		'excerpt' => $excerpt,
		'type' => $type,
		'communityId' => $community['id'],
		'community' => $community['name'],
		'communityColor' => $community['color'],
		'communityIconUrl' => $community['iconUrl'],
		'authorId' => $user['id'] ?? '',
		'author' => $user['name'] ?? 'User',
		'authorAvatarUrl' => $user['avatarUrl'] ?? '',
		'mediaUrl' => $media_url,
		'upvotes' => 0,
		'comments' => 0,
		'createdAt' => date('c'),
		'updatedAt' => date('c'),
	];

	if (!write_json_file($posts_path, $posts)) {
		redirect_with_status('../post.php', 'save_failed');
	}

	redirect_with_status('../index.php', 'post_created');
}

$post_index = find_post_index_by_id($posts, $post_id);
if ($post_index === null) {
	redirect_with_status('../index.php', 'post_not_found');
}

$post = $posts[$post_index];
if ((string) ($post['authorId'] ?? '') !== (string) ($user['id'] ?? '')) {
	redirect_with_status('../index.php', 'not_allowed');
}

$posts[$post_index] = array_merge($post, [
	'title' => $title,
	'excerpt' => $excerpt,
	'type' => $type,
	'communityId' => $community['id'],
	'community' => $community['name'],
	'communityColor' => $community['color'],
	'communityIconUrl' => $community['iconUrl'],
	'authorAvatarUrl' => $user['avatarUrl'] ?? '',
	'mediaUrl' => $media_url,
	'updatedAt' => date('c'),
]);

if (!write_json_file($posts_path, $posts)) {
	redirect_with_status('../post.php?id=' . urlencode($post_id), 'save_failed');
}

redirect_with_status('../index.php', 'post_updated');
