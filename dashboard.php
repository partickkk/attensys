<?php
require_once __DIR__ . '/core/dbConfig.php';
if (!isset($_SESSION['user_id'])) {
	header('Location: /index.php');
	exit;
}
$role = $_SESSION['role'] ?? 'student';
if ($role === 'admin') {
	header('Location: /admin/admin_home.php');
	exit;
}
header('Location: /student/student_home.php');
exit;
?>
