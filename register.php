<?php
require_once __DIR__ . '/core/dbConfig.php';
require_once __DIR__ . '/class/admin.php';
$admin = new Admin();
$courses = [];
try {
	$courses = $admin->listCourses();
} catch (Throwable $e) {
	$courses = [];
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./style.css" rel="stylesheet">
	<title>Register</title>
</head>
<body class="bg-light">
	<div class="center-screen">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-md-6">
					<div class="card shadow-sm">
						<div class="card-body">
							<h4 class="mb-3">Register</h4>
							<form method="post" action="core/handleForms.php">
								<div class="mb-3">
									<label class="form-label">Username</label>
									<input class="form-control" name="username" required>
								</div>
								<div class="mb-3">
									<label class="form-label">Password</label>
									<input type="password" class="form-control" name="password" required>
								</div>
								<div class="mb-3">
									<label class="form-label">Role</label>
									<select class="form-select" name="role" id="roleSelect">
										<option value="student">Student</option>
										<option value="admin">Admin</option>
									</select>
								</div>
								<div class="mb-3 student-only">
									<label class="form-label">Course/Program</label>
									<select class="form-select" name="course" id="courseSelect">
										<option value="">-- Select --</option>
										<?php foreach ($courses as $c): ?>
										<option value="<?php echo htmlspecialchars($c['course_name']); ?>"><?php echo htmlspecialchars($c['course_name']); ?></option>
										<?php endforeach; ?>
									</select>
									<?php if (empty($courses)): ?>
									<small class="text-danger">No courses yet. Ask an admin to add one first.</small>
									<?php endif; ?>
								</div>
								<div class="mb-3 student-only">
									<label class="form-label">Year Level</label>
									<input type="number" class="form-control" name="year_level" min="1" max="6">
								</div>
								<div class="mt-3">
									<button class="btn btn-success w-100" type="submit" name="registerBtn" value="1">Create Account</button>
									<div class="mt-3 text-center">
										<a class="btn btn-link" href="index.php">Back to Login</a>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
		const roleSelect = document.getElementById('roleSelect');
		const courseSelect = document.getElementById('courseSelect');
		const studentOnly = document.querySelectorAll('.student-only');
		function toggleStudentFields() {
			const isStudent = roleSelect.value === 'student';
			studentOnly.forEach(el => el.style.display = isStudent ? 'block' : 'none');
			courseSelect.required = isStudent;
		}
		roleSelect.addEventListener('change', toggleStudentFields);
		toggleStudentFields();
	</script>
</body>
</html>
