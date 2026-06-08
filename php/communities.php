<?php
require_once __DIR__ . '/functions.php';

require_login('../login.php');

$user = current_user();
$action = clean_value($_POST['action'] ?? '');

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !in_array($action, ['create', 'update', 'delete', 'join'], true)) {
	redirect_with_status('../community.php', 'invalid_request');
}

$community_id = clean_value($_POST['community_id'] ?? '');
$name = clean_value($_POST['name'] ?? '');
$description = clean_value($_POST['description'] ?? '');
$visibility = clean_value($_POST['visibility'] ?? 'public');
$icon_url = clean_value($_POST['icon_url'] ?? '');
$communities_path = __DIR__ . '/../data/communities.json';
$communities = read_json_file($communities_path, []);

if ($action === 'join') {
	$community_index = find_community_index_by_id($communities, $community_id);
	if ($community_index === null) {
		redirect_with_status('../communities.php', 'community_not_found');
	}

	$community = $communities[$community_index];
	if (user_is_community_member($community, $user)) {
		redirect_with_status('../communities.php', 'already_member');
	}

	$user_id = (string) ($user['id'] ?? '');
	$visibility = (string) ($community['visibility'] ?? 'public');
	if ($visibility === 'private') {
		$pending = is_array($community['pendingMemberIds'] ?? null) ? $community['pendingMemberIds'] : [];
		if (!in_array($user_id, $pending, true)) {
			$pending[] = $user_id;
		}
		$communities[$community_index]['pendingMemberIds'] = $pending;
		$status = 'join_requested';
	} else {
		$members = is_array($community['memberIds'] ?? null) ? $community['memberIds'] : [];
		$members[] = $user_id;
		$members = array_values(array_unique($members));
		$communities[$community_index]['memberIds'] = $members;
		$communities[$community_index]['members'] = count($members);
		$status = 'joined';
	}

	if (!write_json_file($communities_path, $communities)) {
		redirect_with_status('../communities.php', 'save_failed');
	}

	redirect_with_status('../communities.php', $status);
}

if ($action === 'delete') {
	$community_index = find_community_index_by_id($communities, $community_id);
	if ($community_index === null) {
		redirect_with_status('../communities.php', 'community_not_found');
	}

	$community = $communities[$community_index];
	if (!user_can_manage_community($community, $user)) {
		redirect_with_status('../communities.php', 'not_allowed');
	}

	array_splice($communities, $community_index, 1);
	$posts_path = __DIR__ . '/../data/items.json';
	$posts = read_json_file($posts_path, []);
	$posts = array_values(array_filter($posts, function ($post) use ($community_id) {
		return (string) ($post['communityId'] ?? '') !== (string) $community_id;
	}));

	if (!write_json_file($communities_path, $communities) || !write_json_file($posts_path, $posts)) {
		redirect_with_status('../communities.php', 'save_failed');
	}

	redirect_with_status('../communities.php', 'community_deleted');
}

if ($name === '' || $description === '') {
	$target = $action === 'update' ? '../community.php?id=' . urlencode($community_id) : '../community.php';
	redirect_with_status($target, 'missing_fields');
}

if ($icon_url !== '' && !filter_var($icon_url, FILTER_VALIDATE_URL)) {
	$target = $action === 'update' ? '../community.php?id=' . urlencode($community_id) : '../community.php';
	redirect_with_status($target, 'invalid_icon_url');
}

if (!in_array($visibility, ['public', 'private'], true)) {
	$visibility = 'public';
}

$slug = strtolower(preg_replace('/[^a-z0-9]+/i', '-', $name));
$slug = trim($slug, '-');
if ($slug === '') {
	$slug = 'community';
}

$existing_ids = array_map(function ($community) {
	return (string) ($community['id'] ?? '');
}, $communities);
$id = $slug;
$counter = 2;
while (in_array($id, $existing_ids, true)) {
	$id = $slug . '-' . $counter;
	$counter++;
}

if ($action === 'create') {
	$communities[] = [
		'id' => $id,
		'name' => $name,
		'description' => $description,
		'visibility' => $visibility,
		'iconUrl' => $icon_url,
		'icon' => community_initial($name),
		'color' => community_color($name),
		'members' => 1,
		'adminIds' => [$user['id'] ?? ''],
		'memberIds' => [$user['id'] ?? ''],
		'createdAt' => date('c'),
	];

	if (!write_json_file($communities_path, $communities)) {
		redirect_with_status('../community.php', 'save_failed');
	}

	redirect_with_status('../communities.php', 'community_created');
}

$community_index = find_community_index_by_id($communities, $community_id);
if ($community_index === null) {
	redirect_with_status('../communities.php', 'community_not_found');
}

$community = $communities[$community_index];
if (!user_can_manage_community($community, $user)) {
	redirect_with_status('../communities.php', 'not_allowed');
}

$communities[$community_index] = array_merge($community, [
	'name' => $name,
	'description' => $description,
	'visibility' => $visibility,
	'iconUrl' => $icon_url,
	'icon' => community_initial($name),
	'color' => community_color($name),
	'updatedAt' => date('c'),
]);

$posts_path = __DIR__ . '/../data/items.json';
$posts = read_json_file($posts_path, []);
foreach ($posts as $index => $post) {
	if ((string) ($post['communityId'] ?? '') === (string) $community_id) {
		$posts[$index]['community'] = $name;
		$posts[$index]['communityColor'] = community_color($name);
		$posts[$index]['communityIconUrl'] = $icon_url;
	}
}

if (!write_json_file($communities_path, $communities) || !write_json_file($posts_path, $posts)) {
	redirect_with_status('../community.php?id=' . urlencode($community_id), 'save_failed');
}

redirect_with_status('../communities.php', 'community_updated');
