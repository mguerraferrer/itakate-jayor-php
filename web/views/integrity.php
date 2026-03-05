<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Integridad y cumplimiento';
    $headlineTitle = 'Integridad y cumplimiento';
    $sectionTitle = 'Integridad y cumplimiento';
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
                                <h2>Código de ética</h2>
                                <iframe class="pdf-container" src="../../assets/src/integrity/jayor-codigo-etica.pdf"></iframe>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h2>Código de ética para terceros</h2>
                                <iframe class="pdf-container" src="../../assets/src/integrity/jayor-codigo-etica-terceros.pdf"></iframe>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h2>Política de anticorrupción</h2>
                                <iframe class="pdf-container" src="../../assets/src/integrity/jayor-politica-anticorrupcion.pdf"></iframe>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h2>Política de recepción y otorgamiento de regalos</h2>
                                <iframe class="pdf-container" src="../../assets/src/integrity/jayor-politica-recepcion-otorgamiento-regalos.pdf"></iframe>
                            </div>
                            <div class="col-md-12 mt-5">
                                <h2>Política de conflicto de interés</h2>
                                <iframe class="pdf-container" src="../../assets/src/integrity/jayor-politica-conflicto-interes.pdf"></iframe>
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