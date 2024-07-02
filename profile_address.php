<?php include('partials-front/menu.php'); 
$user_id = isset($_SESSION['user']['user_id']) ? $_SESSION['user']['user_id'] : "";
if (isset($_POST['submit'])) {
        $name = $_POST['name'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $state = $_POST['state'];
        $country = "Malaysia";
        $postal_code = $_POST['zip'];
        $phone = $_POST['phone'];

            $allowed_zip_codes = ['75100', '75200', '75250', '75300'];
    if (!in_array($postal_code, $allowed_zip_codes)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid postal code.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '".$redirect_url."';
                }
            });
        </script>";
    } else {

        
        $sql = "SELECT * FROM tbl_customer_address WHERE name='$name' AND address='$address' AND city='$city' AND state='$state' AND country='$country' AND postal_code='$postal_code' AND customer_id='$user_id'AND phone='$phone'";
        
        $result = $conn->query($sql);
        
        
        if ($result->num_rows > 0) {
            echo "<script>alert('The address already exists.');</script>";
        } else {
            $sql = "INSERT INTO tbl_customer_address (name, address, city, state, country, postal_code, customer_id, phone) VALUES ('$name', '$address', '$city', '$state', '$country', '$postal_code', '$user_id', '$phone')";
            if ($conn->query($sql) === TRUE) {
                echo "<script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'New address inserted successfully.',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = window.location.href;
                        }
                    });
                </script>";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
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

