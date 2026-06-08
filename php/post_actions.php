<?php
require_once __DIR__ . '/functions.php';

require_login('../login.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirect_with_status('../index.php', 'invalid_request');
}

$user = current_user();
$user_id = (string) ($user['id'] ?? '');
$action = clean_value($_POST['action'] ?? '');
$post_id = clean_value($_POST['post_id'] ?? '');
$comment_id = clean_value($_POST['comment_id'] ?? '');
$body = clean_value($_POST['body'] ?? '');
$posts_path = __DIR__ . '/../data/items.json';
$posts = read_json_file($posts_path, []);
$post_index = find_post_index_by_id($posts, $post_id);
$allowed_actions = [
	'post_like',
	'post_dislike',
	'post_save',
	'comment_create',
	'reply_create',
	'comment_like',
	'comment_dislike',
];

function redirect_to_post($post_id, $status = 'updated') {
	header('Location: ../index.php?status=' . urlencode($status) . '#post-' . rawurlencode($post_id));
	exit;
}

if ($post_index === null || $user_id === '' || !in_array($action, $allowed_actions, true)) {
	redirect_with_status('../index.php', 'post_not_found');
}

if (!isset($posts[$post_index]['likedBy'])) {
	$posts[$post_index]['likedBy'] = [];
}
if (!isset($posts[$post_index]['dislikedBy'])) {
	$posts[$post_index]['dislikedBy'] = [];
}
if (!isset($posts[$post_index]['savedBy'])) {
	$posts[$post_index]['savedBy'] = [];
}
if (!isset($posts[$post_index]['commentsList']) || !is_array($posts[$post_index]['commentsList'])) {
	$posts[$post_index]['commentsList'] = [];
}

if ($action === 'post_like') {
	toggle_reaction($posts[$post_index], $user_id, 'like');
}

if ($action === 'post_dislike') {
	toggle_reaction($posts[$post_index], $user_id, 'dislike');
}

if ($action === 'post_save') {
	$saved_by = normalize_id_list($posts[$post_index]['savedBy'] ?? []);
	if (in_array($user_id, $saved_by, true)) {
		$saved_by = array_values(array_diff($saved_by, [$user_id]));
	} else {
		$saved_by[] = $user_id;
	}
	$posts[$post_index]['savedBy'] = normalize_id_list($saved_by);
}

if ($action === 'comment_create') {
	if ($body === '') {
		redirect_to_post($post_id, 'missing_fields');
	}

	$posts[$post_index]['commentsList'][] = [
		'id' => uniqid('comment_', true),
		'authorId' => $user_id,
		'author' => $user['name'] ?? 'User',
		'body' => $body,
		'likedBy' => [],
		'dislikedBy' => [],
		'replies' => [],
		'createdAt' => date('c'),
	];
}

if ($action === 'reply_create') {
	if ($body === '' || $comment_id === '') {
		redirect_to_post($post_id, 'missing_fields');
	}

	$comment = &find_comment_mutable($posts[$post_index]['commentsList'], $comment_id);
	if ($comment === null) {
		redirect_to_post($post_id, 'comment_not_found');
	}

	if (!isset($comment['replies']) || !is_array($comment['replies'])) {
		$comment['replies'] = [];
	}

	$comment['replies'][] = [
		'id' => uniqid('comment_', true),
		'authorId' => $user_id,
		'author' => $user['name'] ?? 'User',
		'body' => $body,
		'likedBy' => [],
		'dislikedBy' => [],
		'replies' => [],
		'createdAt' => date('c'),
	];
}

if ($action === 'comment_like' || $action === 'comment_dislike') {
	$comment = &find_comment_mutable($posts[$post_index]['commentsList'], $comment_id);
	if ($comment === null) {
		redirect_to_post($post_id, 'comment_not_found');
	}

	toggle_reaction($comment, $user_id, $action === 'comment_like' ? 'like' : 'dislike');
}

$posts[$post_index]['upvotes'] = count(normalize_id_list($posts[$post_index]['likedBy'] ?? [])) - count(normalize_id_list($posts[$post_index]['dislikedBy'] ?? []));
$posts[$post_index]['comments'] = count_comments($posts[$post_index]['commentsList']);
$posts[$post_index]['updatedAt'] = date('c');

if (!write_json_file($posts_path, $posts)) {
	redirect_to_post($post_id, 'save_failed');
}

redirect_to_post($post_id, $action);
