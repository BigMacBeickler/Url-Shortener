<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $token = $_POST['csrf'] ?? '';
    if(!csrf_check($token)) die('Ungültiges Formular.');

    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    if($username && $password){
        $users = load_json(USERS_FILE);
        foreach($users as $u){
            if($u['username'] === $username){
                echo "<div class='notification is-danger'>Benutzername bereits vergeben.</div>";
                require __DIR__ . '/inc/footer.php';
                exit;
            }
        }
        $id = uniqid('u', true);
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $users[] = [
            'id' => $id,
            'username' => $username,
            'password' => $hash,
            'created_at' => date('c')
        ];
        save_json(USERS_FILE, $users);
        $_SESSION['user_id'] = $id;
        header('Location: index.php');
        exit;
    } else {
        echo "<div class='notification is-danger'>Bitte alle Felder ausfüllen.</div>";
    }
}
?>
<div class="box">
  <h1 class="title">Registrieren</h1>
  <form method="post">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <div class="field">
      <label class="label">Benutzername</label>
      <div class="control"><input class="input" name="username" required></div>
    </div>
    <div class="field">
      <label class="label">Passwort</label>
      <div class="control"><input type="password" class="input" name="password" required></div>
    </div>
    <div class="field"><div class="control"><button class="button is-primary">Registrieren</button></div></div>
  </form>
</div>
<?php require __DIR__ . '/inc/footer.php'; ?>
