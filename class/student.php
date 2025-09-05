<?php
require_once __DIR__ . '/../core/models.php';
require_once __DIR__ . '/attendance.php';

class Student extends User {
	public static function fromUserId(int $userId): ?Student {
		$userModel = new User();
		$user = $userModel->findById($userId);
		if (!$user) {
			return null;
		}
		$student = new Student();
		$student->id = $user->id;
		$student->username = $user->username;
		$student->passwordHash = $user->passwordHash;
		$student->role = $user->role;
		$student->course = $user->course;
		$student->year_level = $user->year_level;
		return $student;
	}

	public function markAttendance(string $status): int {
		if ($this->id === null) {
			throw new RuntimeException('Student must be loaded with id');
		}
		$attendance = new Attendance();
		return $attendance->record($this->id, $status);
	}

	public function getAttendanceHistory(): array {
		if ($this->id === null) {
			return [];
		}
		$attendance = new Attendance();
		return $attendance->historyForStudent($this->id);
	}
}
?>
