<?php include('partials-front/menu.php'); ?>

<!-- fOOD sEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- fOOD sEARCH Section Ends Here -->

<!-- fOOD MEnu Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <div class="row" style="display: flex; height:100%" >
            <div class="col-md-3">
                <!-- Display Categories -->
                <div class="categories" style="position: sticky; left:10%; top: 90px;">
                    <h2>Categories</h2>
                    <ul>
                        <?php
                        // Fetch categories from database
                        $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                        $res = mysqli_query($conn, $sql);
                        while ($row = mysqli_fetch_assoc($res)) {
                            $category_id = $row['id'];
                            $category_title = $row['title'];
                            ?>
                            <li><a href="#<?php echo $category_id; ?>"><?php echo $category_title; ?></a></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9" style="width: 80%;  margin-left: 10%;">
                <!-- Display Food Items -->
                <h2 class="text-center">Food Menu</h2>
                <div style="display: flex; flex-direction: row; justify-content: start;flex-direction: column;">
                    <?php
                    // Fetch foods from database based on categories
                    $sql_category = "SELECT * FROM tbl_category WHERE active='Yes'";
                    $res_category = mysqli_query($conn, $sql_category);
                    while ($row_category = mysqli_fetch_assoc($res_category)) {
                        $category_id = $row_category['id'];
                        $category_title = $row_category['title'];

                        // Fetch foods based on category
                        $sql_food = "SELECT * FROM tbl_food WHERE category_id=$category_id AND active='Yes'";
                        $res_food = mysqli_query($conn, $sql_food);
                        $count = mysqli_num_rows($res_food);

                        if ($count > 0) {
                            ?>
                            <div class="food-menu-box" style="display:block; width:auto">
                                <h4 id="<?php echo $category_id; ?>"><?php echo $category_title; ?></h4>
                                <?php while ($row_food = mysqli_fetch_assoc($res_food)) {
                                    $food_id = $row_food['id'];
                                    $food_title = $row_food['title'];
                                    $food_price = $row_food['normal_price'];
                                    $food_description = $row_food['description'];
                                    $food_image = $row_food['image_name'];
                                    ?>
                                    <div class="food-menu-box"  style="display: flex;">
                                        <div class="food-menu-img">
                                            <?php if ($food_image == "") { ?>
                                                <div class='error'>Image not Available.</div>
                                            <?php } else { ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>"
                                                    alt="<?php echo $food_title; ?>"
                                                    class="img-responsive img-curve">
                                            <?php } ?>
                                        </div>
                                        <div class="food-menu-desc">
                                            <h4><?php echo $food_title; ?></h4>
                                            <p class="food-price ">$<?php echo $food_price; ?></p>
                                            <p class="food-detail"><?php echo $food_description; ?></p>
                                            <br>
                                            <a href="<?php echo SITEURL; ?>cart.php?food_id=<?php echo $food_id; ?>"
                                            class="btn btn-primary">Add to Cart</a>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php }
                    } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- fOOD Menu Section Ends Here -->

<?php include('partials-front/footer.php'); ?>
