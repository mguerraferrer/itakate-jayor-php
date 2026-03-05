<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Rastrea tu pedido';
    $headlineTitle = 'Rastrea tu pedido';
    $sectionTitle = 'Rastrea tu pedido';
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
                <section class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6 offset-md-3 text-md-center">
                                <h4 class="h4" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1000">
                                    Rastrea tu pedido
                                </h4>
                                <div data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                    <p class="mt-5 mb-0">
                                        Para conocer el estatus de tu pedido, comunícate al <b>55 5319 6961</b> y selecciona la Opción 1.
                                    </p>
                                    <p class="mb-0">
                                        Nuestro equipo te brindará la información actualizada de tu entrega.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="py-15 bg-cover bg-center bg-no-repeat"
                         style="background-image: url('../../assets/src/tracker/item-1.webp')"
                         data-aos="zoom-in" data-aos-delay="400" data-aos-duration="1000">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-4">
                                <div class="bg-mode-re p-3 p-xl-4">
                                    <h4>Rastree su Envío</h4>
                                    <div class="d-md-flex align-items-md-end">
                                        <div class="col-12 col-md-6 me-md-3 pb-5 pb-md-0">
                                            <a class="btn btn-jy-ocean w-100" href="https://wa.link/f5x1p0" target="_blank">
                                                Escribe ahora
                                            </a>
                                        </div>
                                        <div class="col-12 col-md-6 home-tracking text-center">
                                            <img src="../../assets/src/tracker/item-2.webp" alt="" title="">
                                        </div>
                                    </div>
                                </div>
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
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-tracker');
            });
        </script>
    </body>
</html>