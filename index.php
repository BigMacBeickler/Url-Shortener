<?php

//Hauptseite. Zeigt entweder Login/Registrieren oder die URL-Verwaltung an, je nachdem ob eingeloggt oder nicht.

require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';

$user = app_get_current_user();
$urls = load_json(URLS_FILE);
// Zeig die Urls nur für den eingeloggten User
if($user) {
  $myUrls = array_filter($urls, function($u) use($user){ return $u['user_id'] === $user['id']; });
}
?>
<div class="box">
  <h1 class="title">Willkommen bei beisshorturls</h1>
  <p>Erstelle und verwalte Deine Kurz-URLs. Melde dich an, um loszulegen.</p>
</div>


<?php if($user): ?>
  <!--Abfrage um zu bestimmen welche Ansicht gezeigt wird-->
  <!--Dieser Unterschied wie man Kommentare schreib zwischen HTML und PHP ist etwas nervig...-->
  <div class="box">
    <h2 class="subtitle">Neue Kurz-URL erstellen</h2>
    <form action="create.php" method="post">
      <input type="hidden" name="csfr" value="<?= e(csfr_token()) ?>">
      <div class="field">
        <label class="label">Lange URL</label>
        <div class="control"><input class="input" name="long_url" placeholder="https://example.com/..." required></div>
      </div>
      <div class="field">
        <label class="label">Wunsch-Slug (optional)</label>
        <div class="control"><input class="input" name="slug" placeholder="Optional: abc123"></div>
      </div>
      <div class="field">
      <label class="label">Beschreibung</label>
        <div class="control">
          <div class="control"><input class="input" name="description" placeholder="Optional: am besten was schlaues"></div>
        </div>
      </div>
      <div class="field"><div class="control"><button class="button is-primary">Erstellen</button></div></div>
    </form>
  </div>

  <div class="box">
    <h2 class="subtitle">Deine Kurz-URLs</h2>
    <table class="table is-fullwidth">
      <thead><tr><th>Slug</th><th>Ziel-URL</th><th>Beschreibung</th><th>Visits</th><th>Aktionen</th></tr></thead>
      <tbody>
      <?php foreach($myUrls as $u): ?>
        <tr>
          <td><a href="<?= e($u['slug']) ?>" target="_blank"><?= e($u['slug']) ?></a></td>
          <td style="max-width:400px; overflow:hidden; text-overflow:ellipsis;"><?= e($u['long_url']) ?></td>
          <td style="max-width:200px; overflow:hidden; text-overflow:ellipsis;"><?= e($u['description']) ?></td>
          <td><?= intval($u['visits']) ?></td>
          <td class="is-actions">
            <a class="button is-small" href="edit.php?id=<?= e($u['id']) ?>">Bearbeiten</a>
            <form style="display:inline" method="post" action="delete.php" onsubmit="return confirm('Löschen?');">
              <input type="hidden" name="csfr" value="<?= e(csfr_token()) ?>">
              <input type="hidden" name="id" value="<?= e($u['id']) ?>">
              <button class="button is-small is-danger">Löschen</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>

<?php else: ?>
  <div class="box">
    <a class="button is-primary" href="register.php">Registrieren</a>
    <a class="button is-light" href="login.php">Login</a>
  </div>
<?php endif; ?>



<?php require __DIR__ . '/inc/footer.php'; ?>