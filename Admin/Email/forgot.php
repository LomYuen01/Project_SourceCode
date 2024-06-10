<?php include('../../config/constant.php'); ?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Forgot Password</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="../../Style/my-login.css">
	</head>

	<body class="my-login-page">
		<section class="h-100">
			<div class="container h-100">
				<div class="row justify-content-md-center align-items-center h-100">
					<div class="card-wrapper">
						<div class="brand">
							<img src="../../images/logo.png" alt="bootstrap 4 login page">
						</div>
						<div class="card fat">
							<div class="card-body">
								<h4 class="card-title">Forgot Password</h4>
								<form method="POST" action="send-password-reset.php" class="my-login-validation" novalidate="">
									<div class="form-group">
										<label for="email">Email Address</label>
										<input id="email" type="email" class="form-control" name="email" value="" required autofocus>
										<div class="invalid-feedback">
											Email is invalid
										</div>
										<div class="form-text text-muted">
											By clicking "Reset Password" we will send a password reset link
										</div>
									</div>

									<div class="form-group m-0">
										<button type="submit" class="btn btn-primary btn-block">
											Reset Password
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
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
		<script src="../../Style/my-login.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				const resetPasswordForm = document.querySelector('.my-login-validation');

				resetPasswordForm.addEventListener('submit', (event) => {
					event.preventDefault();

					// Send the form data to the server using AJAX
					const formData = new FormData(resetPasswordForm);

					fetch('send-password-reset.php', {
						method: 'POST',
						body: formData
					})
					.then(response => {
						if (!response.ok) {
							throw new Error(response.statusText);
						}
						return response.text();
					})
					.then(data => {
						if (data === 'Message sent, please check your inbox.') {
							Swal.fire('Success!', data, 'success');
						} else {
							Swal.fire('Error!', data, 'error');
						}
					})
					.catch(error => {
						Swal.fire('Error!', error.message, 'error');
					});
				});
			});
		</script>
	</body>
</html>