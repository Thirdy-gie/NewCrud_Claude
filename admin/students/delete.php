<?php
require_once '../../config/database.php';require_once '../../config/helpers.php';require_role('admin');
if($_SERVER['REQUEST_METHOD']!=='POST'){header('Location: index.php');exit;}verify_csrf();$id=(int)($_POST['id']??0);
$stmt=mysqli_prepare($conn,"DELETE FROM users WHERE id=? AND role='student'");mysqli_stmt_bind_param($stmt,'i',$id);
if(mysqli_stmt_execute($stmt)&&mysqli_stmt_affected_rows($stmt)>0)flash('Student and associated enrollments deleted.');else flash('Student could not be deleted or was not found.','danger');
header('Location: index.php');exit;
