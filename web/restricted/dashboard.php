<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Dashboard Administrativo';
    $showBackButton = false;
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" type="text/css" href="../../assets/css/admin-dashboard.css">
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
                <?php include '../fragments/admin-page-info.php'; ?>
                <?php include '../fragments/admin-user-info.php'; ?>
                <section class="section-pt">
                    <div class="container">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <a href="dashboard-contact" class="dashboard-a">
                                    <div class="dashboard-box text-center">
                                        <div class="dashboard-box-icon-container">
                                            <div class="dashboard-box-icon">
                                                <i class="fas fa-envelope-open-text"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="h6">Sección Contacto</h5>
                                            <p>Dashboard administrativo de la sección de Contactos</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="dashboard-quotation" class="dashboard-a">
                                    <div class="dashboard-box text-center">
                                        <div class="dashboard-box-icon-container">
                                            <div class="dashboard-box-icon">
                                                <i class="fas fa-box-usd"></i>
                                            </div>
                                        </div>
                                        <div>
                                            <h5 class="h6">Sección Cotizador</h5>
                                            <p>Dashboard administrativo de la sección Cotizador</p>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="dashboard-product" class="dashboard-a">
                                    <div class="dashboard-box text-center">
                                        <div class="dashboard-box-icon-container">
                                            <div class="dashboard-box-icon">
                                                <i class="fas fa-cubes"></i>
                                            </div>
                                        </div>
                                        <h5 class="h6">Sección Productos</h5>
                                        <p>Dashboard administrativo de la sección de Productos</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="dashboard-pharma" class="dashboard-a">
                                    <div class="dashboard-box text-center">
                                        <div class="dashboard-box-icon-container">
                                            <div class="dashboard-box-icon">
                                                <i class="fas fa-file-medical"></i>
                                            </div>
                                        </div>
                                        <h5 class="h6">Sección Farmacovigilancia</h5>
                                        <p>Dashboard administrativo de la sección de Farmacovigilancia</p>
                                    </div>
                                </a>
                            </div>
                            <div class="col-md-4">
                                <a href="dashboard-social" class="dashboard-a">
                                    <div class="dashboard-box text-center">
                                        <div class="dashboard-box-icon-container">
                                            <div class="dashboard-box-icon">
                                                <i class="fas fa-share-alt"></i>
                                            </div>
                                        </div>
                                        <h5 class="h6">Sección Redes Sociales</h5>
                                        <p>Dashboard administrativo de la sección de Redes Sociales</p>
                                    </div>
                                </a>
                            </div>
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
    </body>
</html>