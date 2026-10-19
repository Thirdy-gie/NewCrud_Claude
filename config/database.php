<?php
mysqli_report(MYSQLI_REPORT_OFF);
$host = getenv('DB_HOST') ?: 'localhost';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';
$db   = getenv('DB_NAME') ?: 'flores_2ee';
$conn = mysqli_connect($host, $user, $pass, $db);
if (!$conn) {
    http_response_code(500);
    exit('Database connection failed. Check config/database.php and confirm MySQL is running.');
}
mysqli_set_charset($conn, 'utf8mb4');
