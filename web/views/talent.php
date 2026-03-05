<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    $vacancyController = new VacancyWebController();
    $vacancies = $vacancyController->getActiveVacancies();

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Talento';
    $headlineTitle = 'Talento';
    $sectionTitle = 'Talento';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" href="../../assets/css/vacancy.css"/>
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
                        <div class="row">
                            <div class="col-md-8 offset-md-2 text-md-center">
                                <h1 class="headline-text text-jy-primary"
                                    data-aos="fade-down" data-aos-delay="300" data-aos-duration="1000">
                                    Únete a Jayor y construye salud con nosotros
                                </h1>
                                <p class="mt-5" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                    En Laboratorios Jayor no solo distribuimos insumos médicos: llevamos salud a cada rincón de México
                                    con productos de calidad, procesos certificados y un equipo comprometido con el bienestar.
                                </p>
                            </div>
                        </div>
                </section>
                <section class="section pb-0">
                    <div class="container">
                        <div class="row align-items-stretch">
                            <div class="col-lg-6 my-3" data-aos="fade-right" data-aos-delay="400" data-aos-duration="1000">
                                <img src="../../assets/src/talent/item-1.webp" alt="" title="" class="img-fluid">
                            </div>
                            <div class="col-lg-6 ps-lg-8 my-3" data-aos="fade-left" data-aos-delay="400" data-aos-duration="1000">
                                <p>
                                    En Jayor creemos firmemente que nuestro equipo es el motor de cada logro.
                                    Por eso, fomentamos un entorno laboral basado en el respeto, la integridad y
                                    la mejora continua. Contamos con <b>certificaciones ISO</b>, somos una <b>Empresa
                                        Socialmente Responsable</b> y orgullosamente parte de las empresas
                                    reconocidas como <b>Great Place to Work</b>.
                                </p>
                                <p>
                                    Aquí impulsamos el talento, la innovación y la calidad. Promovemos la
                                    capacitación constante, el desarrollo profesional y el equilibrio entre la vida
                                    laboral y personal. Sabemos que cuando nuestros colaboradores crecen,
                                    nuestra misión de llevar salud a cada comunidad se fortalece.
                                </p>
                                <p class="mb-0">
                                    Si compartes nuestra pasión por el cuidado de la salud y deseas formar parte
                                    de una organización sólida, responsable y humana, te invitamos a explorar
                                    nuestras vacantes y a construir con nosotros un México más saludable.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section">
                    <div class="container">
                        <div class="row" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                            <div class="col-12 text-center pb-5">
                                <a href="https://walink.co/lj8ojo" target="_blank" class="btn btn-jy-primary">
                                    NUESTRAS VACANTES
                                </a>
                            </div>
                            <div class="col-12 text-center pt-5">
                                <p>
                                    Consulta nuestras oportunidades laborales y forma parte del equipo Jayor. <br>
                                    <b>Juntos seguimos dejando huella en el camino de la salud.</b>
                                </p>
                            </div>
                        </div>
                        <?php include '../fragments/vacancies.php'; ?>
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
                setNavActive('header-nav-talent');
            });
        </script>
    </body>
</html>