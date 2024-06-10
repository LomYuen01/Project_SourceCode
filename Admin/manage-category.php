<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Category</div>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="table">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-header">
                
                <div class="dropdown-toggle-column">
                    <div class="icon-border">
                        <i class='bx bx-cog select-icon'></i>
                        <span class="tooltip">Toggle Column</span>
                    </div>
                    
                    <ul class="menu-column" style="width: 200px; font-size: 12px;">
                        <li>
                            <label><input type="checkbox" class="checkbox-column" data-column="1" checked/>&nbsp; No. &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="2" checked/>&nbsp; Title &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="3" checked/>&nbsp; Status &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="4" checked/>&nbsp; Actions &nbsp; </label> <br>
                        </li>
                    </ul>
                </div>

                <div class="input-group" style="margin-left: 50px;">
                    <input type="search" placeholder="Search Data...">
                    <i class='bx bx-search'></i>
                </div>

                <span></span>
                <span></span>

                <div class="add-food">
                    <label for="dropdown-nav-bar" class="add-btn">
                        <i class='bx bx-plus icon'></i>
                        <?php echo "<a href=\"".SITEURL."admin/add-category.php\">Add Category</a>" ?>
                    </label>
                </div>
            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body"style="height: 100%; box-shadow: -5px 0px 15px 2px rgba(0, 0, 0, 0.1);">
                <table>
                    <thead>
                        <tr>
                            <th> No. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></th>
                            <th> Title <span class="icon-arrow"></span></th>
                            <th> Status <span class="icon-arrow"></i></span></th>
                            <th> Actions <span class="icon-arrow"></i></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT * FROM tbl_category";
                            $res = mysqli_query($conn, $sql);

                            // Count the rows
                            $count = mysqli_num_rows($res);

                            $SN = 1;

                            if($count > 0)
                            {
                                // We have data in database
                                while($row = mysqli_fetch_assoc($res))
                                {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    $active = $row['active'];
                                
                                    // Assign status based on the value of active
                                    $status = ($active == 'Yes') ? 'Active' : 'Inactive';
                                    $status_class = strtolower($status) . '_status';
                                ?>
                                
                                <tr>
                                    <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                    <td><?php echo $title; ?></td>
                                    <td><div class="<?php echo $status_class; ?>"><?php echo $status; ?></div></td>
                                    <td class="buttons">
                                        <a href="<?php echo SITEURL; ?>admin/update-category.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px;" class="btn-secondary" title="Update Category"><i class='bx bxs-edit'></i></a>
                                        <a href="javascript:void(0);" onclick="deleteCategory(<?php echo $id; ?>);" style="width: 40px; font-size: 14px;" class="btn-danger" title="Delete Category"><i class='bx bx-trash'></i></a>
                                    </td>
                                </tr>

                                <?php
                                }
                            }
                            else
                            {
                            // We do not have data in database
                            ?>

                                <tr>
                                    <td colspan="6"><div class="error">No Category Added</div></td>
                                </tr>

                            <?php
                        }
                    ?>
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
        </div>
    </section>
    <script>
        document.querySelectorAll(".dropdown-toggle-column").forEach(dropdown => {
            const select = dropdown.querySelector(".select-icon");
            const menu = dropdown.querySelector(".menu-column");

            select.addEventListener("click", () => {
                menu.classList.toggle("menu-open-column");

                // Add or remove the 'flex' display property
                if (menu.style.display !== 'flex') {
                    menu.style.display = 'flex';
                    // Scroll to the bottom of the dropdown
                    menu.lastElementChild.scrollIntoView(true);
                } else {
                    menu.style.display = '';
                }
            });
        });

        // Function to update column visibility
        function updateColumnVisibility(column, checked) {
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                if (checked) {
                    cell.classList.remove('hidden-column');
                } else {
                    cell.classList.add('hidden-column');
                }
            });
        }

        // Code for hiding and showing columns
        document.querySelectorAll('.checkbox-column').forEach(function(checkbox) {
            var column = checkbox.dataset.column;

            // Add the 'hidden-column' class to the cells in this column
            document.querySelectorAll('tr > :nth-child(' + column + ')').forEach(function(cell) {
                cell.classList.add('hidden-column');
            });

            // Get the page name
            var pageName = window.location.pathname.split("/").pop();

            // Load the saved state from localStorage
            var savedState = localStorage.getItem(pageName + '-checkbox-column-' + column);
            if (savedState !== null) {
                checkbox.checked = savedState === 'true';
            }

            // Update column visibility based on checkbox state
            updateColumnVisibility(column, checkbox.checked);

            checkbox.addEventListener('change', function() {
                var checked = this.checked;

                // Save the state to localStorage
                localStorage.setItem(pageName + '-checkbox-column-' + column, checked);

                // Update column visibility based on checkbox state
                updateColumnVisibility(column, checked);
            });
        });

        // Show the content once the state has been loaded
        document.body.style.display = '';

        function deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '<?php echo SITEURL; ?>admin/delete-category.php',
                        type: 'GET',
                        data: {
                            id: id
                        },
                        success: function(response) {
                            if(response == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    'Your category has been deleted.',
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    'Failed to delete category.',
                                    'error'
                                );
                            }
                            // Reload the page after showing the alert
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        }
                    });
                }
            })
        }
    </script>

<?php include('Partials/footer.php'); ?>