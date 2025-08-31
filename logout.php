<?php
require_once __DIR__ . '/inc/functions.php';

// Session beenden
session_start();
$_SESSION = [];
session_destroy();

// Zur Startseite weiterleiten
header('Location: index.php');
exit;
