<?php

class User extends BaseModel {
	public ?int $id = null;
	public string $username = '';
	public string $passwordHash = '';
	public string $role = '';
	public ?string $course = null;
	public ?int $year_level = null;

	public function __construct() {
		parent::__construct();
	}

	public static function fromRow(array $row): User {
		$user = new self();
		$user->id = isset($row['id']) ? (int)$row['id'] : null;
		$user->username = $row['username'] ?? '';
		$user->passwordHash = $row['password'] ?? '';
		$user->role = $row['role'] ?? '';
		$user->course = $row['course'] ?? null;
		$user->year_level = isset($row['year_level']) ? (int)$row['year_level'] : null;
		return $user;
	}

	public function create(string $username, string $password, string $role, ?string $course, ?int $yearLevel): int {
		$hash = password_hash($password, PASSWORD_BCRYPT);
		$stmt = $this->db->prepare('INSERT INTO users (username, password, role, course, year_level) VALUES (?, ?, ?, ?, ?)');
		$stmt->execute([$username, $hash, $role, $course, $yearLevel]);
		return (int)$this->db->lastInsertId();
	}

	public function findByUsername(string $username): ?User {
		$stmt = $this->db->prepare('SELECT * FROM users WHERE username = ? LIMIT 1');
		$stmt->execute([$username]);
		$row = $stmt->fetch();
		return $row ? self::fromRow($row) : null;
	}

	public function findById(int $id): ?User {
		$stmt = $this->db->prepare('SELECT * FROM users WHERE id = ? LIMIT 1');
		$stmt->execute([$id]);
		$row = $stmt->fetch();
		return $row ? self::fromRow($row) : null;
	}
}
?>
