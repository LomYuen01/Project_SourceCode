<?php 
    include('Partials/menu.php'); 

    if (isset($_GET['id'])) 
    {
        $food_id = $_GET['id'];
        // Use $id to pre-fill the form for updating the food item
    }

    if (isset($_GET['category_id'])) 
    {
        $category_id = $_GET['category_id'];
        // Use $id to pre-fill the form for updating the food item
    }
?>
    <section class="home">
        <div class="title">
            <div class="text">Add Menu Item</div>

            <?php
                if(isset($_GET['id']))
                {
                    // Get the id of selected food
                    $id = $_GET['id'];

                    // Create the Sql Query to Get the details
                    $sql = "SELECT * FROM tbl_food WHERE id=$id";

                    // Execute the Query
                    $res = mysqli_query($conn, $sql);

                    if($res==TRUE)
                    {
                        // Check whether the data is available or not
                        $count = mysqli_num_rows($res);

                        if($count==1)
                        {
                            // Get the Details
                            $row = mysqli_fetch_assoc($res);

                            $title = $row['title'];
                            $description = $row['description'];
                            $normal_price = $row['normal_price'];
                            $large_price = $row['large_price'];
                            $quantity = $row['quantity'];
                            $current_image = $row['image_name'];
                            $category = $row['category_id'];
                            $active = $row['active'];
                        }
                        else
                        {
                            // Redirect to Manage Food Page with Session Message
                            $_SESSION['no-food-found'] = "<div class='error'> Food Not Found. </div>";

                            // Redirect to Manage Food Page
                            header('location:'.SITEURL.'admin/manage-food.php');
                        }
                    }
                }
                else
                {
                    // Redirect to Manage Food Page
                    header('location:'.SITEURL.'admin/manage-food.php');
                }
            ?>
        </div>

        <!-- Break --><br><!-- Line -->

        <div class="table" style="padding-left: 25px; padding-right: 5px; overflow: hidden;">
            <form id="update-food-form" action="" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: row; gap: 15px; width: 100%;">
                <section class="food-container" data-title="Menu Item Details">
                    <div class="food-details">
                        <div class="input-box">
                            <span class="details">Item Name</span><br>
                            <input type="text" name="title" placeholder=" Noodles" value="<?php echo $title; ?>" required>
                        </div>

                        <div class="input-box" style="margin-top: 10px;">
                            <?php
                                // Fetch prices from the database
                                $sql = "SELECT normal_price, large_price, quantity FROM tbl_food WHERE id = $food_id";
                                $res = mysqli_query($conn, $sql);

                                $normal_price = 0;
                                $large_price = 0;
                                if ($res == TRUE) {
                                    $row = mysqli_fetch_assoc($res);
                                    $normal_price = $row['normal_price'];
                                    $large_price = $row['large_price'];
                                }
                            ?>

                            <span class="details">Item Price</span><br>
                            <div class="price-box" style="margin-left: 5px;">
                                <input type="checkbox" class="checkbox-splash" name="normal_active" style="margin-top: 10px;" <?php echo $normal_price != 0 ? 'checked' : ''; ?>>
                                <div class="input-box" style="width: 92.5%;">
                                    <span class="details" style="font-size: 13px; font-weight: 500;">Regular Price</span><br>
                                    <input type="number" name="normal_price" placeholder=" Price" value="<?php echo $normal_price; ?>" style="margin-left: 0; background-color: #ECECEC; color: #B0B0B6; cursor: not-allowed;" min="0" step="0.01" required <?php echo $normal_price == 0 ? 'disabled' : ''; ?>>
                                </div>
                            </div>

                            <div class="price-box" style="margin-left: 5px;">
                                <input type="checkbox" class="checkbox-splash" name="large_active" style="margin-top: 10px;" <?php echo $large_price != 0 ? 'checked' : ''; ?>>
                                <div class="input-box" style="width: 92.5%;">
                                    <span class="details" style="font-size: 13px; font-weight: 500;">Large Price</span><br>
                                    <input type="number" name="large_price" placeholder=" Price" value="<?php echo $large_price; ?>" style="margin-left: 0; background-color: #ECECEC; color: #B0B0B6; cursor: not-allowed;" min="0" step="0.01" required <?php echo $large_price == 0 ? 'disabled' : ''; ?>>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-box">
                            <span class="details">Item Description</span><br>
                            <textarea type="text" name="description" placeholder=" Noodles is tasty" required><?php echo $description; ?></textarea>
                        </div>

                        <div class="input-box">
                            <span class="details">Item Quantity</span><br>
                            <input type="number" name="quantity" placeholder=" 100" value="<?php echo $quantity; ?>" min="0" step="0" required>
                        </div>

                        <div class="input-box" style="margin-top: 15px;">
                            <div class="style" style="display: flex; flex-direction: row;">
                                <div style="margin-left: 0px;">
                                    <span class="details">Select Category</span>
                                    <ul class="category-menu" style="list-style-type: none; margin-left: 10px;">
                                        <?php
                                            // Fetch the food item from the database
                                            $sql = "SELECT * FROM tbl_food WHERE id=$id";
                                            $res = mysqli_query($conn, $sql);
                                            $row = mysqli_fetch_assoc($res);
                                            $food_category_id = $row['category_id']; // Get the category_id of the food item

                                            // Fetch all categories from the database
                                            $sql = "SELECT * FROM tbl_category";
                                            $res = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $id = $row['id'];
                                                $title = $row['title'];
                                                $active = $row['active'];

                                                if ($active == 'Yes') {
                                                    echo "<li style='margin-top: 5px;'>";
                                                    // Check if the category id matches the food's category id
                                                    if ($id == $food_category_id) {
                                                        echo "<input type=\"radio\" name=\"category_id\" value=\"$id\" onclick=\"setCategoryId($id)\" checked>&nbsp;&nbsp;$title"; 
                                                    } else {
                                                        echo "<input type=\"radio\" name=\"category_id\" value=\"$id\" onclick=\"setCategoryId($id)\">&nbsp;&nbsp;$title"; 
                                                    }
                                                    echo "</li>";
                                                }
                                            }
                                        ?>
                                        <li></li>
                                    </ul>
                                </div>

                                <div style="margin-left: 10%;">
                                    <span class="details">Select Variation</span>
                                    <ul id="variations" style="list-style-type: none; display: none;">
                                        <li>
                                            <?php
                                                // Fetch food types from the database
                                                $sql = "SELECT name FROM tbl_food_variation WHERE food_id = $food_id";
                                                $res = mysqli_query($conn, $sql);

                                                $food_types = array();
                                                if ($res == TRUE) {
                                                    while($row = mysqli_fetch_assoc($res)) {
                                                        $food_types[] = $row['name'];
                                                    }
                                                }

                                                echo '<input type="hidden" id="foodTypes" value="' . htmlspecialchars(json_encode($food_types), ENT_QUOTES, 'UTF-8') . '">';

                                                // Fetch all food variations from the database
                                                $sql = "SELECT sv.name, c.title FROM tbl_store_variation sv JOIN tbl_category c ON sv.category_id = c.id ORDER BY c.title";
                                                $res = mysqli_query($conn, $sql);
                                            
                                                if ($res == TRUE) {
                                                    $current_category = '';
                                                    echo '<input type="hidden" id="category_id" name="category_id" value="' . $category_id . '">';
                                                    while ($row = mysqli_fetch_assoc($res)) {
                                                        $id = $row['id'];
                                                        $title = $row['title'];
                                                        $active = $row['active'];
                                                
                                                        if ($active == 'Yes') {
                                                            echo "<li style='margin-top: 5px;'>";
                                                            // Check if the category id matches the food's category id
                                                            if ($id == $food_category_id) {
                                                                echo "<input type=\"radio\" name=\"category\" value=\"$id\" onclick=\"updateCategoryId($id)\" checked>&nbsp;&nbsp;$title"; 
                                                            } else {
                                                                echo "<input type=\"radio\" name=\"category\" value=\"$id\" onclick=\"updateCategoryId($id)\">&nbsp;&nbsp;$title"; 
                                                            }
                                                            echo "</li>";
                                                        }
                                                    }
                                                }
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown2">
                            <div class="status" style="margin: 0; margin-top: -15px;">
                                <span class="details">Status</span>
                                <select name="status" style="font-size: 14px; font-weight: 500;">
                                    <option value="Yes" <?php echo ($active == 'Yes') ? 'selected' : ''; ?>>Active</option>
                                    <option value="No" <?php echo ($active == 'No') ? 'selected' : ''; ?>>Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="button" style="left: 0; padding-bottom: 0">
                            <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                            <input type="hidden" name="id" value="<?php echo $food_id; ?>">
                            <input type="hidden" id="category_id" name="category_id" value="<?php echo $category_id; ?>">
                            <input type="submit" name="submit" value="Update Item" class="btn-secondary">
                        </div>
                    </div>
                </section>

                <section class="food-image-container" data-title="Item's Image" style="margin-left: -20px; margin-right: 20px;">
                    <div class="image-details">
                        <div class="profile-container" style="width: 100%; height: 100%;">
                            <div class="profile-img">
                                <?php
                                    if($current_image != "")
                                    {
                                        // Display the Image
                                        echo "<img src=\"../images/food/$current_image\" id=\"profileImage\" style=\"border-radius: 0; border: 0px; width: 250px; height: 250px;\">";
                                    }
                                    else
                                    {
                                        // Display the default Image
                                        echo "<img src=\"../images/no_image.png\" id=\"profileImage\" style=\"border-radius: 0; border: 0px; width: 250px; height: 250px;\">";
                                    }
                                ?>
                            </div>
                            <div class="button" style="left: 0; padding-bottom: 0">
                                <input type="button" value="Select an Image" class="btn-secondary">
                                <input type="file" id="image" name="image" style="display: none;">
                            </div>
                        </div>
                    </div>
                </section>
            </form>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        function setCategoryId(id) {
            document.getElementById('category_id').value = id;
        }

        function updateCategoryId(id) {
            document.getElementById('category_id').value = id;
        }
        
        $(document).ready(function() {
            // Parse the food types JSON to get the food types array
            var foodTypes = JSON.parse($('#foodTypes').val());

            // Add an onchange event listener to the category radio buttons
            $('input[name="category_id"]').change(function() {
                var categoryId = $(this).val();

                $.ajax({
                    url: 'get-variations.php', // The PHP script that fetches the variations
                    type: 'GET',
                    data: { category_id: categoryId },
                    dataType: 'json',
                    success: function(response) {
                        // Clear the current variations
                        $('#variations').empty();

                        // Add the new variations
                        $.each(response, function(index, variation) {
                            // Check if the variation is in the food types array
                            var checked = $.inArray(variation, foodTypes) !== -1 ? 'checked' : '';

                            $('#variations').append('<li><label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' + variation + '" ' + checked + '/>&nbsp; ' + variation + ' &nbsp; </label> <br></li>');
                        });

                        // Show the variations list
                        $('#variations').show();
                    }
                });
            });

            // Trigger change event on the pre-filled category radio button
            document.querySelector('input[name="category_id"]:checked').dispatchEvent(new Event('change'));
        });

        document.querySelectorAll('.checkbox-splash').forEach(function(checkbox) {
            var inputBox = checkbox.parentElement.querySelector('input[type="number"]');

            if (inputBox) {
                // Store the original price in a data attribute
                inputBox.dataset.originalPrice = inputBox.value;

                // Function to enable or disable the input field
                function toggleInput() {
                    if (checkbox.checked) {
                        inputBox.disabled = false;
                        inputBox.style.backgroundColor = 'transparent';
                        inputBox.style.color = 'black';
                        inputBox.style.cursor = 'text';
                    } else {
                        inputBox.disabled = true;
                        inputBox.style.backgroundColor = '#ECECEC';
                        inputBox.style.color = '#B0B0B6';
                        inputBox.style.cursor = 'not-allowed';
                    }
                }

                // Check the initial state of the checkbox
                toggleInput();

                // Listen for changes on the checkbox
                checkbox.addEventListener('change', toggleInput);
            }
        });

        document.addEventListener('DOMContentLoaded', () => {
            const updateFoodForm = document.querySelector('#update-food-form');

            updateFoodForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(updateFoodForm);

                // Add the submit field manually
                formData.append('submit', 'Update Food');

                fetch('Process/process-update-food.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.text();
                })
                .then(text => {
                    console.log(text);
                    const data = JSON.parse(text);

                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            window.location.href = 'manage-food.php';
                        });
                    } else {
                        Swal.fire('Error!', data.message, 'error');
                    }
                })
                .catch(error => {
                    Swal.fire('Error!', error.message, 'error');
                });
            });
        });

        const fileInput = document.getElementById('image');
        const uploadButton = document.querySelector('.button input[type="button"]');

        uploadButton.addEventListener('click', () => {
            fileInput.click();
        });

        fileInput.addEventListener('change', (event) => {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                document.getElementById('profileImage').src = e.target.result;
            };

            reader.readAsDataURL(file);
        });
    </script>
    </body>
</html>