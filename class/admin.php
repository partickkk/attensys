<?php
require_once __DIR__ . '/../core/models.php';

class Admin extends User {
	public function addCourse(string $courseName): int {
		$stmt = $this->db->prepare('INSERT INTO courses (course_name) VALUES (?)');
		$stmt->execute([$courseName]);
		return (int)$this->db->lastInsertId();
	}

	public function updateCourse(int $courseId, string $courseName): bool {
		$stmt = $this->db->prepare('UPDATE courses SET course_name = ? WHERE id = ?');
		return $stmt->execute([$courseName, $courseId]);
	}

	public function listCourses(): array {
		$stmt = $this->db->query('SELECT * FROM courses ORDER BY course_name');
		return $stmt->fetchAll();
	}

	public function getAttendanceByCourseYear(string $courseName, int $yearLevel): array {
		$sql = 'SELECT a.id, u.username, u.course, u.year_level, a.date, a.status, a.late
				FROM attendance a
				JOIN users u ON a.student_id = u.id
				WHERE u.course = ? AND u.year_level = ?
				ORDER BY a.date DESC';
		$stmt = $this->db->prepare($sql);
		$stmt->execute([$courseName, $yearLevel]);
		return $stmt->fetchAll();
	}
}
?>
