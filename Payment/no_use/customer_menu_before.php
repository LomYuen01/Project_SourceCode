<?php include('partials/menu.php');?>

    <style>
        .selector {
            display: flex;
            flex-direction: row;
        }

        .group {
            margin-bottom: 20px;
        }

        .title {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .options {
            display: flex;
            
        }

        .option {
            padding: 10px;
            border: 1px solid #555;
            cursor: pointer;
            text-align: center;
            border-radius: 4px;
            
        }


        .option.active {
            border: 1px solid #ff4500;
            background-color: #ff4500;
        }

        .option.disabled {
            border: 1px solid #555;
            background-color: #555;
            cursor: not-allowed;
            color: #888;
        }

        button {
            background-color: white;
            color: black; /* Set the text color to black or any color you prefer */
        }

        </style>

    <section class="home">
        <!--===== Content =====-->
        <section class="food-search text-center">
            <div class="container">
                <form action="<?php echo SITEURL; ?>food-search.php" method="POST" style="display: flex; flex-direction: row; align-items: center; justify-content: center; font-size: 1em; color: black;">
                <input type="search" name="search" placeholder="Search for Food.." required style="font-size: 1em; color: black; border-radius: 18px; border:2px solid black;">
                <input type="submit" name="submit" value="Search" class="btn btn-primary" style="font-size: 1em; color: black;">
            </form>
            </div>
        </section>
        <!-- fOOD sEARCH Section Ends Here -->

        <!-- fOOD MEnu Section Starts Here -->
        <section class="food-menu">
            <div class="container">
                <div class="row">
                    <div class="col-md-3" style="display: flex;">
                        <!-- Display Categories -->
                        <div class="categories" style="position: fixed; left:5%; top: 20%;list-style-type: none; border:1cm ">
                            <h2 style="font-weight: bold; font-size: 18px;">Categories</h2>
                            <ul style="color: black; flex-direction: column;">
                                <?php
                                // Fetch categories from database
                                $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                                $res = mysqli_query($conn, $sql);
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    ?>
                                    <li style="display: flex; flex-direction: column; padding-left:20px; "><a href="#<?php echo $category_id; ?>" style="color: black;"><?php echo $category_title; ?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-9" style=" margin-left: 10%;">
                        <!-- Display Food Items -->
                        <h2 class="text-center" style="font-size:2em;">Food Menu</h2>
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
                                    <div class="food-menu-box" style="display:flex; flex-wrap: wrap; width:90%; flex-direction: row; justify-content: space-between; margin: 4px 0; padding-bottom:10%; padding-left:5%; padding-right:5%; box-shadow: rgba(0, 0, 0, 0.04) 0px 3px 5px; border-radius: 2em;">
                                        <h4 id="<?php echo $category_id; ?>" style="display: block; width:100%; font-color:red;font-weight: bold;font-size: 35px;"><?php echo $category_title; ?></h4>
                                        
                                            <?php while ($row_food = mysqli_fetch_assoc($res_food)) {
                                                $food_id = $row_food['id'];
                                                $food_title = $row_food['title'];
                                                $normal_price = $row_food['normal_price'];
                                                $food_description = $row_food['description'];
                                                $food_image = $row_food['image_name'];
                                                ?>
                                                <form method="post">
                                                <div class="food-menu-box"  style="display: flex; width:45%;  padding-bottom:5%;border: 2px solid pink;">
                                                    <div class="food-menu-desc" style="flex: 0 0 60%;">
                                                        <h4><?php echo $food_title; ?></h4>
                                                        <p class="food-detail" style="max-height: 160px; overflow-y: auto; scrollbar-width: none;"><?php echo $food_description; ?></p>
                                                        <p>Variation</p>
                                                        <div>
                                                            <select name="variation" id="variation" style="border: 1px solid; border-radius: 18px; padding: 5px;">
                                                                <?php
                                                                $sql = "SELECT name, active FROM tbl_food_variation WHERE food_id = $food_id AND active = 'Yes'";
                                                                $result = $conn->query($sql);
                                                                if ($result->num_rows > 0) {
                                                                    while($row = $result->fetch_assoc()) {
                                                                        echo "<option value='".$row['name']."'>".$row['name']."</option>";
                                                                    }
                                                                }
                                                                ?>
                                                            </select>
                                                        </div>
                                                        <p class="food-price "></p>
                                                        <div class="selector">
                                                            <div class="group">
                                                                <div class="title">Price</div>
                                                                <div class="options" style="width: auto;">
                                                                    <?php
                                                                    $sql = "SELECT normal_price, large_price, normal_active, large_active FROM tbl_food WHERE id = $food_id";
                                                                    $result = $conn->query($sql);
                                                                    if ($result->num_rows > 0) {
                                                                        $row = $result->fetch_assoc();
                                                                        
                                                                        if ($row['normal_active'] == 'No') {
                                                                            echo "<label class='container' style='display: block;  padding-left: 35px; margin-bottom: 12px; cursor: pointer; font-size: 22px; '>
                                                                                    <input type='radio' name='price' value='Regular'>
                                                                                    <span class='checkmark'></span>
                                                                                    $".$row['normal_price']."
                                                                                </label>";
                                                                        }
                                                                        if ($row['large_active'] == 'No') {
                                                                            echo "<label class='container' style='display: block;  padding-left: 35px; margin-bottom: 12px; cursor: pointer; font-size: 22px; '>
                                                                                    <input type='radio' name='price' value='Large'>
                                                                                    <span class='checkmark'></span>
                                                                                    $".$row['large_price']."
                                                                                </label>";
                                                                        }
                                                                        echo "<input type='hidden' id='size' name='size'>";
                                                                    }
                                                                    ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <br>
                                                    </div >
                                                    <div class="food-menu-img" style="flex: 1;flex-direction: column; border: 2px solid blue; justify-content: center;">
                                                        <?php if ($food_image == "") { ?>
                                                            <div class='error' style="width: 112px; height: 112px;">Image not Available.</div>
                                                        <?php } else { 
                                                            ?>
                                                            <div>
                                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $food_image; ?>"
                                                                    alt="<?php echo $food_title; ?>"
                                                                    class="img-responsive img-curve"
                                                                    style="width: 100%; height: 50%;">
                                                            </div>
                                                            <?php } ?>
                                                            <div>
                                                                <button type="submit" class="btn btn-primary" style="display: block; margin: auto; border: 1px solid; border-radius: 18px; color:var(--sk-body-link-color, #06c); text-align: center; font-size: 1em;">Add to Cart</button>
                                                            </div>
                                                    </div>
                                                </div>
                                            <?php } ?>
                                        </form>
                                    </div>
                                <?php }
                            } ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </section>

    <script>


</script>

<?php include('partials/footer.php'); ?>