if (isset($_POST['update'])) {
    $edit_id = $_POST['edit_id'];
    $edit_name = $_POST['edit_name'];
    $edit_address = $_POST['edit_address'];
    $edit_city = $_POST['edit_city'];
    $edit_state = $_POST['edit_state'];
    $edit_country = $_POST['edit_country'];
    $edit_zip = $_POST['edit_zip'];

                $allowed_zip_codes = ['75100', '75200', '75250', '75300'];
    if (!in_array($postal_code, $allowed_zip_codes)) {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid postal code.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '".$redirect_url."';
                }
            });
        </script>";
    } else {

    $sql = "UPDATE tbl_customer_address SET 
        name='$edit_name', 
        address='$edit_address', 
        city='$edit_city', 
        state='$edit_state', 
        country='$edit_country', 
        postal_code='$edit_zip' 
        WHERE id='$edit_id' AND customer_id='$user_id'";

    if ($conn->query($sql) === TRUE) {
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Address updated successfully.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = window.location.href;
                }
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to update address. Try again later.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = window.location.href;
                }
            });
        </script>";
    }
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

    .modal {
        display: none; /* Hidden by default */
        position: fixed; /* Stay in place */
        z-index: 1; /* Sit on top */
        left: 0;
        top: 0;
        width: 100%; /* Full width */
        height: 100%; /* Full height */
        overflow: auto; /* Enable scroll if needed */
        background-color: rgb(0,0,0); /* Fallback color */
        background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        padding-top: 60px;
    }

    .modal-content {
        background-color: #fefefe;
        margin: 5% auto; /* 15% from the top and centered */
        padding: 20px;
        border: 1px solid #888;
        width: 80%; /* Could be more or less, depending on screen size */
    }

    .close {
        color: #aaa;
        float: right;
        font-size: 28px;
        font-weight: bold;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }

    .input-box {
        margin: 10px 0;
    }

    .input-box input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 10px 0;
        border: none;
        border-radius: 4px;
        background-color: #5cb85c;
        color: white;
        cursor: pointer;
    }

    .btn:hover {
        background-color: #4cae4c;
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
                        <a href="Email/forgot.php" class="forgot-password">Forgot password?</a>
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
            <div style="border: 1px solid black; width: 20%; font-size: 1rem;  background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243));">
                <h1>Profile</h1>
                    <?php
                        
                        $sql = "SELECT * FROM tbl_customer WHERE id=$user_id";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                        if($count==1){
                            $row = mysqli_fetch_assoc($res);
                            $full_name = $row['full_name'];
                            $username = $row['username'];
                            $current_image = $row['image_name'];
                        }
                    ?>
                <div style="padding:10%;">
                    <div class="profile-img" style="display: flex; justify-content: center; align-items: center; width: 100%; ;">
                        <?php
                            if($current_image != "") {
                                // If $current_image is not empty, display the image
                                
                                echo "<img src='".SITEURL."images/Profile/".$current_image."' id='profileImage' style='border-width: 2.5px; width: 100% !important; height:auto !important; object-fit: contain;'>";
                            }
                            else {
                                // If $current_image is empty, display the default image
                                echo "<img src='images/no_profile_pic.png' id='profileImage' style='border-width: 2.5px; width: 100% !important; height:auto !important; object-fit: contain;'>";
                            }
                        ?>
                    </div>

                    <div class="user-info" style="text-align: center; font-size: 1rem;margin:auto;">
                        <?php echo $username; ?>
                    </div>
                </div>
                <div class="profile-menu" style="height: auto;">
                    <ul style="font-size: 1rem !important;">
                        <li style="height: 80px;">
                            <a href="edit-profile.php?id=<?php echo $_SESSION['user']['user_id']; ?>">Edit Profile</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="change-password.php">Change Password</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="profile_order.php">Order History</a>
                        </li>
                        <li style="height: 80px;">
                            <a href="profile_address.php">Address</a>
                        </li>
                    </ul>
                </div>
            </div>
            

            <div style="border: 1px solid black; font-size: 1rem; width:80%;margin-left:2%;  background: #8e9eab;  background: -webkit-linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243)); background: linear-gradient(to bottom, rgb(239, 248, 245), rgb(238, 242, 243));">
                <div style="padding-bottom:10px;"><h1>Address</h1></div>
                <div>
                    <div><h2>Add Address</h2></div>
                    <div style="width: 80%; margin-left: auto; margin-right: auto; border: 1px solid black;border-radius: 18px;">
                        <form action="" method="post" style=" border: 1px solid black;border-radius: 18px;">
                            <div class="stable_position" style="margin-left: auto; margin-right: auto; display: flex; flex-direction: row; flex-wrap: wrap; border: 1px solid black;border-radius: 18px;">
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="name" placeholder="Enter your name" required style="border-radius: 11px; height: 50px">
                                    <i class="fa-solid fa-user user" style="position: absolute; left: -20px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="address" placeholder="Enter your address" required style="border-radius: 11px;height: 50px">
                                    <i class="fa-solid fa-map-marker address" style="position: absolute; left: -20px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="city" placeholder="Enter your city" required style="border-radius: 11px;height: 50px">
                                    <i class="fa-solid fa-city city" style="position: absolute; left: -20px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="state" value="Melaka" readonl style="border-radius: 11px;height: 50px">
                                    <i class="fa-solid fa-map-marker state" style="position: absolute; left: -20px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="zip" placeholder="Enter your postcode 75100|75200|75250|75300" required pattern="75100|75200|75250|75300" style="border-radius: 11px;height: 50px">
                                    <i class="fa-solid fa-map-marker zip" style="position: absolute; left: -20px;"></i>
                                </div>
                                <div class="input-box" style="width: 45%; margin: 2.5%;">
                                    <input type="text" name="phone" id="phone" placeholder="Enter your phone" required style="border-radius: 11px;height: 50px">
                                    <i class="fa-solid fa-phone phone" style="position: absolute; left: -20px;"></i>
                                </div>

                                <div style="display: block; margin: auto;  box-sizing: border-box; "><input type="submit" name="submit" value="Submit"></div>
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="address_info" style="padding-bottom: 10%;">
                    <div style="margin-top: 3%;">
                        <h2>Address List</h2>
                    </div>
                    
                    <?php
                        $sql = "SELECT * FROM tbl_customer_address WHERE customer_id=$user_id";
                        $res = mysqli_query($conn, $sql);
                        $count = mysqli_num_rows($res);
                    ?>
                    <div style="margin-left: auto; margin-right: auto; width: 80%; margin-top:50px;">
                        <table class="table" style="color: black !important;">
                        <thead>
                            <tr>
                                <th style="width: 12.5%;">Name</th>
                                <th style="width: 12.5%;">Address</th>
                                <th style="width: 12.5%;">City</th>
                                <th style="width: 12.5%;">State</th>
                                
                                <th style="width: 12.5%;">Postal Code</th>
                                <th style="width: 12.5%;">Phone</th>
                                <th style="width: 12.5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = "SELECT * FROM tbl_customer_address WHERE customer_id = '$user_id'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    $id = $row['id'];
                                    $full_name = $row['name'];
                                    $address = $row['address'];
                                    $city = $row['city'];
                                    $state = $row['state'];

                                    $postal_code = $row['postal_code'];
                                    $phone = $row['phone'];
                                    ?>
                                    <tr style="box-shadow: -4px 0px 8px 1px rgba(0, 0, 0, 0.1); ">
                                        <td  style:"padding-left:35px"><?php echo $full_name; ?></td>
                                        <td><?php echo $address; ?></td>
                                        <td><?php echo $city; ?></td>
                                        <td><?php echo $state; ?></td>
                                        <td><?php echo $postal_code; ?>
                                        <td><?php echo $phone; ?>
                                    
                                    </td>
                                        <td class="button" style="border: 1px solid gray;">
                                            <div style="display: flex;">
                                                <button type="button" class="btn edit-btn" 
                                                    data-id="<?php echo $id; ?>" 
                                                    data-name="<?php echo $full_name; ?>" 
                                                    data-address="<?php echo $address; ?>" 
                                                    data-city="<?php echo $city; ?>" 
                                                    data-state="<?php echo $state; ?>" 
                                                   
                                                    data-zip="<?php echo $postal_code; ?>" 
                                                    data-phone="<?php echo $phone; ?>"
                                                    style="width: 50%; box-sizing: border-box; border: none; background-color: green">Edit</button>

                                                <form action="" method="post" style="width: 50%;">
                                                    <input type="hidden" name="id" value="<?php echo $id; ?>">
                                                    <input type="submit" name="delete" class="btn" style="width: 100%; box-sizing: border-box; background-color: red; border: none;" value="Delete">
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {
                                echo "<tr><td colspan='7'>No addresses found.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
        <div id="editAddressModal" class="modal">
    <div class="modal-content" style="border-radius: 18px;" >
        <span class="close">&times;</span>
        <h2>Edit Address</h2>
        <form id="editAddressForm" method="post">
            <input type="hidden" name="edit_id" id="edit_id">
            <div>
                <label for="edit_name">Name:</label>
                <div class="input-box">
                    <input type="text" name="edit_name" id="edit_name" placeholder="Enter your name" required>
                </div>
            </div>

            <div>
                <label for="edit_address">Address:</label>
                <div class="input-box">
                    <input type="text" name="edit_address" id="edit_address" placeholder="Enter your address" required>
                </div>
            </div>

            <div>
                <label for="edit_city">City:</label>
                <div class="input-box">
                    <input type="text" name="edit_city" id="edit_city" placeholder="Enter your city" required>
                </div>
            </div>

            <div>
                <label for="edit_state">State:</label>
                <div class="input-box">
                    <input type="text" name="edit_state" id="edit_state" value="Melaka" readonl style="border-radius: 11px;height: 50px">
                </div>
            
            </div>

            <div>
                <label for="edit_zip">Postal Code:</label>
                <div class="input-box">
                    <input type="text" name="edit_zip" id="edit_zip" placeholder="Enter your postcode 75100|75200|75250|75300" required pattern="75100|75200|75250|75300" style="border-radius: 11px;height: 50px">
                </div>
            </div>

            <div>
                <label for="edit_phone">Phone:</label>
                <div class="input-box">
                    <input type="text" name="edit_phone" id="edit_phone" placeholder="Enter your phone" required>
                <div>
            </div>


                <input type="submit" name="update" value="Update" class="btn">
            </div>
        </form>
    </div>
</div>
    </section>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Get the modal
    var modal = document.getElementById("editAddressModal");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // Get all edit buttons
    var editButtons = document.querySelectorAll(".edit-btn");

    // When the user clicks on the button, open the modal 
    editButtons.forEach(function(button) {
        button.addEventListener("click", function() {
            var id = this.getAttribute("data-id");
            var name = this.getAttribute("data-name");
            var address = this.getAttribute("data-address");
            var city = this.getAttribute("data-city");
            var state = this.getAttribute("data-state");

            var zip = this.getAttribute("data-zip");
            var phone = this.getAttribute("data-phone");

            document.getElementById("edit_id").value = id;
            document.getElementById("edit_name").value = name;
            document.getElementById("edit_address").value = address;
            document.getElementById("edit_city").value = city;
            document.getElementById("edit_state").value = state;
            document.getElementById("edit_zip").value = zip;
            document.getElementById("edit_phone").value = phone;

            modal.style.display = "block";
        });
    });

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = "none";
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
});

