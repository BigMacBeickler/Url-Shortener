<?php
// zentrale Hilfsfunktionen

define('DATA_DIR', __DIR__ . '/../data');
define('USERS_FILE', DATA_DIR . '/users.json');
define('URLS_FILE', DATA_DIR . '/urls.json');

if (session_status() === PHP_SESSION_NONE) session_start();

function ensure_data_files(){
    if(!is_dir(DATA_DIR)) mkdir(DATA_DIR, 0777, true);
    if(!file_exists(USERS_FILE)) file_put_contents(USERS_FILE, json_encode([]), LOCK_EX);
    if(!file_exists(URLS_FILE)) file_put_contents(URLS_FILE, json_encode([]), LOCK_EX);
}
ensure_data_files();

function load_json($file){
    $fp = fopen($file, 'r');
    if(!$fp) return [];
    flock($fp, LOCK_SH);
    $json = stream_get_contents($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    $data = json_decode($json, true);
    return is_array($data) ? $data : [];
}

function save_json($file, $data){
    $fp = fopen($file, 'c+');
    if(!$fp) return false;
    // exklusiv sperren
    if(!flock($fp, LOCK_EX)){
        fclose($fp);
        return false;
    }
    ftruncate($fp, 0);
    rewind($fp);
    $written = fwrite($fp, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));
    fflush($fp);
    flock($fp, LOCK_UN);
    fclose($fp);
    return $written !== false;
}

// Benutzerfunktionen
function find_user_by_username($username){
    $users = load_json(USERS_FILE);
    foreach($users as $u) if(strtolower($u['username']) === strtolower($username)) return $u;
    return null;
}

function create_user($username, $password){
    $users = load_json(USERS_FILE);
    if(find_user_by_username($username)) return false;
    $id = uniqid('u', true);
    $users[] = [
        'id' => $id,
        'username' => $username,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'created_at' => date('c')
    ];
    return save_json(USERS_FILE, $users);
}

function verify_user($username, $password){
    $user = find_user_by_username($username);
    if(!$user) return false;
    return password_verify($password, $user['password']) ? $user : false;
}

function app_get_current_user(){
    if(!empty($_SESSION['user_id'])){
        $users = load_json(USERS_FILE);
        foreach($users as $u) if($u['id'] === $_SESSION['user_id']) return $u;
    }
    return null;
}

function require_login(){
    if(!app_get_current_user()){
        header('Location: login.php');
        exit;
    }
}

// URL-Funktionen
function generate_slug($len = 6){
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $urls = load_json(URLS_FILE);
    do {
        $slug = '';
        for($i=0;$i<$len;$i++) $slug .= $chars[random_int(0, strlen($chars)-1)];
        // uniqueness check
        $exists = false;
        foreach($urls as $u) if($u['slug'] === $slug){ $exists = true; break; }
    } while($exists);
    return $slug;
}

function find_url_by_slug($slug){
    $urls = load_json(URLS_FILE);
    foreach($urls as $u) if($u['slug'] === $slug) return $u;
    return null;
}

function save_new_url($user_id, $slug, $long_url, $description = ''){
    $urls = load_json(URLS_FILE);
    $id = uniqid('r', true);
    $urls[] = [
        'id' => $id,
        'user_id' => $user_id,
        'slug' => $slug,
        'long_url' => $long_url,
        'description' => $description,
        'visits' => 0,
        'created_at' => date('c')
    ];
    return save_json(URLS_FILE, $urls);
}

function update_url($id, $user_id, $new_long_url, $description = ''){
    $urls = load_json(URLS_FILE);
    $changed = false;
    foreach($urls as &$u){
        if($u['id'] === $id && $u['user_id'] === $user_id){
            $u['long_url'] = $new_long_url;
            $u['description'] = $description;
            $changed = true; break;
        }
    }
    if($changed) return save_json(URLS_FILE, $urls);
    return false;
}

function delete_url($id, $user_id){
    $urls = load_json(URLS_FILE);
    $new = [];
    $deleted = false;
    foreach($urls as $u){
        if($u['id'] === $id && $u['user_id'] === $user_id){ $deleted = true; continue; }
        $new[] = $u;
    }
    if($deleted) return save_json(URLS_FILE, $new);
    return false;
}

function increment_visit($slug){
    $urls = load_json(URLS_FILE);
    $changed = false;
    foreach($urls as &$u){
        if($u['slug'] === $slug){ $u['visits'] = intval($u['visits']) + 1; $changed = true; break; }
    }
    if($changed) save_json(URLS_FILE, $urls);
}

// CSRF token (einfach)
function csrf_token(){
    if(empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(16));
    }
    return $_SESSION['csrf_token'];
}
function csrf_check($token){
    return hash_equals($_SESSION['csrf_token'] ?? '', $token ?? '');
}