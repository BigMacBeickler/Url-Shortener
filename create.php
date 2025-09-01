//Link creation. csfr check damit kein fremder Unfug anstellt. 
<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';
require_login();
$user = app_get_current_user();
//Nur post, sicherheit.
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php'); exit;
}
$token = $_POST['csrf'] ?? '';
if(!csrf_check($token)) die('Ungültiges Formular.'); //die --> nicht der Artikel, sondern stirb
$long = trim($_POST['long_url'] ?? '');
$slug = trim($_POST['slug'] ?? '');
$description = trim($_POST['description'] ?? '');

if(!filter_var($long, FILTER_VALIDATE_URL)){
    die('Ungültige URL.');
}
if($slug === ''){
    $slug = generate_slug(6);
} else {
    // prüfen auf zulässige zeichen und ob bereits vorhanden
    if(!preg_match('/^[A-Za-z0-9_-]{3,}$/', $slug)) die('Ungültiger Slug.'); //reg-ex magic
    if(find_url_by_slug($slug)) die('Slug existiert bereits.');
}
if(save_new_url($user['id'], $slug, $long, $description)){
    header('Location: index.php'); exit;
} else {
    die('Fehler beim Speichern.');
}
