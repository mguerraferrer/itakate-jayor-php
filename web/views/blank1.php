<?php
    require_once __DIR__ . '/../../autoload.php';

    $lineCode = $_GET['l'] ?? '';
    $brandCode = $_GET['b'] ?? '';

    $productController = new ProductWebController();
    $productSource = $productController->loadProducts($lineCode, $brandCode);
    $lines = $productSource['lines'] ?? [];
    $brands = $productSource['brands'] ?? [];
    $products = $productSource['products'] ?? [];
    $lineActive = $productSource['lineActive'] ?? null;
    $brandActive = $productSource['brandActive'] ?? null;

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Productos';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" href="../../assets/css/product.css"/>
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
                <section class="py-6">
                    <div class="container">
                        <div class="row">
                            <!-- Sidebar -->
                            <?php include '../fragments/sidebar.php'; ?>
                            <!-- End Sidebar -->
                            <!-- Product Box -->
                            <div class="col-lg-8 col-xl-9">
                                <div class="shop-top-bar d-flex pb-3">
                                    <div class="layout-change">
                                        <!-- Mobile Toggle -->
                                        <button class="btn btn-sm d-lg-none" type="button" data-bs-toggle="offcanvas"
                                                data-bs-target="#shop_filter" aria-controls="shop_filter">
                                            <i class="fs-4 lh-1 bi bi-justify-left"></i>
                                        </button>
                                        <!-- End Mobile Toggle -->
                                    </div>
                                </div>
                                <div class="row g-3">
                                    <?php include '../fragments/products.php'; ?>
                                </div>
                            </div>
                            <!-- End Product Box -->
                        </div>
                    </div>
                </section>
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