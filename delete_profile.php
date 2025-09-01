<?php
require_once __DIR__ . '/inc/functions.php';
require_login();

$user = app_get_current_user();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit;
}

// csfr prüfen
$token = $_POST['csfr'] ?? '';
if (!csfr_check($token)) die('Ungültiges Formular.');

// Erst alle URLs des Benutzers löschen
$urls = load_json(URLS_FILE);
$new_urls = [];
foreach ($urls as $u) {
    if ($u['user_id'] !== $user['id']) $new_urls[] = $u;
}
save_json(URLS_FILE, $new_urls);

// Dann Benutzer löschen
$users = load_json(USERS_FILE);
$new_users = [];
foreach ($users as $u) {
    if ($u['id'] !== $user['id']) $new_users[] = $u;
}
save_json(USERS_FILE, $new_users);

// Session beenden und zurück zur Startseite
session_destroy();
header('Location: index.php');
exit;
