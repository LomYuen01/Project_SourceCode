<?php include('partials-front/menu.php'); 

if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = $_POST['country'];
        $postal_code = $_POST['zip'];
        $user_id = 1;

        
        $sql = "SELECT * FROM tbl_customer_address WHERE name='$name' AND address='$address' AND city='$city' AND state='$state' AND country='$country' AND postal_code='$postal_code' AND customer_id='$user_id'";
        
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            echo "<script>alert('The address already exists.');</script>";
        } else {
            $sql = "INSERT INTO tbl_customer_address (name, address, city, state, country, postal_code, customer_id) VALUES ('$name', '$address', '$city', '$state', '$country', '$postal_code', '$user_id')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('New address inserted successfully.');</script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }
    }

if (isset($_POST['delete'])){
    
    $id = $_POST['id'];
    $sql = "DELETE FROM tbl_order WHERE address_id=$id";
    if ($conn->query($sql) === TRUE) {
        $sql = "DELETE FROM tbl_customer_address WHERE id=$id";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Record deleted successfully');</script>";
        } else {
            echo "Error deleting record: " . $conn->error;
        }
    } else {
        echo "Error deleting related orders: " . $conn->error;
    }
}
?>

?>
<style>
    .address_info {
        width: 100%;
    }
    .user_name {
        width: 20%;
    }
    
</style>

    <!-- Home -->
    <section class="home">
        <!--====== Forms ======-->
        <div class="form-container">
            <i class="fa-solid fa-xmark form-close"></i>

            <!-- Login Form -->
            <div class="form login-form">
                <form action="#">
                    <h2>Login</h2>

                    <div class="input-box">
                        <input type="email" placeholder="Enter your email" required>
                        <i class="fa-solid fa-envelope email"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Enter your password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>

                    <div class="option-field">
                        <span class="checkbox">
                            <input type="checkbox" id="check">
                            <label for="check">Remember me</label>
                        </span>
                        <a href="#" class="forgot-password">Forgot password?</a>
                    </div>

                    <button class="btn">Login Now</button>

                    <div class="login-singup">
                        Don't have an account? <a href="#" id="signup">Sign up</a>
                    </div>
                </form>
            </div>

            <!-- Sign up Form -->
            <div class="form signup-form">
                <form action="#">
                    <h2>Sign up</h2>

                    <div class="input-box">
                        <input type="email" placeholder="Enter your email" required>
                        <i class="fa-solid fa-envelope email"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Create password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>

                    <div class="input-box">
                        <input type="password" placeholder="Confirm password" required>
                        <i class="fa-solid fa-lock password"></i>
                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                    </div>
                    
                    <button class="btn">Sign Up Now</button>

                    <div class="login-singup">
                        Already have an account? <a href="#" id="login">Login</a>
                    </div>
                </form>
            </div>
        </div>
        <!--====== Forms ======-->

        <!--===== Content =====-->

        <div style="width: 90%; margin: auto; margin-top: 5%; margin-left:2%; display:inline-flex;">
            <div style="border: 1px solid black; width: 20%; font-size: 1rem;">
                <h1>Profile</h1>
                <div style="border: 1px solid black;">
                    <div class="profile-img" style="display: flex; justify-content: center; align-items: center; width: 100%; ;">
                        <img src="images/user.png" alt="User Image" class="img-responsive img-curve" style="width: 100%; height: auto; object-fit: cover;">
                    </div>
                    <?php
                        $user_id = 1;
                        $sql = "SELECT * FROM tbl_customer WHERE id=$user_id";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        if($count==1){
                            $row = mysqli_fetch_assoc($res);
                            $full_name = $row['full_name'];
                            $username = $row['username'];
                        }
                    ?>
                    <div class="user-info style:">
                        <?php echo $username; ?>
                    </div>
                </div>
                <div class="profile-menu">
                    <ul>
                        <li>
                            <a href="profile_edit.php">Edit Profile</a>
                        </li>
                        <li>
                            <a href="profile_password.php">Change Password</a>
                        </li>
                        <li>
                            <a href="profile_order.php">Order History</a>
                        </li>
                        <li>
                            <a href="profile_address.php">Address</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div style="border: 1px solid black; font-size: 1rem; width:80%;margin-left:2%; ">
                <div style="border: 1px solid gray;"><h1>Address</h1></div>
                <div>
                    <div><h2>Add Address</h2></div>
                    <div style="width: 80%; margin-left: auto; margin-right: auto; border: 1px solid black;border-radius: 18px;">
                        <form action="" method="post" style=" border: 1px solid black;border-radius: 18px;">
                            <div class="stable_position" style="margin-left: auto; margin-right: auto; display: flex; flex-direction: row; flex-wrap: wrap; border: 1px solid black;border-radius: 18px;">
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="name" placeholder="Enter your name" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-user user" style="position: absolute; left: 8px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="address" placeholder="Enter your address" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-map-marker address" style="position: absolute; left: 8px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="city" placeholder="Enter your city" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-city city" style="position: absolute; left: 4px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="state" placeholder="Enter your state" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-map-marker state" style="position: absolute; left: 8px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="country" placeholder="Enter your country" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-globe country" style="position: absolute; left: 8px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="zip" placeholder="Enter your zip code" required style="border-radius: 11px;">
                                    <i class="fa-solid fa-map-marker zip" style="position: absolute; left: 8px;"></i>
                                </div>
                                <div style="display: block; margin: auto;"><input type="submit" name="submit" value="Submit"></div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="address_info">
                    <div style="margin-top: 3%;">
                        <h2>Address List</h2>
                    </div>
                    <?php
                        $sql = "SELECT * FROM tbl_customer_address WHERE customer_id=$user_id";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                    ?>
                    <table class="address_info" style="width: 80%; margin:auto; margin-top:2%; padding-bottom:3%">
                                    <tr>
                                        <th class="name" style="border: 1px solid gray;">Name</th>
                                        <th class="address" style="border: 1px solid gray;">Address</th>
                
                                        <th class="button" style="border: 1px solid gray;">Action</th>
                                    </tr>
                        <?php
                        if($count>0){
                            while($row = mysqli_fetch_assoc($res)){
                                
                                $id = $row['id'];
                                $full_name = $row['name'];
                                $address = $row['address'];
                                $postal_code = $row['postal_code'];
                                $city = $row['city'];
                                $state = $row['state'];
                                $country = $row['country'];
                                
                                ?>
                                
                                
                                    <tr>
                                        <td class="name" style="border: 1px solid gray;">
                                            <?php echo $full_name; ?>
                                        </td>
                                        <td class="address_full" style="border: 1px solid gray;">
                                            <?php echo $address . ', ' . $postal_code . ', ' . $city . ', ' . $state . ', ' . $country; ?>
                                        </td>
                                        <td class="button" style="border: 1px solid gray;">
                                            <div style="display: flex;">
                                                <a href="edit.php?id=<?php echo $id; ?>" class="btn" style=" width: 50%; box-sizing: border-box; background-color: green">Edit</a>
                                                
                                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                    <form action="" method="post">
                                                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                        <input type="submit" name="delete" class="btn" style="width: 100%; box-sizing: border-box;background-color: red" value="Delete">
                                                    </form>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                
                                <?php
                            }
                        }
                    ?>
                    </table>
            </div>
        </div>
        
    </section>
<script>


</script>

<?php include('partials-front/footer.php'); ?>