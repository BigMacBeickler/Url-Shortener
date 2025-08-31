<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';
require_login();
$user = app_get_current_user(); // Achtung: ggf. angepasst, siehe Namenskonflikt-Hinweis

if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php'); 
    exit;
}

$token = $_POST['csrf'] ?? '';
if(!csrf_check($token)) die('Ungültiges Formular.');

$id = $_POST['id'] ?? '';
if(delete_url($id, $user['id'])) {
    header('Location: index.php');
    exit;
} else {
    die('Löschen fehlgeschlagen.');
}