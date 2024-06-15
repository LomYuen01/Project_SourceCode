<?php
    // Include constants.php for SITEURL
    include('../config/constant.php');
    
    $admin_id = $_SESSION['admin']['admin_id'];

    $sql = "SELECT * FROM tbl_admin WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $admin_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("User not found");
    }
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Change Password</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="../Style/my-login.css">
	</head>

	<body class="my-login-page">
		<section class="h-100">
			<div class="container h-100">
				<div class="row justify-content-md-center align-items-center h-100">
					<div class="card-wrapper">
						<div class="brand">
							<img src="../images/logo.png" alt="bootstrap 4 login page">
						</div>
						<div class="card fat">
							<div class="card-body">
								<h4 class="card-title">Change Password</h4>
								<form method="POST" action="process-change-password.php" class="my-login-validation" novalidate="">
									<input type="hidden" name="admin_id" value="<?= htmlspecialchars($admin_id) ?>">
									<div class="form-group">
										Current Password
										<input id="current_password" type="password" class="form-control" name="current_password" required data-eye>
										<div class="invalid-feedback">
											Current password is required
										</div>
									</div>
									<div class="form-group">
										New Password
										<input id="new_password" type="password" class="form-control" name="new_password" required data-eye>
										<div class="invalid-feedback">
											New password is required
										</div>
									</div>

									<div class="form-group">
										Confirm Password
										<input id="confirm_password" type="password" class="form-control" id="password_confirmation" name="password_confirmation" required data-eye>
										<div class="invalid-feedback">
											Confirm password is required
										</div>
									</div>

									<div class="form-group m-0">
										<button type="submit" class="btn btn-primary btn-block">
											Change Password
										</button>
									</div>
								</form>
							</div>
						</div>
						<div class="footer">
							Copyright &copy; 2024 &mdash; Reno Kitchen 
						</div>
					</div>
				</div>
			</div>
		</section>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="../Style/my-login.js"></script>
		<script>
			    document.addEventListener('DOMContentLoaded', () => {
				const changePasswordForm = document.querySelector('.my-login-validation');

				changePasswordForm.addEventListener('submit', (event) => {
					event.preventDefault();

					const currentPassword = document.querySelector('#current_password').value;
					const newPassword = document.querySelector('#new_password').value;
					const confirmPassword = document.querySelector('#confirm_password').value;

					if (newPassword.length < 8) {
						Swal.fire('Error!', 'New password must be at least 8 characters long.', 'error');
					} else if (!/[a-z]/i.test(newPassword)) {
						Swal.fire('Error!', 'New password must contain at least one letter.', 'error');
					} else if (!/[0-9]/.test(newPassword)) {
						Swal.fire('Error!', 'New password must contain at least one number.', 'error');
					} else if (newPassword !== confirmPassword) {
						Swal.fire('Error!', 'Passwords do not match.', 'error');
					} else {
						// Send the form data to the server using AJAX
						const formData = new FormData(changePasswordForm);

						fetch('Process/process-change-password.php', {
							method: 'POST',
							body: formData
						})
						.then(response => response.text())
						.then(data => {
							if (data.trim() === 'Password updated successfully!') {
								Swal.fire({
									title: 'Success!',
									text: data,
									icon: 'success',
									confirmButtonText: 'OK'
								}).then((result) => {
									if (result.isConfirmed) {
										// Redirect to the login page
										window.location.href = 'http://localhost/RenoKitchen/admin/index.php';
									}
								});
							} else {
								Swal.fire('Error!', data, 'error');
							}
						})
						.catch(error => {
							Swal.fire('Error!', 'An error occurred while processing your request.', 'error');
						});
					}
				});
			});
		</script>
	</body>
</html>