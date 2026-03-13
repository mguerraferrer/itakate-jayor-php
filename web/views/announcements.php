<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Comunicados';
    $headlineTitle = 'Comunicados';
    $sectionTitle = 'Comunicados';
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
                <!-- Section -->
                <section class="section-pt">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <img src="../../assets/src/announcements/alerta-sanitaria-01.webp" alt="Comunicado" class="img-fluid mb-4"/>
                            </div>
                            <div class="col-md-12 mt-5">
                                <img src="../../assets/src/announcements/alerta-sanitaria-02.webp" alt="Comunicado" class="img-fluid mb-4"/>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- End Section -->
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-announcements');
            });
        </script>
    </body>
</html>