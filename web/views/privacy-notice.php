<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Aviso de privacidad';
    $headlineTitle = 'Aviso de privacidad';
    $sectionTitle = 'Avisos de privacidad';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <style>
            .pdf-container {
                width: 100%;
                height: 600px;
                margin-bottom: 20px;
                border: 1px solid #ccc;
            }
        </style>
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
                                <h2>Aviso de privacidad clientes</h2>
                                <iframe class="pdf-container" src="../../assets/src/privacynotice/aviso-privacidad-clientes.pdf"></iframe>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h2>Aviso de privacidad proveedores</h2>
                                <iframe class="pdf-container" src="../../assets/src/privacynotice/aviso-privacidad-proveedores.pdf"></iframe>
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
    </body>
</html>