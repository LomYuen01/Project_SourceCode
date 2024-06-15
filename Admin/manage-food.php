<?php 
    $category_id = isset($_GET['category_id']) ? $_GET['category_id'] : null;
    include('Partials/menu.php');
?>

    <section class="home">
        <div class="title">
            <div class="text">Manage Menu Items</div>
        </div>

        <!-- Break --><br><!-- Line -->
        
        <div class="table">
            <!-- =================================================== Header Section =================================================== -->
            <section class="table-header">

                <!-- Dropdown Options to Disable or Enable a column Data to save space if user wants -->
                <div class="dropdown-toggle-column">
                    <div class="icon-border">
                        <i class='bx bx-cog select-icon'></i>
                        <span class="tooltip">Toggle Column</span>
                    </div>
                    
                    <ul class="menu-column" style="width: 189px; font-size: 12px;">
                        <li>
                            <label><input type="checkbox" class="checkbox-column" data-column="1" checked/>&nbsp; No. &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="2" checked/>&nbsp; Food Name &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="3" checked/>&nbsp; Category &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="4" checked/>&nbsp; Recommended &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="5" checked/>&nbsp; Status &nbsp; </label> <br>
                            <label><input type="checkbox" class="checkbox-column" data-column="6" checked/>&nbsp; Actions &nbsp; </label>
                        </li>
                    </ul>
                </div>

                <div class="dropdown" style="margin-left: -278.5px;">
                    <div class="select">
                        <span class="selected">Show All</span>
                        <div class="caret"></div>
                    </div>
                    
                    <ul class="menu">
                        <li>
                            <a href="<?php echo SITEURL; ?>admin/manage-food.php">Show All</a>
                        </li>
                        <?php
                            $sql = "SELECT * FROM tbl_category";
                            $res = mysqli_query($conn, $sql);

                            while ($row = mysqli_fetch_assoc($res)) {
                                $id = $row['id'];
                                $title = $row['title'];

                                echo "<li>";
                                echo "<a href=\"".SITEURL."admin/manage-food.php?category_id=$id\">$title</a>";
                                echo "</li>";
                            }
                        ?>
                    </ul>
                </div>

                <div class="input-group">
                    <input type="search" placeholder="Search Data...">
                    <i class='bx bx-search'></i>
                </div>

                <span></span>
                <span></span>

                <div class="add-food">
                    <label for="dropdown-nav-bar" class="add-btn">
                        <i class='bx bx-plus icon'></i>    
                        <?php echo "<a href=\"".SITEURL."admin/add-food.php\">Add Food</a>" ?>
                    </label>
                </div>
            </section>
            <!-- =================================================== Header Section =================================================== -->

            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-body" style="width: calc(59% - 32px); box-shadow: -5px 0px 15px 2px rgba(0, 0, 0, 0.1); margin-left: 32px;">
                <table>
                    <thead>
                        <tr>
                            <th> <span class="cursor_pointer">No. <span class="icon-arrow"><i class='bx bx-chevron-down icon'></i></span></span></th>
                            <th> <span class="cursor_pointer">Food Name <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Category <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Recommended <span class="icon-arrow"></span></span></th>
                            <th> <span class="cursor_pointer">Status <span class="icon-arrow"></span></span></th>
                            <th style="padding-right: 4rem;"> <span class="cursor_pointer">Actions <span class="icon-arrow"></span></span></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $sql = "SELECT tbl_food.*, tbl_category.title AS category_name 
                            FROM tbl_food 
                            INNER JOIN tbl_category ON tbl_food.category_id = tbl_category.id";

                            if ($category_id !== null) {
                            $sql .= " WHERE tbl_food.category_id = $category_id";
                            }

                            $sql .= " ORDER BY tbl_category.id ASC, tbl_food.id ASC";
                            $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

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
                                    $featured = $row['featured'];
                                    $active = $row['active'];
                                    $category = $row['category_name'];
                                    $image_name = $row['image_name'];

                                    // Assign status based on the value of active
                                    $status = ($active == 'Yes') ? 'Active' : 'Inactive';
                                    $status_class = strtolower($status) . '_status';
                                ?>
                                    <tr style="font-size: 12px;" data-id="<?php echo $id; ?>">
                                        <td><?php echo str_pad($SN++, 2, '0', STR_PAD_LEFT); ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $category; ?></td>
                                        <td><?php echo $featured; ?></td>
                                        <td><div class="<?php echo $status_class; ?>"><?php echo $status; ?></div></td>
                                        <td class="buttons" style="padding-right: 4rem;">
                                            <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id; ?>" style="width: 40px; font-size: 14px;" class="btn-secondary"><i class='bx bxs-edit'></i></a>
                                            <a href="javascript:void(0);" onclick="deleteFood(<?php echo $id; ?>, '<?php echo $image_name; ?>');" style="width: 40px; font-size: 14px;" class="btn-danger"><i class='bx bx-trash'></i></a>
                                        </td>
                                    </tr>

                                <?php
                                }
                            }
                            else
                            {
                                // We do not have data in database
                                echo "<tr> <td colspan='7'> <div class='error'> No Food Added </div> </td> </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </section>
            <!-- ==================================================== Body Section ==================================================== -->
            <section class="table-aside">
                <div class="scrollable-content">
                    <?php
                    // Retrieve all food items from the database
                    $sql = "SELECT tbl_food.*, tbl_category.title AS category_name 
                    FROM tbl_food 
                    INNER JOIN tbl_category ON tbl_food.category_id = tbl_category.id";

                    if ($category_id !== null) {
                    $sql .= " WHERE tbl_food.category_id = $category_id";
                    }

                    $sql .= " ORDER BY tbl_category.id ASC, tbl_food.id ASC";
                    $res = mysqli_query($conn, $sql) or die(mysqli_error($conn));

                    if ($res == true) {
                        $count = mysqli_num_rows($res);

                        if ($count > 0) {
                            while ($row = mysqli_fetch_assoc($res)) {
                                $title = $row['title'];
                                $normal_price = $row['normal_price'];
                                $large_price = $row['large_price'];
                                $description = $row['description'];
                                $image_name = $row['image_name'];
                                $quantity = $row['quantity'];
                                ?>
                                <div class="food-details-container" data-id="<?php echo $row['id']; ?>">
                                    <article class="food-details-box">
                                        <h4 class="details food_name"><?php echo $title; ?></h4>
                                        <p class="details price">&nbsp;&nbsp;RM <?php echo $normal_price; ?> - Regular<br>&nbsp;&nbsp;RM <?php echo $large_price; ?> - Large</p>
                                        <p class="description" style="font-size: 12px; margin-top: 5px;"><span style="font-weight: 500;">Description: </span><br><span id="description-text"><?php echo $description; ?></span></p>
                                    </article>

                                    <figure class="img-container">
                                        <img src="../images/Food/<?php echo $image_name; ?>">
                                        <p class="details quantity">Quantity: <?php echo $quantity; ?></p>
                                    </figure>
                                </div>
                                <i class="bx bx-down-arrow-circle icon"></i>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
                <div class="icon-border-up"><i class="bx bx-up-arrow-alt move-up"></i></div>
                <div class="icon-border-down"><i class="bx bx-down-arrow-alt move-down"></i></div>
            </section>
        </div>
    </section>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        const dropdown = document.querySelector(".dropdown");
        const select = dropdown.querySelector(".select");
        const caret = dropdown.querySelector(".caret");
        const menu = dropdown.querySelector(".menu");
        const options = dropdown.querySelectorAll(".menu li");
        const selected = dropdown.querySelector(".selected");

        // Get the category id from the URL
        var urlParams = new URLSearchParams(window.location.search);
        var selectedCategoryId = urlParams.get('category_id');

        select.addEventListener("click", () => {
            select.classList.toggle("select-clicked");
            caret.classList.toggle("caret-rotate");
            menu.classList.toggle("menu-open")
        })

        options.forEach(option => {
            option.addEventListener("click", (event) => {
                select.classList.remove("select-clicked");
                caret.classList.remove("caret-rotate");
                menu.classList.remove("menu-open");
                options.forEach(option => {
                    option.classList.remove("active1")
                })
                option.classList.add("active1")

                // Follow the link
                window.location.href = option.querySelector('a').href;
            })

            // If this option's category id matches the selected category id, mark it as selected
            var optionCategoryId = option.querySelector('a').href.split('=')[1];
            if (optionCategoryId === selectedCategoryId) {
                selected.innerText = option.innerText;
                option.classList.add("active1");
            }

            // If the selected category id is null or undefined, mark the "Show All" option as selected
            if (!selectedCategoryId) {
                options[0].classList.add("active1");
            }
        })

        var $container = $('.scrollable-content');
        var $foodDetails = $container.find('.food-details-container');
        var currentIndex = $foodDetails.length - 1;

        // Disable mouse scrolling
        $container.on('wheel', function(event) {
            event.preventDefault();
        });

        // Add a class to the active row
        function setActiveRow(id) {
            $('tbody tr').removeClass('active-row');
            $('tbody tr[data-id="' + id + '"]').addClass('active-row');
        }

        $('.icon-border-down').on('click', function(event) {
            // Find the closest food detail to the top of the container
            var closest = null;
            var closestTop = Infinity;
            $foodDetails.each(function(index) {
                var top = $(this).position().top;
                if (top > 0 && top < closestTop) {
                    closest = index;
                    closestTop = top;
                }
            });

            // If a closest food detail was found, set the current index to the next food detail
            if (closest !== null) {
                currentIndex = Math.min($foodDetails.length - 1, closest + 1);
            }

            // Calculate the position of the new food detail
            var position = 0;
            $foodDetails.each(function(index) {
                if (index < currentIndex) {
                    position += $(this).outerHeight(true);
                }
            });

            // Scroll to the new food detail
            $container.animate({ scrollTop: position }, 'slow', function() {
                setActiveRow($foodDetails.eq(currentIndex).data('id'));
            });
        });

        $('.icon-border-up').on('click', function(event) {
            // Find the first food detail that is fully in view at the top of the container
            var closest = null;
            $foodDetails.each(function(index) {
                var top = $(this).position().top;
                if (top >= 0) {
                    closest = index;
                    return false; // Break the loop
                }
            });

            // If a closest food detail was found, set the current index to the previous food detail
            if (closest !== null) {
                currentIndex = Math.max(0, closest - 1);
            }

            // Calculate the position of the new food detail
            var position = 0;
            $foodDetails.each(function(index) {
                if (index < currentIndex) {
                    position += $(this).outerHeight(true);
                }
            });

            // Scroll to the new food detail
            $container.animate({ scrollTop: position }, 'slow', function() {
                setActiveRow($foodDetails.eq(currentIndex).data('id'));
            });
        });

        $('tbody tr').on('click', function() {
            var id = $(this).data('id');
            var $container = $('.scrollable-content');
            var $foodDetail = $('.food-details-container[data-id="' + id + '"]');

            // Calculate the position of the food detail by summing the heights of all previous food details
            var position = 0;
            $container.find('.food-details-container').each(function() {
                if ($(this).data('id') === id) {
                    return false; // Break the loop
                }
                position += $(this).outerHeight(true);
            });

            // Scroll to the food detail
            $container.animate({ scrollTop: position }, 'slow', function() {
                setActiveRow(id);
            });
        });

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

        function deleteFood(id, imageName) {
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
                        url: '<?php echo SITEURL; ?>admin/delete-food.php',
                        type: 'GET',
                        data: {
                            id: id,
                            image_name: imageName
                        },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if(data.status == 'success') {
                                Swal.fire(
                                    'Deleted!',
                                    data.message,
                                    'success'
                                );
                            } else {
                                Swal.fire(
                                    'Failed!',
                                    data.message,
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