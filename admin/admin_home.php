<?php
require_once __DIR__ . '/../core/dbConfig.php';
require_once __DIR__ . '/../class/auth.php';
require_once __DIR__ . '/../class/admin.php';
Auth::requireRole('admin');
$admin = new Admin();
$courses = $admin->listCourses();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./style.css" rel="stylesheet">
	<title>Admin Dashboard</title>
</head>
<body>
	<?php $title = 'Admin'; require __DIR__ . '/../partials/navbar.php'; ?>
	<div class="container py-4">
		<div class="row g-4 justify-content-center">
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Add Course/Program</h5>
						<form method="post" action="/core/handleForms.php">
							<div class="input-group">
								<input class="form-control" name="course_name" placeholder="e.g. BSIT" required>
								<button class="btn btn-primary" type="submit" name="addCourseBtn" value="1">Add</button>
							</div>
						</form>
						<hr>
						<h5 class="card-title">Edit Courses</h5>
						<?php if (!empty($courses)): ?>
							<div class="table-responsive">
								<table class="table align-middle">
									<thead>
										<tr>
											<th>ID</th>
											<th>Course Name</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<?php foreach ($courses as $c): ?>
										<tr>
											<td><?php echo (int)$c['id']; ?></td>
											<td>
												<input class="form-control" name="course_name" value="<?php echo htmlspecialchars($c['course_name']); ?>" required form="course-form-<?php echo (int)$c['id']; ?>">
											</td>
											<td>
												<form id="course-form-<?php echo (int)$c['id']; ?>" class="d-flex gap-2" method="post" action="/core/handleForms.php">
													<input type="hidden" name="course_id" value="<?php echo (int)$c['id']; ?>">
													<button class="btn btn-primary btn-sm" type="submit" name="updateCourseBtn" value="1">Save</button>
												</form>
											</td>
										</tr>
										<?php endforeach; ?>
									</tbody>
								</table>
							</div>
						<?php else: ?>
							<p class="text-muted">No courses yet.</p>
						<?php endif; ?>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-body">
						<h5 class="card-title">Attendance by Course & Year</h5>
						<form class="row g-2" method="get" action="/admin/attendance_history.php">
							<div class="col-7">
								<select class="form-select" name="course" required>
									<option value="">-- Select Course --</option>
									<?php foreach ($courses as $c): ?>
									<option value="<?php echo htmlspecialchars($c['course_name']); ?>"><?php echo htmlspecialchars($c['course_name']); ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="col-3">
								<input type="number" class="form-control" name="year" min="1" max="6" placeholder="Year" required>
							</div>
							<div class="col-2">
								<button class="btn btn-secondary w-100" type="submit">View</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
