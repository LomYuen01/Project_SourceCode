<?php
    // Include constants.php for SITEURL
    include('../config/constant.php');

    if (!isset($_POST["admin_id"], $_POST["current_password"], $_POST["new_password"], $_POST["password_confirmation"])) {
        die("Missing POST data");
    }

    $admin_id = $_POST["admin_id"];
    $current_password = $_POST["current_password"];
    $new_password = $_POST["new_password"];
    $password_confirmation = $_POST["password_confirmation"];

    // Fetch the current password from the database
    $sql = "SELECT password FROM tbl_admin WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("i", $admin_id);

    $stmt->execute();

    $result = $stmt->get_result();

    $user = $result->fetch_assoc();

    if ($user === null) {
        die("User not found");
    }

    // Check if the current password matches the one in the database
    if ($user['password'] !== $current_password) {
        die("Current password is incorrect");
    }

    // Check if the new password and password confirmation match
    if ($new_password !== $password_confirmation) {
        die("Passwords must match");
    }

    // Update the password in the database
    $sql = "UPDATE tbl_admin SET password = ? WHERE id = ?";

    $stmt = $conn->prepare($sql);

    $stmt->bind_param("si", $new_password, $admin_id);

    if ($stmt->execute() === false) {
        die("Failed to execute statement: " . $stmt->error);
    }

    if ($stmt->affected_rows === 0) {
        die("Failed to update password");
    }

    echo "Password updated successfully!";
?>