<?php
require_once __DIR__ . '/php/functions.php';

logout_user();
redirect_with_status('login.php', 'logged_out');
