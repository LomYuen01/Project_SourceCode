<?php
    $token = $_GET["token"];

    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/../config/db_connection.php";

    $sql = "SELECT * FROM tbl_customer
            WHERE reset_token_hash = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("s", $token_hash);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("token has expired");
    }
?>

<style>
    .container {
        position: relative;
        display: flex;
        justify-content: center;
        align-items: center;
        margin: auto;
        padding: 10px; 
        width: 100%;
        height: 100vh;
        background: -webkit-linear-gradient(to bottom, rgb(201, 214, 255), rgb(226, 226, 226)); 
        background: linear-gradient(to bottom, rgb(201, 214, 255), rgb(226, 226, 226));
    }

    .logo {
        width: 50px;
    }

    .topside {
        
        align-items: center;
        gap: 10px;
    }

    .left-side {
        flex: 1;
        padding: 25px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .form {
        display: flex;
        flex-direction: column;
    }

    .input-box {
        margin-top: 0;
        margin-bottom: 15px;
        position: relative;
    }

    .input-box input {
        width: 100%;
        padding: 15px;
        border: 1px solid #ddd;
        border-radius: 5px;
        font-size: 16px;
    }

    .fa-eye-slash {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        cursor: pointer;
    }

    .forgot-password {
        text-align: right;
        color: #555;
        text-decoration: none;
        margin-bottom: 20px;
    }

    .button {
        padding: 15px;
        border: none;
        border-radius: 5px;
        font-size: 16px;
        cursor: pointer;
        background-color: #4CAF50;
        color: #fff;
        margin-bottom: 10px;
    }

    .or-container {
        display: flex;
        align-items: center;
        margin: 20px 0;
    }

    .or-line {
        flex: 1;
        height: 1px;
        background: #ddd;
    }

    .or-text {
        margin: 0 10px;
        color: #777;
    }

    .google-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #fff;
        color: #555;
        border: 1px solid #ddd;
    }

    .google-btn img {
        width: 20px;
        margin-right: 10px;
    }

    .signup-text {
        text-align: center;
        color: #777;
    }

    .signup-text a {
        color: #4CAF50;
        text-decoration: none;
    }

    .image-container {
        margin-bottom: 20px;
    }

    .image-container img {
        width: 250px;
    }
</style>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
		<link rel="stylesheet" href="https://github.com/rixetbd/sweetalert/blob/main/index.html">
		<link rel="stylesheet" href="../../Style/my-login.css">
<!-- Home -->
<section class="home" style="background: #E0E1E4;">


    <!--====== Content ======-->
   <div class="container">
        <div style="position: relative; background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); display: flex; padding: 40px; border-radius: 11px;">
            <div class="left-side">
                <h2>
                    Reset Password
                </h2>
                
                <form method="POST" action="process-reset-password.php" class="my-login-validation" novalidate="">
                    <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
                    <?php echo $token; ?>
                    <div class="form-group">
                        <h4>New Password</h4>
                        <input id="password" type="password" class="form-control input-box" name="password" required data-eye>

                    </div>

                    <div class="form-group">
                        <h4>Confirm Password</h4>
                        <input id="confirm_password" type="password" class="form-control input-box" id="password_confirmation" name="password_confirmation" required data-eye>
                    </div>

                    <div class="form-group m-0">
                    <button type="submit" class="btn btn-primary btn-block">
                        Reset Password
                    </button>
                </div>
            </form>
            </div>
        </div>
    </div>
</section>

		<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script src="../../Style/my-login.js"></script>
		<script>
			document.addEventListener('DOMContentLoaded', () => {
				const resetPasswordForm = document.querySelector('.my-login-validation');

				resetPasswordForm.addEventListener('submit', (event) => {
					event.preventDefault();

					const password = document.querySelector('#password').value;
					const confirmPassword = document.querySelector('#confirm_password').value;

					if (password.length < 8) {
						Swal.fire('Error!', 'Password must be at least 8 characters long.', 'error');
					} else {
						// Send the form data to the server using AJAX
						const formData = new FormData(resetPasswordForm);

						fetch('process-reset-password.php', {
							method: 'POST',
							body: formData
						})
						.then(response => response.text())
						.then(data => {
							if (data === 'Password updated. You can now login.') {
								Swal.fire({
									title: 'Success!',
									text: data,
									icon: 'success',
									confirmButtonText: 'OK'
								}).then((result) => {
									if (result.isConfirmed) {
										// Redirect to the login page
										window.location.href = 'http://localhost/RenoKitchen/index.php';
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