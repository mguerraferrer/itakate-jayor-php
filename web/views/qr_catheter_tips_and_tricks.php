<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Catheter Tips and Tricks';
    $headlineTitle = 'Catheter Tips and Tricks';
    $sectionTitle = 'Catheter Tips and Tricks';
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
                <section class="section pb-0">
                    <div class="container">
                        <div class="row g-3">
                            <div class="col-md-12">
                                <div class="qr-video-wrapper">
                                    <video controls preload="metadata">
                                        <source src="../../assets/src/media/ejemplo_uso_cateter.mp4" type="video/mp4">
                                        Tu navegador no soporta la reproducción de video.
                                    </video>
                                </div>
                            </div>                            
                            <div class="col-md-12">
                                <h2>Guía de uso</h2>
                                <iframe class="pdf-container" src="../../assets/src/qrtmp/catheter_tips_and_tricks.pdf"></iframe>
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