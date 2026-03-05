<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    $productController = new ProductWebController();
    $outletProducts = $productController->getOutletProducts();

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Outlet Jayor';
    $headlineTitle = 'Outlet Jayor';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
    </head>
    <body>
        <?php include '../fragments/mini-cart.php'; ?>
        <div class="wrapper">
            <div class="header-height-bar"></div>
            <!-- Header -->
            <?php include '../template/header.php'; ?>
            <!-- Header End -->
            <!-- Main -->
            <main>
                <?php include '../fragments/page-info.php'; ?>
                <?php include '../fragments/outlet.php'; ?>
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-outlet');
            });
        </script>
    </body>
</html>