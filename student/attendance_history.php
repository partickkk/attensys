<?php
require_once __DIR__ . '/../core/dbConfig.php';
require_once __DIR__ . '/../class/auth.php';
require_once __DIR__ . '/../class/student.php';
Auth::requireRole('student');

$userId = $_SESSION['user_id'] ?? null;
$history = [];
if ($userId) {
	$userModel = new User();
	$user = $userModel->findById((int)$userId);
	$student = new Student();
	$student->id = $user?->id;
	$history = $student->getAttendanceHistory();
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/style.css" rel="stylesheet">
	<title>My Attendance History</title>
</head>
<body>
	<?php $title = 'Student'; require __DIR__ . '/../partials/navbar.php'; ?>
	<div class="container py-4">
		<h4 class="mb-3">My Attendance History</h4>
		<div class="table-responsive">
			<table class="table table-bordered table-striped align-middle">
				<thead>
					<tr>
						<th>#</th>
						<th>Date</th>
						<th>Status</th>
						<th>Late</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($history as $i => $r): ?>
					<tr>
						<td><?php echo $i + 1; ?></td>
						<td><?php echo htmlspecialchars($r['date']); ?></td>
						<td><?php echo htmlspecialchars($r['status']); ?></td>
						<td><?php echo htmlspecialchars($r['late']); ?></td>
					</tr>
					<?php endforeach; ?>
					<?php if (empty($history)): ?>
					<tr><td colspan="4" class="text-center text-muted">No records</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
