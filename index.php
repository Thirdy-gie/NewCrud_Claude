<?php
require_once 'config/database.php';
require_once 'config/helpers.php';
if (!empty($_SESSION['user_id'])) {
    header('Location: '.(($_SESSION['role'] ?? '') === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php')); exit;
}
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    verify_csrf();
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    $stmt = mysqli_prepare($conn, 'SELECT id, full_name, username, password, role, student_no FROM users WHERE username = ? LIMIT 1');
    mysqli_stmt_bind_param($stmt, 's', $username); mysqli_stmt_execute($stmt);
    $user = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = (int)$user['id']; $_SESSION['full_name'] = $user['full_name'];
        $_SESSION['username'] = $user['username']; $_SESSION['role'] = $user['role'];
        $_SESSION['student_no'] = $user['student_no'];
        header('Location: '.($user['role'] === 'admin' ? 'admin/dashboard.php' : 'student/dashboard.php')); exit;
    }
    $error = 'Invalid username or password.';
}
?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Clark College Science of Technology · Student Management System</title>
<link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet"><link href="assets/css/style.css" rel="stylesheet"></head>
<body class="login-page"><main class="login-shell"><section class="login-brand"><img class="school-logo login-school-logo" src="assets/images/school-logo.jpg" alt="Clark College of Science and Technology official logo"><p class="eyebrow">OFFICIAL COLLEGE PORTAL</p><h1>Clark College Science of Technology</h1><p class="brand-copy">Student Management System for organized academic records, subjects, and enrollment.</p><div class="brand-foot">Clark College Science of Technology · Student Management System</div></section>
<section class="login-panel"><div class="login-form"><img class="school-logo login-school-logo-small" src="assets/images/school-logo.jpg" alt="Clark College of Science and Technology official logo"><p class="eyebrow text-primary">WELCOME BACK</p><h2>Sign in to your college portal</h2><p class="text-muted mb-4">Use your account credentials to continue.</p>
<?php if ($error): ?><div class="alert alert-danger"><?=e($error)?></div><?php endif; ?>
<form method="post" autocomplete="on"><input type="hidden" name="csrf_token" value="<?=e(csrf_token())?>"><div class="mb-3"><label class="form-label" for="username">Username</label><input class="form-control form-control-lg" id="username" name="username" autocomplete="username" required autofocus></div><div class="mb-4"><label class="form-label" for="password">Password</label><input class="form-control form-control-lg" id="password" type="password" name="password" autocomplete="current-password" required></div><button class="btn btn-primary btn-lg w-100">Sign in <span aria-hidden="true">→</span></button></form>
<p class="small text-muted mt-4">Demo credentials are listed in README.md after importing the database.</p></div></section></main></body></html>
