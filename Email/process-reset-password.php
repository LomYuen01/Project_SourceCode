<?php

    if (!isset($_POST["token"], $_POST["password"], $_POST["password_confirmation"])) {
        die("Missing POST data");
    }

    $token = $_POST["token"];


    $token_hash = hash("sha256", $token);

    $mysqli = require __DIR__ . "/../config/db_connection.php";

    $sql = "SELECT * FROM tbl_customer WHERE reset_token_hash = ?";
    
    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Failed to prepare statement: " . $mysqli->error);
    }

    $stmt->bind_param("s", $token_hash);

    if ($stmt->execute() === false) {
        die("Failed to execute statement: " . $stmt->error);
    }

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("token not found");
    }

    if (strtotime($user["reset_token_expires_at"]) <= time()) {
        die("token has expired");
    }

    if (strlen($_POST["password"]) < 8) {
        die("Password must be at least 8 characters");
    }

    if ($_POST["password"] !== $_POST["password_confirmation"]) {
        die("Passwords must match");
    }

    $password = $_POST["password"];

    $sql = "UPDATE tbl_customer SET password = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";

    $stmt = $mysqli->prepare($sql);

    if ($stmt === false) {
        die("Failed to prepare statement: " . $mysqli->error);
    }

    $stmt->bind_param("ss", $password, $user["id"]);

    if ($stmt->execute() === false) {
        die("Failed to execute statement: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        die("Failed to update password");
    }

    echo "Password updated. You can now login.";
?>