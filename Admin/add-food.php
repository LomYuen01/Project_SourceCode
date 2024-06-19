<?php include('Partials/menu.php'); ?>
    <section class="home">
        <div class="title">
            <div class="text">Add Menu Item</div>
        </div>

        <!-- Break --><br><!-- Line -->

        <div class="table" style="padding-left: 25px; padding-right: 5px; overflow: hidden;">
            <form id="add-food-form" action="" method="POST" enctype="multipart/form-data" style="display: flex; flex-direction: row; gap: 15px; width: 100%;">
                <section class="food-container" data-title="Menu Item Details">
                    <div class="food-details">
                        <div class="input-box">
                            <span class="details">Item Name</span><br>
                            <input type="text" name="title" placeholder=" Noodles" required>
                        </div>

                        <div class="input-box" style="margin-top: 10px;">
                            <span class="details">Item Price</span><br>
                            <div class="price-box" style="margin-left: 5px;">
                                <input type="checkbox" class="checkbox-splash" name="normal_active" style="margin-top: 10px;">
                                <div class="input-box" style="width: 92.5%;">
                                    <span class="details" style="font-size: 13px; font-weight: 500;">Regular Price</span><br>
                                    <input type="number" name="normal_price" placeholder=" Price" style="margin-left: 0; background-color: #ECECEC; color: #B0B0B6; cursor: not-allowed;" min="0" step="0.01" required disabled>
                                </div>
                            </div>

                            <div class="price-box" style="margin-left: 5px;">
                                <input type="checkbox" class="checkbox-splash" name="large_active" style="margin-top: 10px;">
                                <div class="input-box" style="width: 92.5%;">
                                    <span class="details" style="font-size: 13px; font-weight: 500;">Large Price</span><br>
                                    <input type="number" name="large_price" placeholder=" Price" style="margin-left: 0; background-color: #ECECEC; color: #B0B0B6; cursor: not-allowed;" min="0" step="0.01" required disabled>
                                </div>
                            </div>
                        </div>
                        
                        <div class="input-box">
                            <span class="details">Item Description</span><br>
                            <textarea type="text" name="description" placeholder=" Noodles is tasty" required></textarea>
                        </div>

                        <div class="input-box">
                            <span class="details">Item Quantity</span><br>
                            <input type="number" name="quantity" placeholder=" 100" min="0" step="0" required>
                        </div>

                        <div class="input-box" style="margin-top: 15px;">
                            <div class="style" style="display: flex; flex-direction: row;">
                                <div style="margin-left: 0px;">
                                    <span class="details">Select Category</span>
                                    <ul class="category-menu" style="list-style-type: none; margin-left: 10px;">
                                        <?php
                                            // Fetch all categories from the database
                                            $sql = "SELECT * FROM tbl_category";
                                            $res = mysqli_query($conn, $sql);

                                            while ($row = mysqli_fetch_assoc($res)) {
                                                $id = $row['id'];
                                                $title = $row['title'];
                                                $active = $row['active'];

                                                if ($active == 'Yes') {
                                                    echo "<li style='margin-top: 5px;'>";
                                                    echo "<input type=\"radio\" name=\"category_id\" value=\"$id\" style=\"font-size: 20px;\">&nbsp;&nbsp;$title"; 
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
                                                // Fetch all food variations from the database
                                                $sql = "SELECT sv.name, c.title FROM tbl_store_variation sv JOIN tbl_category c ON sv.category_id = c.id ORDER BY c.title";
                                                $res = mysqli_query($conn, $sql);
                                            
                                                if ($res == TRUE) {
                                                    $current_category = '';
                                                    while($row = mysqli_fetch_assoc($res)) {
                                                        $variation = $row['name'];
                                                        $category = $row['title'];

                                                        // If the category has changed, print the category name
                                                        if ($category != $current_category) {
                                                            echo '<span class="details">' . $category . '</span> <br>';
                                                            $current_category = $category;
                                                        }
                                                        echo '<label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' . $variation . '"/>&nbsp; ' . $variation . ' &nbsp; </label> <br>';
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
                                    <option value="Yes">Active</option>
                                    <option value="No">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="button" style="left: 0; padding-bottom: 0">
                            <input type="submit" name="submit" value="Add Item" class="btn-secondary">
                        </div>
                    </div>
                </section>

                <section class="food-image-container" data-title="Item's Image" style="margin-left: -20px; margin-right: 20px;">
                    <div class="image-details">
                        <div class="profile-container" style="width: 100%; height: 100%;">
                            <div class="profile-img">
                                <img src="../images/no_image.png" id="profileImage" style="border-radius: 0; border: 0px; width: 250px; height: 250px;">
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

        document.querySelectorAll('.checkbox-splash').forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                // Correctly target the nested input element within the next sibling div
                var inputBox = this.nextElementSibling.querySelector('input[type="number"]');
                // Add transition property to the input box
                inputBox.style.transition = 'background-color 0.5s ease, color 0.5s ease, cursor 0.5s ease';
                if (this.checked) {
                    inputBox.disabled = false;
                    inputBox.style.backgroundColor = 'transparent'; // Adjusted for better visibility
                    inputBox.style.color = 'black';
                    inputBox.style.cursor = 'text';
                } else {
                    inputBox.disabled = true;
                    inputBox.style.backgroundColor = '#ECECEC';
                    inputBox.style.color = '#B0B0B6';
                    inputBox.style.cursor = 'not-allowed';
                }
            });
        });

        $(document).ready(function() {
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
                            $('#variations').append('<li><label><input type="checkbox" class="checkbox-splash" name="food_type[]" value="' + variation + '"/>&nbsp; ' + variation + ' &nbsp; </label> <br></li>');
                        });

                        // Show the variations list
                        $('#variations').show();
                    }
                });
            });
        });

        document.addEventListener('DOMContentLoaded', () => {
            const addFoodForm = document.querySelector('#add-food-form');

            addFoodForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(addFoodForm);

                // Add the submit field manually
                formData.append('submit', 'Add Food');

                fetch('Process/process-add-food.php', {
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
    </script>
    </body>
</html>