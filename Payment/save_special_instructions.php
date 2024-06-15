<?php 
    include('../config/constant.php'); 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $special_instructions = isset($_POST['special_instructions']) ? $_POST['special_instructions'] : null;
    $_SESSION['special_instructions'] = $special_instructions;

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>