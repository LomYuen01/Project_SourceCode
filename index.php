<?php include('partials-front/menu.php'); ?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            
            <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
                <input type="search" name="search" placeholder="Search for Food.." required>
                <input type="submit" name="submit" value="Search" class="btn btn-primary">
            </form>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                // Create SQL Query to Display Categories from Database
                $sql = "SELECT * FROM tbl_category WHERE active='Yes' AND featured='Yes' LIMIT 3";

                $res = mysqli_query($conn, $sql);

                // Count rows to check whether we have categories or not
                $count = mysqli_num_rows($res);

                if($count > 0)
                {
                    // Categories available
                    while($row = mysqli_fetch_assoc($res))
                    {
                        // Get the values like id, title, image_name
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>

                            <a href="<?php echo SITEURL; ?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php 
                                    if($image_name == "")
                                    {
                                        // Display message
                                        echo "<div class='error'>Image not Available.</div>";
                                    }
                                    else
                                    {
                                        // Image Available
                                        ?>

                                        <img src="<?php SITEURL ?>images/category/<?php echo $image_name ?>" alt="Pizza" class="img-responsive img-curve">
                                        
                                        <?php
                                    }
                                ?>

                                <h3 class="float-text text-color"><?php echo $title ?></h3>
                            </div>
                            </a>

                        <?php
                    }

                }
                else
                {
                    // Categories not Available
                    echo "<div class='error'> Categories not found. </div>";
                }

            ?>

            

            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>

            <?php 
                // Display all the categories that are active and featured
                $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";

                $res2 = mysqli_query($conn, $sql2);

                // Count the rows and check whether foods available or not
                $count2 = mysqli_num_rows($res2);

                if($count2 > 0)
                {
                    // Food available
                    while($row = mysqli_fetch_assoc($res2))
                    {
                        // Get the values
                        $id = $row['id'];
                        $title = $row['title'];
                        $normal_price = $row['normal_price'];
                        $large_price = $row['large_price'];
                        $description = $row['description'];
                        $image_name = $row['image_name'];
                        ?>

                        <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php 
                                    // Check whether image is available or not
                                    if($image_name == "")
                                    {
                                        // Display message
                                        echo "<div class='error'>Image not available.</div>";
                                    }
                                    else
                                    {
                                        // Image available
                                        ?>
                                        
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">
                                        
                                        <?php
                                    }
                                ?>
                            </div>

                            <div class="food-menu-desc">
                                <h4> <?php echo $title; ?> </h4>
                                <p class="food-price "> Normal Price: <?php echo $normal_price  == '0.00' ? '-' : $row['normal_price']; ?> </p>
                                <p class="food-price "> Large Price: <?php echo $large_price  == '0.00' ? '-' : $row['large_price']; ?> </p>
                                <p class="food-detail"> <?php echo $description; ?> </p>
                                <br>

                                <a href="#" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>

                        <?php
                    }
                }
                else
                {
                    // Food not available
                    echo "<div class='error'>Food not available.</div>";
                }

            ?>

            <div class="clearfix"></div>
            
        </div>

        <p class="text-center">
            <a href="#">See All Foods</a>
        </p>
    </section>
    <!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>