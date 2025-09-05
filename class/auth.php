<?php
require_once __DIR__ . '/../core/models.php';

class Auth extends BaseModel {
	public function register(string $username, string $password, string $role, ?string $course, ?int $yearLevel): int {
		$user = new User();
		return $user->create($username, $password, $role, $course, $yearLevel);
	}

	public function login(string $username, string $password): bool {
		$userModel = new User();
		$user = $userModel->findByUsername($username);
		if (!$user) {
			return false;
		}
		if (!password_verify($password, $user->passwordHash)) {
			return false;
		}
		$_SESSION['user_id'] = $user->id;
		$_SESSION['role'] = $user->role;
		return true;
	}

	public static function logout(): void {
		session_destroy();
	}

	public static function requireRole(string $role): void {
		if (!isset($_SESSION['role']) || $_SESSION['role'] !== $role) {
			header('Location: /index.php');
			exit;
		}
	}
}
?>
