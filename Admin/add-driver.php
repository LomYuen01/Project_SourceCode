<?php include('Partials/menu.php'); ?>
<script src="https://kit.fontawesome.com/3bfb2b9d7b.js" crossorigin="anonymous"></script>
    <section class="home">
        <div class="title">
            <div class="text">Add Driver</div>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="form-container">
            <!-- =================================================== Form Section =================================================== -->
                <form id="add-driver-form" action="" method="POST" enctype="multipart/form-data" style="background: none; box-shadow: none;">
                    <section class="profile-container">
                        <div class="profile-img">
                            <img src="../images/no_profile_pic.png" id="profileImage">
                            <div class="icon-border">
                                <i class='bx bx-camera icon' title="Choose an Image" id="image_icon"></i>
                                <input type="file" id="image" name="image" style="display: none;">
                            </div>
                        </div>
                        <div class="user-details">
                            <span class="details" style="margin-top: 15px; margin-left: 27%;">Profile Picture</span>
                        </div>
                    </section>
                    
                    <section class="profile-form" data-title="Profile Details">
                        <div class="profile-details">
                            <!-- Personal Details -->
                            <span class="title-name">Personal Information</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input type="text" name="full_name" placeholder=" Full Name" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="text" name="username" placeholder=" Username" required>
                                </div>

                                <div class="input-box password">
                                    <span class="details">Password</span>
                                    <div class="password-container">
                                        <input type="password" id="password" name="password" placeholder=" Password" required>
                                        <i class="fa-solid fa-eye-slash pw-hide"></i>
                                    </div>
                                </div>

                                <div class="input-box">
                                    <span class="details">IC</span>
                                    <input type="text" id="ic" name="IC" value="" placeholder=" IC" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Email</span>
                                    <input type="email" id="email" name="email" value="" placeholder=" Email" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Ph No.</span>
                                    <input type="text" id="phone" name="ph_no" value="" placeholder=" Phone Number" required>
                                </div>
                            </div>

                            <!-- Address -->
                            <span class="title-name">Address Details</span>
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Address</span>
                                    <input type="text" name="address" placeholder=" Floor/Unit, Street" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Postal Code</span>
                                    <input type="text" name="postal_code" placeholder=" Postal Code" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">City</span>
                                    <input type="text" name="city" placeholder=" City" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">State</span>
                                    <input type="text" name="state" placeholder=" State" required>
                                </div>

                                <div class="input-box">
                                    <span class="details">Country</span>
                                    <input type="text" name="country" placeholder=" Country" required>
                                </div>
                            </div>

                            <!-- License Details -->
                            <span class="title-name">License Details</span>
                            <!-- Classification Driving License -->
                            <div class="dropdown3" style="left: 0;">
                                <div class="status" style="margin: 0; padding-right: 30px;">
                                    <span class="details">Classification Driving License</span>
                                    <select name="license_classification" style="margin-left: 0; font-size: 14px; font-weight: 500;" required>
                                        <option value="LDL">Learner’s Driving License (LDL)</option>
                                        <option value="PDL">Probationary Driving License (PDL)</option>
                                        <option value="CDL">Competent Driving License (CDL)</option>
                                        <option value="VDL">Vocational Driving License (VDL)</option>
                                        <option value="IDP">International Driving Permit (IDP)</option>
                                    </select>
                                </div>

                                <div class="dropdown-license">
                                    <div class="status" style="width: 320px; margin: 0; margin-left: 32px; padding-right: 30px;">
                                        <span class="details">License Type</span>
                                        <button class="select-icon" style="font-size: 14px; font-weight: 500;">
                                            Select License Type
                                            <i class='bx bx-chevron-down'></i>
                                        </button>
                                    </div>

                                    <div class="menu-license" style="width: 291px; font-size: 14px;">
                                        <div class="checkbox-group">
                                            <?php
                                            $license_types = ['A', 'B', 'B1', 'B2', 'C', 'D', 'DA', 'M'];
                                            foreach ($license_types as $type) {
                                                echo "<div class='checkbox'>
                                                    <input type='checkbox' name='license_type[]' value='$type'>
                                                    <label for='$type'>$type</label>
                                                </div>";
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="half-width" style="margin-top: -15px; top: 0;">
                                <div class="input-box">
                                    <span class="details">License Expiry Date</span>
                                    <input type="date" name="license_exp_date" value="<?php echo $license_exp_date; ?>" placeholder=" License Expiry Date" required>
                                </div>
                            </div>

                            <!-- Position & Status -->
                            <span class="title-name">Position & Status</span>
                            <div class="dropdown2">
                                <div class="position">
                                    <span class="text">Position</span>
                                    <select name="position" style="font-size: 14px; font-weight: 500;">
                                        <option value="Driver">Driver</option>
                                    </select>
                                </div>

                                <div class="status">
                                    <span class="text">Status</span>
                                    <select name="status" style="font-size: 14px; font-weight: 500;">
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="button">
                                <input type="submit" name="submit" value="Add driver" class="btn-secondary">
                            </div>
                        </div>
                    </section>
                </form>
            <!-- =================================================== Form Section =================================================== -->
        </div>
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const addDriverForm = document.querySelector('#add-driver-form');

            addDriverForm.addEventListener('submit', (event) => {
                event.preventDefault();

                // Send the form data to the server using AJAX
                const formData = new FormData(addDriverForm);

                // Add the submit field manually
                formData.append('submit', 'Add Driver');

                fetch('Process/process-add-driver.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error(response.statusText);
                    }
                    return response.text();  // Change this line
                })
                .then(text => {
                    console.log(text);  // Log the raw response text
                    const data = JSON.parse(text);  // Parse the text as JSON

                    if (data.success) {
                        Swal.fire('Success!', data.message, 'success').then(() => {
                            window.location.href = 'manage-driver.php';
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

        document.querySelectorAll(".dropdown-license").forEach(dropdown => {
            const button = dropdown.querySelector(".select-icon");
            const menu = dropdown.querySelector(".menu-license");

            button.addEventListener("click", (event) => {
                event.preventDefault();
                menu.classList.toggle("menu-open-license");

                // Add or remove the 'flex' display property
                if (menu.style.display !== 'flex') {
                    menu.style.display = 'flex';
                } else {
                    menu.style.display = '';
                }
            });
        });
    </script>
<script src="../Style/input-validate.js"></script>
<script src="../Style/show-hide.js"></script>
<script src="../Style/sidebar.js"></script>