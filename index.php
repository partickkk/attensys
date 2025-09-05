<?php
require_once __DIR__ . '/core/dbConfig.php';
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="./style.css" rel="stylesheet">
	<title>Login</title>
</head>
<body class="bg-light">
	<div class="center-screen">
		<div class="container">
			<div class="row justify-content-center align-items-center">
				<div class="col-md-4">
					<div class="card shadow-sm">
						<div class="card-body">
							<h4 class="mb-3">Login</h4>
							<?php if (isset($_GET['error'])): ?>
							<div class="alert alert-danger">Invalid credentials</div>
							<?php endif; ?>
							<form method="post" action="core/handleForms.php">
								<div class="mb-3">
									<label class="form-label">Username</label>
									<input class="form-control" name="username" required>
								</div>
								<div class="mb-3">
									<label class="form-label">Password</label>
									<input type="password" class="form-control" name="password" required>
								</div>
								<button class="btn btn-primary w-100" type="submit" name="loginBtn" value="1">Login</button>
							</form>
							<div class="text-center mt-3">
								<a href="register.php" class="btn btn-link">Create an account</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</body>
</html>
