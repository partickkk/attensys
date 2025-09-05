<?php
require_once __DIR__ . '/dbConfig.php';
require_once __DIR__ . '/models.php';

// Button-driven handlers
if (isset($_POST['registerBtn'])) {
	$username = trim($_POST['username'] ?? '');
	$password = trim($_POST['password'] ?? '');
	$role = $_POST['role'] ?? 'student';
	$course = $_POST['course'] ?? null;
	$year = isset($_POST['year_level']) && $_POST['year_level'] !== '' ? (int)$_POST['year_level'] : null;
	$response = registerUser($pdo, $username, $password, $role, $course, $year);
	$_SESSION['message'] = $response['message'] ?? '';
	header('Location: /index.php' . ($response['statusCode'] === '200' ? '?registered=1' : '?error=1'));
	exit;
}

if (isset($_POST['loginBtn'])) {
	$username = trim($_POST['username'] ?? '');
	$password = trim($_POST['password'] ?? '');
	$response = loginUser($pdo, $username, $password);
	if ($response['statusCode'] === '200') {
		header('Location: /dashboard.php');
		exit;
	}
	$_SESSION['message'] = $response['message'] ?? '';
	header('Location: /index.php?error=1');
	exit;
}

if (isset($_GET['logoutBtn']) || isset($_POST['logoutBtn'])) {
	session_destroy();
	header('Location: /index.php');
	exit;
}

if (isset($_POST['markAttendanceBtn'])) {
	if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'student') {
		header('Location: /index.php');
		exit;
	}
	$status = $_POST['status'] ?? 'Present';
	$response = markAttendanceForStudent($pdo, (int)$_SESSION['user_id'], $status);
	$_SESSION['message'] = $response['message'] ?? '';
	header('Location: /student/attendance_history.php');
	exit;
}

if (isset($_POST['addCourseBtn'])) {
	if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
		header('Location: /index.php');
		exit;
	}
	$courseName = trim($_POST['course_name'] ?? '');
	$response = addCourseModel($pdo, $courseName);
	$_SESSION['message'] = $response['message'] ?? '';
	header('Location: /admin/admin_home.php');
	exit;
}

if (isset($_POST['updateCourseBtn'])) {
	if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
		header('Location: /index.php');
		exit;
	}
	$courseId = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
	$courseName = trim($_POST['course_name'] ?? '');
	$response = updateCourseModel($pdo, $courseId, $courseName);
	$_SESSION['message'] = $response['message'] ?? '';
	header('Location: /admin/admin_home.php');
	exit;
}

// Backward-compatible action-style handlers
$action = $_POST['action'] ?? $_GET['action'] ?? '';
switch ($action) {
	case 'register':
		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$role = $_POST['role'] ?? 'student';
		$course = $_POST['course'] ?? null;
		$year = isset($_POST['year_level']) && $_POST['year_level'] !== '' ? (int)$_POST['year_level'] : null;
		$response = registerUser($pdo, $username, $password, $role, $course, $year);
		$_SESSION['message'] = $response['message'] ?? '';
		header('Location: /index.php' . ($response['statusCode'] === '200' ? '?registered=1' : '?error=1'));
		exit;
	case 'login':
		$username = trim($_POST['username'] ?? '');
		$password = trim($_POST['password'] ?? '');
		$response = loginUser($pdo, $username, $password);
		if ($response['statusCode'] === '200') {
			header('Location: /dashboard.php');
			exit;
		}
		$_SESSION['message'] = $response['message'] ?? '';
		header('Location: /index.php?error=1');
		exit;
	case 'logout':
		session_destroy();
		header('Location: /index.php');
		exit;
	case 'mark_attendance':
		if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'student') {
			header('Location: /index.php');
			exit;
		}
		$status = $_POST['status'] ?? 'Present';
		$response = markAttendanceForStudent($pdo, (int)$_SESSION['user_id'], $status);
		$_SESSION['message'] = $response['message'] ?? '';
		header('Location: /student/attendance_history.php');
		exit;
	case 'add_course':
		if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
			header('Location: /index.php');
			exit;
		}
		$courseName = trim($_POST['course_name'] ?? '');
		$response = addCourseModel($pdo, $courseName);
		$_SESSION['message'] = $response['message'] ?? '';
		header('Location: /admin/admin_home.php');
		exit;
	case 'update_course':
		if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
			header('Location: /index.php');
			exit;
		}
		$courseId = isset($_POST['course_id']) ? (int)$_POST['course_id'] : 0;
		$courseName = trim($_POST['course_name'] ?? '');
		$response = updateCourseModel($pdo, $courseId, $courseName);
		$_SESSION['message'] = $response['message'] ?? '';
		header('Location: /admin/admin_home.php');
		exit;
	default:
		header('Location: /index.php');
		exit;
}
?>
