<?php
require('template/header.php');
?>
<div class="app-main__outer">
    <div class="app-main__inner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 d-lg-flex flex-lg-column justify-content-center align-items-stretch pt-5 pt-lg-0 order-2 order-lg-1" data-aos="fade-up">
                    <div class="">
                        <h1>Selamat Datang...</h1>
                        <h2>diPrint adalah situs yang menawarkan jasa cetak online dengan mudah, cepat,
                            murah, bisa dilakukan
                            dimana saja dan kapan saja</h2>
                    </div>
                </div>
                <div class="col-lg-6 d-lg-flex flex-lg-column align-items-stretch order-1 order-lg-2 hero-img" data-aos="fade-up">
                    <img src="../assets/img/hero-img.png" class="img-fluid" alt="">
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@2/src/js.cookie.min.js"></script>
    <script>

        const session = Cookies.get("session");

        if (session) {
            const user = JSON.parse(session);

        document.querySelector("#widget-name").textContent = user.displayName || "Anonimous";
        document.querySelector("#widget-email").textContent = user.email;
        } else {
            window.location.href = "/diprint/login.php"
        }

    </script>
    <?php
    require('template/footer.php');
    ?>