<?php include('Partials/menu.php'); ?>
    <style>
        .section-title {
            font-size: 2.5em;
            margin-bottom: 15px;
            margin-top: 15px;
            margin-left: -10px;
        }

        .location-section {
            display: flex;
            flex-wrap: wrap;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            padding: 50px;
            background-color: #E4E9F7;
        }

        .location-section .location-text {
            max-width: 800px;
            margin: 0 auto;
            margin-bottom: 25px;
            font-size: 1.2em;
            line-height: 1.6;
        }

        .location-section img {
            margin-top: 20px;
            width: 80%;
            height: auto;
            border-radius: 10px;
        }
    </style>

    <section class="home">
        <div class="location-section">
            <h2 class="section-title">Where are we?</h2>
            <p class="location-text">We are located at BG-8, Jalan Tun Perak, Taman Kenaga Mewah, 75200 Melaka. Come visit us and enjoy our delicious Yong Tau Foo and other varieties.</p>
            <div>
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d604.1700226702823!2d102.23933833243478!3d2.211040622687029!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31d1f1c0e1faef9b%3A0x6eebff51969bf9c5!2zUmVubyBLaXRjaGVuIOadpeeil-mdoiAo54K45rC06aW6IOOAgiDphb_osYbohZDvvIk!5e0!3m2!1sen!2smy!4v1717391601878!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </section>

<?php include('Partials/footer.php'); ?>