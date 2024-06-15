<?php
    $email = $_POST["email"];

    $token = bin2hex(random_bytes(16));

    $token_hash = hash("sha256", $token);

    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    $mysqli = require __DIR__ . "/../config/db_connection.php";

    // Retrieve the user's name from the database
    $sql = "SELECT username FROM tbl_customer WHERE email = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if($user !== null) {
        $username = $user['username'];
    } else {
        echo "No account found with this email address.";
        exit;
    }

    $sql = "UPDATE tbl_customer
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";

    $stmt = $mysqli->prepare($sql);

    $stmt->bind_param("sss", $token_hash, $expiry, $email);

    $stmt->execute();

    if ($mysqli->affected_rows) {
        $mail = require __DIR__ . "/mailer.php";

        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";
        $mail->isHTML(true);

        // HTML email body
        $mail->Body = <<<END
        
        <p>Hi $username,</p>

        <p>We received a request to reset your password for your account. Click the link below to reset your password:</p>

        <p><a href="http://localhost/RenoKitchen/Email/reset-password.php?token=$token">Reset Password</a></p>

        <p>For your security, this link will expire in 20 minutes. If you did not request a password reset, please ignore this email.</p>

        <p>Thank you,<br>The Reno Kitchen Team</p>
        END;

        try {
            $mail->send();
            echo "Message sent, please check your inbox.";
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    } else {
        echo "No account found with this email address.";
    }
?>