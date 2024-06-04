<?php
    include('../config/constant.php'); 
    
    // Get the category id from the GET parameters
    $categoryId = $_GET['category_id'];

    // Fetch the variations for the selected category
    $sql = "SELECT sv.name FROM tbl_store_variation sv WHERE sv.category_id = $categoryId";
    $res = mysqli_query($conn, $sql);

    $variations = array();
    while ($row = mysqli_fetch_assoc($res)) {
        $variations[] = $row['name'];
    }

    // Return the variations as a JSON response
    echo json_encode($variations);
?>