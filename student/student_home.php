<?php
require_once __DIR__ . '/../core/dbConfig.php';
require_once __DIR__ . '/../class/auth.php';
Auth::requireRole('student');
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="/style.css" rel="stylesheet">
	<title>Student Dashboard</title>
</head>
<body>
	<?php $title = 'Student'; require __DIR__ . '/../partials/navbar.php'; ?>
	<div class="container py-4">
		<div class="row g-4 justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Mark Attendance</h5>
						<form method="post" action="/core/handleForms.php" class="d-flex gap-2">
							<select class="form-select" name="status">
								<option value="Present">Present</option>
								<option value="Absent">Absent</option>
							</select>
							<button class="btn btn-primary" type="submit" name="markAttendanceBtn" value="1">Submit</button>
						</form>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">History</h5>
						<a class="btn btn-secondary" href="/student/attendance_history.php">View Attendance History</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
