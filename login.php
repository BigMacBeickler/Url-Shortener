<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';

$errors = [];
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $token = $_POST['csrf'] ?? '';
    if(!csrf_check($token)) $errors[] = 'Ungültiges Formular.';
    if(empty($errors)){
        $user = verify_user($username, $password);
        if($user){
            $_SESSION['user_id'] = $user['id'];
            header('Location: index.php'); exit;
        } else {
            $errors[] = 'Login fehlgeschlagen.';
        }
    }
}
?>
<div class="box">
  <h1 class="title">Login</h1>
  <?php if(!empty($_GET['msg']) && $_GET['msg'] === 'registered'): ?>
    <div class="notification is-success">Registrierung erfolgreich. Bitte einloggen.</div>
  <?php endif; ?>
  <?php foreach($errors as $err): ?>
    <div class="notification is-danger"><?= e($err) ?></div>
  <?php endforeach; ?>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <div class="field">
      <label class="label">Benutzername</label>
      <div class="control"><input class="input" name="username" required></div>
    </div>
    <div class="field">
      <label class="label">Passwort</label>
      <div class="control"><input class="input" type="password" name="password" required></div>
    </div>
    <div class="field">
      <div class="control"><button class="button is-primary">Login</button></div>
    </div>
  </form>
</div>
<?php require __DIR__ . '/inc/footer.php'; ?>