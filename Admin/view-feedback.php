<?php
    ob_start(); 
    include('../config/constant.php'); 
    include('Partials/login-check.php');

    // Get the ID from URL
    $id = $_GET['id'];

    // Create SQL Query to Get the Feedback
    $sql = "SELECT * FROM tbl_contact_us WHERE id=$id";

    // Execute the Query
    $res = mysqli_query($conn, $sql);

    // Check whether the Query is Executed or not
    if($res==true)
    {
        // Check whether the data is available or not
        $count = mysqli_num_rows($res);

        // Check whether we have feedback data or not
        if($count==1)
        {
            // We Have Data in Database
            $row=mysqli_fetch_assoc($res);

            $name = $row['name'];
            $email = $row['email'];
            $status = $row['status'];
            $message = $row['message'];
            $submitted_at = $row['submitted_at'];
        }
        else
        {
            // Redirect to Manage Feedback Page
            header('location:'.SITEURL.'admin/manage-feedback.php');
        }
    }
?>

<!DOCTYPE html>
    <head>
        <!-----===============| CSS |===============----->
        <link rel="stylesheet" href="../Style/style-delivery.css">
    </head>

    <body>
        <section class="home" style="position: relative; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <form action="#" method="POST" class="order-container">
                <div>
                    <a href="javascript:history.back()"><img src="Icon/Back_Icon.png" class="icon" title="Back"></a>
                    <h1>User's Feedbacks</h1>
                    <div class="order-details">
                        <p><span class="details">Name:</span> <?php echo $name; ?></p>
                        <p><span class="details">Email:</span> <?php echo $email; ?></p>
                        <p><span class="details">Submitted Time:</span> <?php echo $submitted_at; ?></p>
                        <p><span class="details">Message:</span> <?php echo $message; ?></p>
                    </div>

                    <div class="dropdown2">
                        <div class="status" style="margin: 0; margin-top: 8px;">
                            <span class="details">Status</span>
                            <select name="status" style="font-size: 14px; font-weight: 500;">
                                <option value="Yes" <?php echo ($status == 'Yes') ? 'selected' : ''; ?>>Read</option>
                                <option value="No" <?php echo ($status == 'No') ? 'selected' : ''; ?>>Unread</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="button" style="left: 0;">
                    <input type="submit" name="submit" value="Update" class="btn-secondary" style="width: 85%; font-size: 14px;">
                </div>
            </form>
        </section>
    </body>
</html>

<?php
    if(isset($_POST['submit']))
    {
        // Get the data from Form
        $status = mysqli_real_escape_string($conn, $_POST['status']);

        // SQL Query to update the feedback status in tbl_contact_us
        $sql_feedback = "UPDATE tbl_contact_us SET
            status = '$status'
            WHERE id = $id
        ";

        // Executing Query and Updating Data in tbl_contact_us
        $res_feedback = mysqli_query($conn, $sql_feedback) or die(mysqli_error());

        // Check whether the (Query is executed) data is updated or not
        if($res_feedback==TRUE)
        {
            // Data Updated
            header("location:".SITEURL.'admin/index.php');
        }
    }
?>