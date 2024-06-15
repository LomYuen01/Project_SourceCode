<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width,initial-scale=1">
		<title>Driver Login Page</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="../../Style/my-login.css">
	</head>

	<body class="my-login-page">
		<section class="h-100">
			<div class="container h-100">
				<div class="row justify-content-md-center h-100">
					<div class="card-wrapper">
						<div class="brand">
							<img src="../../images/logo.png" alt="logo">
						</div>
						<div class="card fat">
							<div class="card-body">
								<h4 class="card-title">Driver Login</h4>
								<form method="POST" class="my-login-validation" novalidate="">
									<div class="form-group">
										<label for="email">Username</label>
										<input id="email" type="text" class="form-control" name="username" value="" required autofocus>
										<div class="invalid-feedback">
											Username is required
										</div>
									</div>

									<div class="form-group">
										Password
										<input id="password" type="password" class="form-control" name="password" required data-eye>
										<div class="invalid-feedback">
											Password is required
										</div>
									</div>

									<div class="form-group">
										<div class="custom-checkbox custom-control" style="display: flex; flex-direction: row; justify-content: space-between;">
											<input type="checkbox" name="remember" id="remember" class="custom-control-input">
											<label for="remember" class="custom-control-label">Remember Me</label>

											<label for="password">
												<a href="forgot.php" class="float-right">
													Forgot Password?
												</a>
											</label>
										</div>
									</div>
									<a href="http://localhost/RenoKitchen/delivery/signup.php" style="display: flex; justify-content: center; margin-top: -5px; margin-bottom: 25px;">Not a member? Register here</a>

									<div class="form-group m-0">
										<button type="submit" name="submit" class="btn btn-primary btn-block">
											Login
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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="../../Style/my-login.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				const loginForm = document.querySelector('.my-login-validation');

				loginForm.addEventListener('submit', (event) => {
					event.preventDefault();

					// Send the form data to the server using AJAX
					const formData = new FormData(loginForm);

					// Add the submit field manually
					formData.append('submit', 'Login');

					fetch('process-login.php', {
						method: 'POST',
						body: formData
					})
					.then(response => {
						if (!response.ok) {
							throw new Error(response.statusText);
						}
						return response.text();  // Change this line
					})
					.then(text => {
						console.log(text);  // Log the raw response text
						const data = JSON.parse(text);  // Parse the text as JSON

						if (data.success) {
							Swal.fire('Success!', data.message, 'success').then(() => {
								window.location.href = data.redirect;
							});
						} else {
							Swal.fire('Error!', data.message, 'error');
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