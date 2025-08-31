<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$currentUser = app_get_current_user();
require_once __DIR__ . '/functions.php';
function e($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
?>

<!DOCTYPE html>
<html lang="de">
<head>
  <meta charset="UTF-8">
  <title>beisshorturls</title>
  <link rel="stylesheet" href="assets/bulma.min.css">
  <link rel="stylesheet" href="style.css">
</head>
<body>
<nav class="navbar is-primary" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item" href="index.php">
      <strong>beisshorturls</strong>
    </a>

    <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navbarBasic" class="navbar-menu">
    <div class="navbar-start">
      <a class="navbar-item" href="index.php">Startseite</a>
    </div>

    <div class="navbar-end">
      <?php if($currentUser): ?>
        <div class="navbar-item has-dropdown is-hoverable">
          <a class="navbar-link"><?= e($currentUser['username']) ?></a>
          <div class="navbar-dropdown">
            <a class="navbar-item" href="profile.php">Mein Profil</a>
            <hr class="navbar-divider">
            <a class="navbar-item" href="logout.php">Logout</a>
          </div>
        </div>
      <?php else: ?>
        <div class="navbar-item">
          <div class="buttons">
            <a class="button is-light" href="login.php">Login</a>
            <a class="button is-primary" href="register.php">Registrieren</a>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</nav>

<section class="section">
  <div class="container">
