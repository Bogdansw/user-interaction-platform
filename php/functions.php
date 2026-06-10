<?php

function clean_value($value) {
	return trim((string) $value);
}

function read_json_file($path, $default = []) {
	if (!file_exists($path)) {
		return $default;
	}

	$raw = file_get_contents($path);
	if ($raw === false) {
		return $default;
	}

	$data = json_decode($raw, true);
	if (!is_array($data)) {
		return $default;
	}

	return $data;
}

function write_json_file($path, $data) {
	$json = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
	if ($json === false) {
		return false;
	}

	return file_put_contents($path, $json) !== false;
}

function redirect_with_status($path, $status) {
	header('Location: ' . $path . '?status=' . urlencode($status));
	exit;
}

function ensure_session_started() {
	if (session_status() !== PHP_SESSION_ACTIVE) {
		session_start();
	}
}

function current_user() {
	ensure_session_started();
	return $_SESSION['user'] ?? null;
}

function require_login($redirect_path = 'login.php') {
	ensure_session_started();
	if (empty($_SESSION['user'])) {
		redirect_with_status($redirect_path, 'login_required');
	}
}

function logout_user() {
	ensure_session_started();
	$_SESSION = [];

	if (ini_get('session.use_cookies')) {
		$params = session_get_cookie_params();
		setcookie(
			session_name(),
			'',
			time() - 42000,
			$params['path'],
			$params['domain'],
			$params['secure'],
			$params['httponly']
		);
	}

	session_destroy();
}

function find_user_by_email($users, $email) {
	foreach ($users as $user) {
		if (isset($user['email']) && strtolower($user['email']) === strtolower($email)) {
			return $user;
		}
	}

	return null;
}

function user_initials($name, $fallback = 'GU') {
	$name = trim((string) $name);
	if ($name === '') {
		return $fallback;
	}
	$parts = preg_split('/\s+/', $name);
	if (count($parts) >= 2) {
		return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
	}
	return strtoupper(substr($name, 0, 2));
}

function format_time_ago($iso) {
	$timestamp = strtotime((string) $iso);
	if ($timestamp === false) {
		return 'just now';
	}
	$diff = time() - $timestamp;
	if ($diff < 60) {
		return 'just now';
	}
	if ($diff < 3600) {
		$mins = (int) floor($diff / 60);
		return $mins . 'm ago';
	}
	if ($diff < 86400) {
		$hours = (int) floor($diff / 3600);
		return $hours . 'h ago';
	}
	$days = (int) floor($diff / 86400);
	return $days . 'd ago';
}

function badge_config($type) {
	$normalized = strtolower((string) $type);
	if ($normalized === 'photo') {
		return ['label' => 'PHOTO', 'class' => 'badge-photo'];
	}
	if ($normalized === 'audio') {
		return ['label' => 'AUDIO', 'class' => 'badge-audio'];
	}
	return ['label' => 'DISCUSSION', 'class' => 'badge-discussion'];
}

function platform_name() {
	return 'user-platform';
}

function available_communities() {
	$communities = read_json_file(dirname(__DIR__) . '/data/communities.json', []);
	return array_values(array_map('normalize_community', $communities));
}

function normalize_community($community) {
	$name = (string) ($community['name'] ?? 'Community');
	$icon = clean_value($community['icon'] ?? '');
	if ($icon === '') {
		$icon = community_initial($name);
	}
	$color = clean_value($community['color'] ?? '');
	if ($color === '') {
		$color = community_color($name);
	}

	return [
		'id' => (string) ($community['id'] ?? ''),
		'name' => $name,
		'description' => (string) ($community['description'] ?? ''),
		'visibility' => (string) ($community['visibility'] ?? 'public'),
		'iconUrl' => (string) ($community['iconUrl'] ?? ''),
		'icon' => strtoupper(substr($icon, 0, 2)),
		'initial' => strtoupper(substr($icon, 0, 2)),
		'color' => $color,
		'members' => format_member_count((int) ($community['members'] ?? count($community['memberIds'] ?? []))),
		'memberCount' => (int) ($community['members'] ?? count($community['memberIds'] ?? [])),
		'adminIds' => is_array($community['adminIds'] ?? null) ? $community['adminIds'] : [],
		'memberIds' => is_array($community['memberIds'] ?? null) ? $community['memberIds'] : [],
		'pendingMemberIds' => is_array($community['pendingMemberIds'] ?? null) ? $community['pendingMemberIds'] : [],
		'createdAt' => (string) ($community['createdAt'] ?? ''),
	];
}

function community_initial($name) {
	$name = clean_value($name);
	if ($name === '') {
		return 'C';
	}

	return strtoupper(substr($name, 0, 1));
}

function community_color($name) {
	$palette = ['#2f4f3b', '#4f2f2f', '#3b3f5b', '#5a4630', '#2f4b5b', '#4b3a5c', '#315247', '#5b3b4b'];
	$index = abs(crc32((string) $name)) % count($palette);
	return $palette[$index];
}

function format_member_count($count) {
	if ($count >= 1000) {
		$formatted = number_format($count / 1000, 1);
		return rtrim(rtrim($formatted, '0'), '.') . 'k';
	}

	return (string) $count;
}

function find_community($community_id) {
	foreach (available_communities() as $community) {
		if ($community['id'] === $community_id) {
			return $community;
		}
	}

	return null;
}

