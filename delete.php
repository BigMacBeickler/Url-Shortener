<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';
require_login();
$user = app_get_current_user(); // Achtung: angepasst, siehe Namenskonflikt
//Nur post, sicherheit.
if($_SERVER['REQUEST_METHOD'] !== 'POST'){
    header('Location: index.php'); 
    exit;
}

$token = $_POST['csfr'] ?? '';
if(!csfr_check($token)) die('Ungültiges Formular.');
//delete url funtktion aufräumen
$id = $_POST['id'] ?? '';
if(delete_url($id, $user['id'])) {
    header('Location: index.php');
    exit;
} else {
    die('Löschen fehlgeschlagen.');
}