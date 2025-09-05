<?php
require_once __DIR__ . '/../core/dbConfig.php';
$title = $title ?? '';
$role = $_SESSION['role'] ?? null;
$homeHref = '/';
if ($role === 'admin') { $homeHref = '/admin/admin_home.php'; }
if ($role === 'student') { $homeHref = '/student/student_home.php'; }
?>
<nav class="navbar px-3">
	<a class="navbar-brand" href="<?php echo $homeHref; ?>"><?php echo $title ? htmlspecialchars($title) : ($role ? ucfirst($role) : 'Home'); ?></a>
	<a href="/logout.php" class="btn btn-outline-danger btn-sm">Logout</a>
</nav>
