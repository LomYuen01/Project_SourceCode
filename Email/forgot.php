<?php include('../config/constant.php'); 

$error_message = '';

if (isset($_POST['submit'])) {

    $fullname = $_POST['fullname'];
    $ph_no = $_POST['phone'];
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format.';
    } else {
        // Check if the password and confirm password match
        if ($password !== $confirm_password) {
            $error_message = 'Passwords do not match.';
        } else {
            // Check if email already exists in the database
            $sql = "SELECT * FROM tbl_customer WHERE email = ?";
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $email);
                $stmt->execute();

                // Get the result
                $result = $stmt->get_result();

                // Check if a row was returned
                if ($result->num_rows > 0) {
                    // Email already exists
                    $error_message = 'Email already exists.';
                } else {
                    // Check if phone number already exists in the database
                    $sql = "SELECT * FROM tbl_customer WHERE ph_no = ?";
                    if ($stmt = $conn->prepare($sql)) {
                        $stmt->bind_param("s", $ph_no);
                        $stmt->execute();

                        // Get the result
                        $result = $stmt->get_result();

                        // Check if a row was returned
                        if ($result->num_rows > 0) {
                            // Phone number already exists
                            $error_message = 'Phone number already exists.';
                        } else {
                            // Email and phone number do not exist, insert the new user
                            $sql = "INSERT INTO tbl_customer (full_name, ph_no, username, email, password) VALUES (?, ?, ?, ?, ?)";
                            if ($stmt = $conn->prepare($sql)) {
                                $stmt->bind_param("sssss", $fullname, $ph_no, $username, $email, $password);
                                if ($stmt->execute()) {
                                    // User registered successfully
                                    header('Location: login.php');
                                } else {
                                    echo "Error executing statement.";
                                }
                            } else {
                                echo "Error preparing statement.";
                            }
                        }
                    } else {
                        echo "Error preparing statement.";
                    }
                }
            } else {
                echo "Error preparing statement.";
            }
        }
    }
    
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

<!-- Home -->
<section class="home" style="background: #E0E1E4;">


    <!--====== Content ======-->
   <div class="container">
        <div style="position: relative; background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); display: flex; padding: 40px; border-radius: 11px;">
            <div class="left-side">
                <h2>Forgot Password
                </h2>
                <p>Please enter information in details below</p>
                <br>
                <form action="send-password-reset.php" method="POST" class="my-login-validation" novalidate="">
                    <div class="input-box">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>

                    <div>
                        <?php if (!empty($error_message)) : ?>
                        <p style="color: red;"><?php echo $error_message; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="form-text text-muted">
                        By clicking "Reset Password" we will send a password reset link
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