<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';
require_login();
$user = app_get_current_user();

//überschreiben der Daten mit den neuen Werten
$id = $_GET['id'] ?? null;
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $token = $_POST['csfr'] ?? '';
    if(!csfr_check($token)) die('Ungültiges Formular.');
    $id = $_POST['id'] ?? null;
    $newurl = trim($_POST['long_url'] ?? '');
    $description = trim($_POST['description'] ?? '');
    if(!filter_var($newurl, FILTER_VALIDATE_URL)) $error = 'Ungültige URL.';
    else if(update_url($id, $user['id'], $newurl, $description)){
        header('Location: index.php'); exit;
    } else $error = 'Konnte nicht aktualisiert werden.';
}

//aufrufen der zu bearbeitenden url daten aus der json file
$urls = load_json(URLS_FILE);
$entry = null;
foreach($urls as $u) if($u['id'] === $id && $u['user_id'] === $user['id']){ $entry = $u; break; }
if(!$entry) die('Nicht gefunden oder keine Berechtigung.');
?>
<div class="box">
  <h1 class="title">Bearbeite Kurz-URL</h1>
  <?php if(!empty($error)): ?><div class="notification is-danger"><?= e($error) ?></div><?php endif; ?>
  <form method="post">
    <input type="hidden" name="csfr" value="<?= e(csfr_token()) ?>">
    <input type="hidden" name="id" value="<?= e($entry['id']) ?>">
    <div class="field">
      <label class="label">Slug (nicht änderbar)</label>
      <div class="control"><input class="input" value="<?= e($entry['slug']) ?>" disabled></div>
    </div>
    <div class="field">
      <label class="label">Lange URL</label>
      <div class="control"><input class="input" name="long_url" value="<?= e($entry['long_url']) ?>" required></div>
    </div>
    <div class="field">
      <label class="label">Beschreibung</label>
      <div class="control"><input class="input" name="description" value="<?= e($entry['description']) ?>" required></div>
    </div>
    <div class="field"><div class="control"><button class="button is-primary">Speichern</button></div></div>
  </form>
</div>
<?php require __DIR__ . '/inc/footer.php'; ?>