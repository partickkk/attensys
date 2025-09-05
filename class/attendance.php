<?php
require_once __DIR__ . '/../core/models.php';

class Attendance extends BaseModel {
	public function record(int $studentId, string $status, ?string $date = null, ?string $time = null): int {
		$date = $date ?: date('Y-m-d');
		// If absent, do not mark late
		if (strcasecmp($status, 'Absent') === 0) {
			$late = 'No';
		} else {
			$late = $this->determineLateFlag($time);
		}
		$stmt = $this->db->prepare('INSERT INTO attendance (student_id, date, status, late) VALUES (?, ?, ?, ?)');
		$stmt->execute([$studentId, $date, $status, $late]);
		return (int)$this->db->lastInsertId();
	}

	public function historyForStudent(int $studentId): array {
		$stmt = $this->db->prepare('SELECT date, status, late FROM attendance WHERE student_id = ? ORDER BY date DESC');
		$stmt->execute([$studentId]);
		return $stmt->fetchAll();
	}

	private function determineLateFlag(?string $timeOverride = null): string {
		$tz = new DateTimeZone('Asia/Manila');
		$now = $timeOverride ? DateTime::createFromFormat('H:i:s', $timeOverride, $tz) : new DateTime('now', $tz);
		$cutoff = DateTime::createFromFormat('H:i:s', (defined('TIME_IN_CUTOFF') ? TIME_IN_CUTOFF : '08:00:00'), $tz);
		if (!$now || !$cutoff) {
			return 'No';
		}
		return ($now > $cutoff) ? 'Yes' : 'No';
	}
}
?>
