<?php
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
        echo "Selected category ID: " . $category_id;
    }
?>