<?php
require_once __DIR__ . '/inc/functions.php';

$slug = $_GET['slug'] ?? null;
if(!$slug) die('Kein Slug angegeben.');
$entry = find_url_by_slug($slug);
if(!$entry) {
    http_response_code(404);
    echo "Kurz-URL nicht gefunden.";
    exit;
}
// track visit (ignorant of bots)
increment_visit($slug);
header('Location: ' . $entry['long_url'], true, 302);
exit;