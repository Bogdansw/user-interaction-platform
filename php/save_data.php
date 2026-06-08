<?php
require_once __DIR__ . '/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	redirect_with_status('../contact.php', 'invalid_request');
}

$action = clean_value($_POST['action'] ?? '');
if ($action !== 'contact') {
	redirect_with_status('../contact.php', 'invalid_request');
}

$name = clean_value($_POST['name'] ?? '');
$email = clean_value($_POST['email'] ?? '');
$subject = clean_value($_POST['subject'] ?? '');
$message = clean_value($_POST['message'] ?? '');

if ($name === '' || $email === '' || $subject === '' || $message === '') {
	redirect_with_status('../contact.php', 'missing_fields');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	redirect_with_status('../contact.php', 'invalid_email');
}

$messages_path = __DIR__ . '/../data/messages.json';
$messages = read_json_file($messages_path, []);

$messages[] = [
	'id' => uniqid('msg_', true),
	'name' => $name,
	'email' => $email,
	'subject' => $subject,
	'message' => $message,
	'createdAt' => date('c'),
];

if (!write_json_file($messages_path, $messages)) {
	redirect_with_status('../contact.php', 'save_failed');
}

redirect_with_status('../contact.php', 'sent');
