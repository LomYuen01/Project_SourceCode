<?php
function createDbConnection() {
    $servername = "localhost";
    $username = "username";
    $password = "password";
    $dbname = "renos_kitchen";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>