
<?php include('Partials/menu.php'); ?>

        <!-- Main Content Section Starts -->
        <div class="mainContent">
            <div class="wrapper">
                <h1>Dashboard</h1>

                <br>
                <?php 
                    if(isset($_SESSION['login']))
                    {
                        echo nl2br($_SESSION['login']);
                        unset($_SESSION['login']);
                    }
                ?>
                <br>

                <div class="Column-4">
                    <h1>5</h1>
                    Categories
                </div>

                <div class="Column-4">
                    <h1>5</h1>
                    Categories
                </div>

                <div class="Column-4">
                    <h1>5</h1>
                    Categories
                </div>

                <div class="Column-4">
                    <h1>5</h1>
                    Categories
                </div>

                <div class="clearfix"></div>

            </div>
        </div>
        <!-- Main Content Section Ends -->

<?php include('Partials/footer.php'); ?>