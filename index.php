<?php
    require_once __DIR__ . '/web/template/quotation-session-init.php';
    require_once __DIR__ . '/autoload.php';

    $homeController = new HomeWebController();
    $products = $homeController->getHomeProducts();
    $topProducts = $products['topTen'];
    $outletProducts = $products['outlet'];

    $rootPath = './';
    $assetsPath = $rootPath;
    $viewsPath = './web/views/';

    $title = 'Laboratorio Jayor - Atención sanitaria y hospitalaria';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include 'web/template/head.php'; ?>
    </head>
    <body>
        <?php include 'web/fragments/mini-cart.php'; ?>
        <div class="wrapper">
            <div class="header-height-bar"></div>
            <!-- Header -->
            <?php include 'web/template/header.php'; ?>
            <!-- Header End -->
            <!-- Main -->
            <main>
                <!-- Home Slider -->
                <?php
                if (file_exists('web/fragments/slider.php')) {
                    include 'web/fragments/slider.php';
                }
                ?>
                <!-- End Home Slider -->
                <!-- Info Section -->
                <?php
                if (file_exists('web/fragments/home-info.php')) {
                    include 'web/fragments/home-info.php';
                }
                ?>
                <!-- End Info Section -->
                <!-- Products Section -->
                <?php
                if (file_exists('web/fragments/top-ten.php')) {
                    include 'web/fragments/top-ten.php';
                }
                ?>
                <!-- End Products Section -->
                <!-- Tracking Section -->
                <?php
                if (file_exists('web/fragments/home-tracking.php')) {
                    include 'web/fragments/home-tracking.php';
                }
                ?>
                <!-- End Tracking Section -->
                <!-- Outlet -->
                <?php
                if (file_exists('web/fragments/outlet.php')) {
                    include 'web/fragments/outlet.php';
                }
                ?>
                <!-- End Outlet -->
                <!-- Partners -->
                <?php
                if (file_exists('web/fragments/home-partners.php')) {
                    include 'web/fragments/home-partners.php';
                }
                ?>
                <!-- End Partners -->
                <!-- Wholesale -->
                <?php
                if (file_exists('web/fragments/home-wholesale.php')) {
                    include 'web/fragments/home-wholesale.php';
                }
                ?>
                <!-- End Wholesale -->
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include 'web/template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include 'web/template/script.php'; ?>
        <!-- Swiper carousel -->
        <script src="<?php echo $assetsPath; ?>/assets/vendor/swiper/swiper-bundle.min.js"></script>
    </body>
</html>