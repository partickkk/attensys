<?php
require_once __DIR__ . '/dbConfig.php';

abstract class BaseModel {
	protected PDO $db;

	public function __construct() {
		global $pdo;
		if (!($pdo instanceof PDO)) {
			throw new RuntimeException('Database connection not initialized.');
		}
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
		$this->db = $pdo;
	}
}

// Load classes after BaseModel is defined to prevent circular requires
require_once __DIR__ . '/../class/user.php';
require_once __DIR__ . '/../class/student.php';
require_once __DIR__ . '/../class/admin.php';
require_once __DIR__ . '/../class/auth.php';

// Procedural wrappers expected by handleForms style
function registerUser(PDO $pdo, string $username, string $password, string $role, ?string $course, ?int $yearLevel): array {
	try {
		$auth = new Auth();
		$id = $auth->register($username, $password, $role, $course, $yearLevel);
		return [
			'statusCode' => '200',
			'message' => 'User registered',
			'id' => $id,
		];
	} catch (Throwable $e) {
		return [
			'statusCode' => '400',
			'message' => $e->getMessage(),
		];
	}
}

function loginUser(PDO $pdo, string $username, string $password): array {
	$auth = new Auth();
	if ($auth->login($username, $password)) {
		return [ 'statusCode' => '200', 'message' => 'Login successful' ];
	}
	return [ 'statusCode' => '401', 'message' => 'Invalid credentials' ];
}

function addCourseModel(PDO $pdo, string $courseName): array {
	try {
		$admin = new Admin();
		$id = $admin->addCourse($courseName);
		return [ 'statusCode' => '200', 'message' => 'Course added', 'id' => $id ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}

function updateCourseModel(PDO $pdo, int $courseId, string $courseName): array {
	try {
		$admin = new Admin();
		$ok = $admin->updateCourse($courseId, $courseName);
		return $ok ? [ 'statusCode' => '200', 'message' => 'Course updated' ] : [ 'statusCode' => '400', 'message' => 'Update failed' ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}

function listCoursesModel(PDO $pdo): array {
	try {
		$admin = new Admin();
		$data = $admin->listCourses();
		return [ 'statusCode' => '200', 'querySet' => $data ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}

function getAttendanceByCourseYearModel(PDO $pdo, string $courseName, int $yearLevel): array {
	try {
		$admin = new Admin();
		$data = $admin->getAttendanceByCourseYear($courseName, $yearLevel);
		return [ 'statusCode' => '200', 'querySet' => $data ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}

function markAttendanceForStudent(PDO $pdo, int $userId, string $status): array {
	try {
		$student = Student::fromUserId($userId);
		if (!$student) {
			return [ 'statusCode' => '404', 'message' => 'Student not found' ];
		}
		$attendanceId = $student->markAttendance($status);
		return [ 'statusCode' => '200', 'message' => 'Attendance recorded', 'id' => $attendanceId ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}

function getStudentHistoryModel(PDO $pdo, int $userId): array {
	try {
		$student = Student::fromUserId($userId);
		if (!$student) {
			return [ 'statusCode' => '404', 'message' => 'Student not found' ];
		}
		$data = $student->getAttendanceHistory();
		return [ 'statusCode' => '200', 'querySet' => $data ];
	} catch (Throwable $e) {
		return [ 'statusCode' => '400', 'message' => $e->getMessage() ];
	}
}
?>
