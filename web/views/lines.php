<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    $lineController = new LineWebController();
    $lines = $lineController->getLines();

    $title = 'Laboratorio Jayor - Líneas de productos';
    $headlineTitle = 'Productos';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" href="../../assets/css/line.css"/>
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
                <?php include '../fragments/line.php'; ?>
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-product');
            });
        </script>
    </body>
</html>