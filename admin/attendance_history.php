<?php
require_once __DIR__ . '/../core/dbConfig.php';
require_once __DIR__ . '/../class/auth.php';
require_once __DIR__ . '/../class/admin.php';
Auth::requireRole('admin');
$course = $_GET['course'] ?? '';
$year = isset($_GET['year']) ? (int)$_GET['year'] : 0;
$rows = [];
if ($course && $year) {
	$admin = new Admin();
	$rows = $admin->getAttendanceByCourseYear($course, $year);
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./style.css" rel="stylesheet">
	<title>Attendance History</title>
</head>
<body>
	<?php $title = 'Admin'; require __DIR__ . '/../partials/navbar.php'; ?>
	<div class="container py-4">
		<h4 class="mb-3">Attendance - <?php echo htmlspecialchars($course); ?> (Year <?php echo htmlspecialchars((string)$year); ?>)</h4>
		<div class="table-responsive">
			<table class="table table-bordered table-striped align-middle">
				<thead>
					<tr>
						<th>#</th>
						<th>Student</th>
						<th>Course</th>
						<th>Year</th>
						<th>Date</th>
						<th>Status</th>
						<th>Late</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($rows as $i => $r): ?>
					<tr>
						<td><?php echo $i + 1; ?></td>
						<td><?php echo htmlspecialchars($r['username']); ?></td>
						<td><?php echo htmlspecialchars($r['course']); ?></td>
						<td><?php echo htmlspecialchars($r['year_level']); ?></td>
						<td><?php echo htmlspecialchars($r['date']); ?></td>
						<td><?php echo htmlspecialchars($r['status']); ?></td>
						<td><?php echo htmlspecialchars($r['late']); ?></td>
					</tr>
					<?php endforeach; ?>
					<?php if (empty($rows)): ?>
					<tr><td colspan="7" class="text-center text-muted">No records</td></tr>
					<?php endif; ?>
				</tbody>
			</table>
		</div>
	</div>
</body>
</html>
