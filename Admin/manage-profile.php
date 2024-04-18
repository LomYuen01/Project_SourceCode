<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Profile</div>
        </div>
        <br>
        <div class="mainContent">
            <div class="form-container">
                <section class="table-1">
                    <div class="profile-img">
                        <img src="../images/ProfilePic.jpg">
                        <div class="icon-border">
                            <i class='bx bx-camera icon'></i>
                        </div>
                    </div>
                    <div class="user-details">
                        <span class="details">Lom Yuen [Superadmin]</span>
                        <span class="light-color">Erzonth</span>
                    </div>
                </section>
                <!-- =================================================== Form Section =================================================== -->
                <section class="table-form table-2">
                    <form action="" method="POST">
                        <div class="user-details">
                            <div class="half-width">
                                <div class="input-box">
                                    <span class="details">Full Name</span>
                                    <input type="text" name="full_name" placeholder="Full Name" value="LomYuen" readonly>
                                </div>
                                
                                <div class="input-box">
                                    <span class="details">Username</span>
                                    <input type="text" name="username" placeholder="Username" required>
                                </div>

                                <div class="input-box password">
                                    <span class="details">Password</span>
                                    <input type="password" id="password" name="password" placeholder="Password" required>
                                    <i class="fa-solid fa-eye-slash pw-hide"></i>
                                </div>
                            </div>
                        </div>

                        <div class="dropdown2">
                            <div class="admin_role">
                                <span class="text">Admin's Role</span>
                                <select name="admin_role" style="font-size: 14px; font-weight: 500;">
                                    <option value="Superadmin">Superadmin</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>

                            <div class="status">
                                <span class="text">Status</span>
                                <select name="status" style="font-size: 14px; font-weight: 500;">
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Resigned">Resigned</option>
                                    <option value="On Leave">On Leave</option>
                                </select>
                            </div>
                        </div>

                        <div class="button">
                            <input type="submit" name="submit" value="Update Profile" class="btn-secondary">
                        </div>
                    </form>

                </section>
            </div>
        </div>
    </section>

<?php include('Partials/footer.php'); ?>