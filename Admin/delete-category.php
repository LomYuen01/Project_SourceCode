<?php
    include('../config/constant.php');

    if(isset($_GET['id']))
    {
        $id = $_GET['id'];

        $sql_variation = "DELETE FROM tbl_store_variation WHERE category_id=$id";

        $res_variation = mysqli_query($conn, $sql_variation);

        $sql_category = "DELETE FROM tbl_category WHERE id=$id";

        $res_category = mysqli_query($conn, $sql_category);

        // Check whether the queries executed successfully or not
        if($res_variation==true && $res_category==true)
        {
            echo 'success';
        }
        else
        {
            echo 'failed';
        }
    }
    else
    {
        echo 'failed';
    }
?>