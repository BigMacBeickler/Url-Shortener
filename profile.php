<?php
require_once __DIR__ . '/inc/functions.php';
require_once __DIR__ . '/inc/header.php';

require_login();
$user = app_get_current_user();
$urls = load_json(URLS_FILE);

// Filter für eigene URLs
$myUrls = array_filter($urls, fn($u) => $u['user_id'] === $user['id']);
?>

<div class="box">
  <h1 class="title">Mein Profil</h1>
  <p><strong>Benutzername:</strong> <?= e($user['username']) ?></p>
  <p><strong>Registriert am:</strong> <?= e($user['created_at']) ?></p>
</div>

<div class="box">
  <h2 class="subtitle">Meine Kurz-URLs</h2>
  <?php if(count($myUrls) === 0): ?>
    <p>Du hast noch keine URLs angelegt.</p>
  <?php else: ?>
    <table class="table is-fullwidth">
      <thead>
        <tr>
          <th>Slug</th>
          <th>Lang-URL</th>
          <th>Visits</th>
          <th>Aktionen</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($myUrls as $u): ?>
        <tr>
          <td><a href="<?= e($u['slug']) ?>"><?= e($u['slug']) ?></a></td>
          <td style="max-width:400px; overflow:hidden; text-overflow:ellipsis;"><?= e($u['long_url']) ?></td>
          <td><?= intval($u['visits']) ?></td>
          <td class="is-actions">
            <a class="button is-small" href="edit.php?id=<?= e($u['id']) ?>">Bearbeiten</a>
            <form style="display:inline" method="post" action="delete.php" onsubmit="return confirm('Willst du diese URL löschen?');">
              <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
              <input type="hidden" name="id" value="<?= e($u['id']) ?>">
              <button class="button is-small is-danger">Löschen</button>
            </form>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>
</div>

<div class="box">
  <h2 class="subtitle">Profil löschen</h2>
  <form method="post" action="delete_profile.php" onsubmit="return confirm('Willst du wirklich dein Profil und alle deine URLs löschen?');">
    <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
    <button class="button is-danger">Profil & URLs löschen</button>
  </form>
</div>

<?php require __DIR__ . '/inc/footer.php'; ?>
