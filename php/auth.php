<?php
session_start();

require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirect_with_status('../login.php', 'invalid_request');
}

$action = clean_value($_POST['action'] ?? '');
$users_path = __DIR__ . '/../data/users.json';
$users = read_json_file($users_path, []);

if ($action === 'login') {
	$email = clean_value($_POST['email'] ?? '');
	$password = (string) ($_POST['password'] ?? '');

	if ($email === '' || $password === '') {
		redirect_with_status('../login.php', 'missing_fields');
	}

	$user = find_user_by_email($users, $email);
	if (!$user || !isset($user['password']) || !password_verify($password, $user['password'])) {
		redirect_with_status('../login.php', 'invalid_credentials');
	}

	session_regenerate_id(true);

	$_SESSION['user'] = [
		'id' => $user['id'] ?? null,
		'name' => $user['name'] ?? 'User',
		'email' => $user['email'] ?? $email,
		'avatarUrl' => $user['avatarUrl'] ?? '',
	];

	redirect_with_status('../index.php', 'login_success');
}

if ($action === 'register') {
	$name = clean_value($_POST['name'] ?? '');
	$email = clean_value($_POST['email'] ?? '');
	$password = (string) ($_POST['password'] ?? '');
	$confirm = (string) ($_POST['confirm_password'] ?? '');

	if ($name === '' || $email === '' || $password === '' || $confirm === '') {
		redirect_with_status('../register.php', 'missing_fields');
	}

	if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		redirect_with_status('../register.php', 'invalid_email');
	}

	if (strlen($password) < 6) {
		redirect_with_status('../register.php', 'password_too_short');
	}

	if ($password !== $confirm) {
		redirect_with_status('../register.php', 'password_mismatch');
	}

	if (find_user_by_email($users, $email)) {
		redirect_with_status('../register.php', 'email_exists');
	}

	$users[] = [
		'id' => uniqid('user_', true),
		'name' => $name,
		'email' => $email,
		'password' => password_hash($password, PASSWORD_DEFAULT),
		'avatarUrl' => '',
		'createdAt' => date('c'),
	];

	if (!write_json_file($users_path, $users)) {
		redirect_with_status('../register.php', 'save_failed');
	}

	redirect_with_status('../login.php', 'registered');
}

redirect_with_status('../login.php', 'invalid_request');