document.addEventListener('DOMContentLoaded', (event) => {
    const phoneInput = document.getElementById('phone');
    const validPrefixes = ['010', '011', '012', '013', '014', '016', '017', '018', '019'];

    phoneInput.addEventListener('input', function (e) {
        let value = phoneInput.value.replace(/\D/g, '');

        if (value.length > 3 && validPrefixes.includes(value.substring(0, 3))) {
            let formattedValue = value.match(/(\d{3})(\d{0,8})/);
            if (formattedValue) {
                phoneInput.value = formattedValue[1] + (formattedValue[2] ? '-' + formattedValue[2] : '');
            }
        } else {
            phoneInput.value = value.substring(0, 3);
        }
    });

    phoneInput.addEventListener('blur', function (e) {
        const value = phoneInput.value.replace(/\D/g, '');
        if (value.length < 10 || value.length > 11 || !validPrefixes.includes(value.substring(0, 3))) {
            Swal.fire({
                title: 'Error!',
                text: 'Invalid phone number. Please enter a valid phone number.',
                icon: 'error',
                confirmButtonText: 'Cool'
            });
            phoneInput.value = '';
        }
    });
});

document.addEventListener('DOMContentLoaded', (event) => {
    const phoneInput = document.getElementById('edit_phone');
    const validPrefixes = ['010', '011', '012', '013', '014', '016', '017', '018', '019'];

    phoneInput.addEventListener('input', function (e) {
        let value = phoneInput.value.replace(/\D/g, '');

        if (value.length > 3 && validPrefixes.includes(value.substring(0, 3))) {
            let formattedValue = value.match(/(\d{3})(\d{0,8})/);
            if (formattedValue) {
                phoneInput.value = formattedValue[1] + (formattedValue[2] ? '-' + formattedValue[2] : '');
            }
        } else {
            phoneInput.value = value.substring(0, 3);
        }
    });

    phoneInput.addEventListener('blur', function (e) {
        const value = phoneInput.value.replace(/\D/g, '');
        if (value.length < 10 || value.length > 11 || !validPrefixes.includes(value.substring(0, 3))) {
            Swal.fire({
                title: 'Error!',
                text: 'Invalid phone number. Please enter a valid phone number.',
                icon: 'error',
                confirmButtonText: 'Cool'
            });
            phoneInput.value = '';
        }
    });
});

</script>

<?php include('partials-front/footer.php'); 
?>

