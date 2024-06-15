<?php include('Partials/menu.php'); ?>
<style>
.hero-section {
    position: relative;
    text-align: center;
    color: white;
    background: url('../images/delivery_home.png') no-repeat center center/cover;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.hero-content {
    background: rgba(0, 0, 0, 0.5);
    padding: 20px;
    border-radius: 10px;
}

.hero-title {
    font-size: 4em;
    margin: 0;
}

.hero-subtitle {
    font-size: 1.5em;
    margin: 10px 0;
}

.hero-button {
    padding: 10px 20px;
    background-color: #000;
    color: #fff;
    text-decoration: none;
    border-radius: 5px;
    font-size: 1.2em;
}
</style>
<section class="home">

<div class="hero-section">
        <div class="hero-content">
            <h1 class="hero-title">Reno Kitchen</h1>
            <p class="hero-subtitle">Takeout & Delivery</p>
            <a href="order.php" class="hero-button">View Orders</a>
        </div>
    </div>
</section>
<?php include('Partials/footer.php'); ?>