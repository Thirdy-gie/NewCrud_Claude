<?php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
function require_role($role) {
    if (empty($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== $role) {
        header('Location: ' . (strpos($_SERVER['SCRIPT_NAME'], '/admin/') !== false ? '../../index.php' : '../index.php'));
        exit;
    }
}
function flash($message, $type='success') { $_SESSION['flash'] = ['message'=>$message, 'type'=>$type]; }
function show_flash() {
    if (!empty($_SESSION['flash'])) {
        $f = $_SESSION['flash']; unset($_SESSION['flash']);
        echo '<div class="alert alert-'.e($f['type']).' alert-dismissible fade show" role="alert">'.e($f['message']).'<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>';
    }
}
function csrf_token() {
    if (empty($_SESSION['csrf_token'])) $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf_token'];
}
function verify_csrf() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && !hash_equals($_SESSION['csrf_token'] ?? '', $_POST['csrf_token'] ?? '')) {
        http_response_code(419); exit('Invalid form token. Please go back, refresh, and try again.');
    }
}