function find_user_index($users, $user_id, $email = '') {
	foreach ($users as $index => $user) {
		if ($user_id !== '' && (string) ($user['id'] ?? '') === (string) $user_id) {
			return $index;
		}

		if ($email !== '' && strtolower((string) ($user['email'] ?? '')) === strtolower((string) $email)) {
			return $index;
		}
	}

	return null;
}

function is_valid_http_url($url) {
	$url = clean_value($url);
	if ($url === '') {
		return true;
	}

	if (!filter_var($url, FILTER_VALIDATE_URL)) {
		return false;
	}

	$scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
	return in_array($scheme, ['http', 'https'], true);
}

function find_post_index_by_id($posts, $post_id) {
	foreach ($posts as $index => $post) {
		if ((string) ($post['id'] ?? '') === (string) $post_id) {
			return $index;
		}
	}

	return null;
}

function normalize_id_list($value) {
	if (!is_array($value)) {
		return [];
	}

	return array_values(array_unique(array_filter(array_map('strval', $value), function ($item) {
		return $item !== '';
	})));
}

function toggle_reaction(&$target, $user_id, $reaction) {
	$liked = normalize_id_list($target['likedBy'] ?? []);
	$disliked = normalize_id_list($target['dislikedBy'] ?? []);

	if ($reaction === 'like') {
		if (in_array($user_id, $liked, true)) {
			$liked = array_values(array_diff($liked, [$user_id]));
		} else {
			$liked[] = $user_id;
			$disliked = array_values(array_diff($disliked, [$user_id]));
		}
	}

	if ($reaction === 'dislike') {
		if (in_array($user_id, $disliked, true)) {
			$disliked = array_values(array_diff($disliked, [$user_id]));
		} else {
			$disliked[] = $user_id;
			$liked = array_values(array_diff($liked, [$user_id]));
		}
	}

	$target['likedBy'] = normalize_id_list($liked);
	$target['dislikedBy'] = normalize_id_list($disliked);
}

function count_comments($comments) {
	if (!is_array($comments)) {
		return 0;
	}

	$count = 0;
	foreach ($comments as $comment) {
		$count++;
		$count += count_comments($comment['replies'] ?? []);
	}

	return $count;
}

function &find_comment_mutable(&$comments, $comment_id) {
	foreach ($comments as &$comment) {
		if ((string) ($comment['id'] ?? '') === (string) $comment_id) {
			return $comment;
		}

		if (!isset($comment['replies']) || !is_array($comment['replies'])) {
			$comment['replies'] = [];
		}

		$found = &find_comment_mutable($comment['replies'], $comment_id);
		if ($found !== null) {
			return $found;
		}
	}

	$null = null;
	return $null;
}

function find_community_index_by_id($communities, $community_id) {
	foreach ($communities as $index => $community) {
		if ((string) ($community['id'] ?? '') === (string) $community_id) {
			return $index;
		}
	}

	return null;
}

function user_can_manage_community($community, $user) {
	$user_id = (string) ($user['id'] ?? '');
	if ($user_id === '') {
		return false;
	}

	$admin_ids = $community['adminIds'] ?? [];
	return in_array($user_id, $admin_ids, true);
}

function user_is_community_member($community, $user) {
	$user_id = (string) ($user['id'] ?? '');
	if ($user_id === '') {
		return false;
	}

	$member_ids = $community['memberIds'] ?? [];
	return in_array($user_id, $member_ids, true);
}

function user_has_pending_community_request($community, $user) {
	$user_id = (string) ($user['id'] ?? '');
	if ($user_id === '') {
		return false;
	}

	$pending_ids = $community['pendingMemberIds'] ?? [];
	return in_array($user_id, $pending_ids, true);
}

function brand_logo_path() {
	$candidates = [
		'images/logo.png',
		'images/logo.jpg',
		'images/logo.jpeg',
		'images/logo.webp',
		'ui/logo.png',
		'ui/logo.jpg',
		'ui/logo.webp',
	];

	foreach ($candidates as $path) {
		if (file_exists(dirname(__DIR__) . '/' . $path)) {
			return $path;
		}
	}

	return '';
}

function asset_version($path) {
	$relative = ltrim((string) $path, '/\\');
	$full_path = dirname(__DIR__) . '/' . $relative;
	if (!file_exists($full_path)) {
		return $relative;
	}

	return $relative . '?v=' . filemtime($full_path);
}

function ui_icon($name, $size = 18, $attrs = []) {
	$allowed = [
		'home', 'popular', 'explore', 'saved', 'communities', 'search',
		'notifications', 'support', 'settings', 'sun', 'moon', 'language',
		'logout', 'like', 'dislike', 'comments', 'new', 'top', 'menu', 'despre',
	];
	$key = strtolower(trim((string) $name));
	if (!in_array($key, $allowed, true)) {
		return '';
	}

	$path = 'ui/icons/' . $key . '.png';
	$full_path = dirname(__DIR__) . '/' . $path;
	if (!file_exists($full_path)) {
		return '';
	}

	$size = (int) $size;
	$alt = (string) ($attrs['alt'] ?? '');
	$class = 'ui-icon' . (isset($attrs['class']) ? ' ' . $attrs['class'] : '');
	$aria = $alt !== '' ? '' : ' aria-hidden="true"';

	return '<img src="' . htmlspecialchars($path) . '" width="' . $size . '" height="' . $size . '" alt="' . htmlspecialchars($alt) . '" class="' . htmlspecialchars(trim($class)) . '"' . $aria . '>';
}
