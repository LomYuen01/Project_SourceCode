<?php include('Partials/menu.php'); ?>

    <section class="home">
        <div class="title">
            <div class="text">Dashboard</div>
            <img src="../images/ProfilePic.jpg" rel="logo" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../images/ProfilePic.jpg">
                        <h3>Lom Yuen [Superadmin]</h3>
                    </div>

                    <!-- LINEEEEEEEE --> <hr> <!-- LINEEEEEEEE -->

                    <a href="manage-profile.php" class="sub-menu-link">
                        <i class='bx bxs-user-circle icon'></i>
                        <p>View Profile</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </div>

        <br>

        <div class="mainContent">

        </div>
    </section>

    <script>
        let subMenu = document.getElementById("subMenu");

        function toggleMenu(){
            subMenu.classList.toggle("open-menu");
        }
    </script>
<?php include('Partials/footer.php'); ?>