<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';

    $title = 'Laboratorio Jayor - Nuestro ADN';
    $headlineTitle = 'Nuestro ADN';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" type="text/css" href="../../assets/css/flip-animation-hover.css">
        <link rel="stylesheet" type="text/css" href="../../assets/css/mvv-cards.css">
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
                <section class="section-pt">
                    <div class="container">
                        <div class="row align-items-stretch">
                            <div class="col-lg-6 my-3" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <img src="../../assets/src/aboutus/item-1.webp" alt="" title="" class="img-fluid">
                            </div>
                            <div class="col-lg-6 ps-lg-8 my-3" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <h5 class="mb-4">Nuestra historia</h5>
                                <p>
                                    Grupo Jayor nació en 1991 con el deseo de apoyar a la Salud Mundial como
                                    distribuidores de dispositivos médicos, material de curación y medicamentos,
                                    siempre en pro de mejorar la calidad de vida de las personas.
                                </p>
                                <p>
                                    Laboratorios Jayor inició actividades en 2003 con los mejores productos,
                                    posicionándose tanto en el sector Público como en el Privado, cubriendo las
                                    necesidades de la gente en México.
                                </p>
                                <p>
                                    Con oficinas en todo el Continente Americano y un centro de distribución de
                                    más de 23,000 m2, abastecemos al mercado mexicano con productos
                                    importados de países como Brasil, Grecia, Egipto, Holanda, India, China y USA
                                    entre otros.
                                </p>
                                <p class="mb-0">
                                    Gracias a lo anterior, Laboratorios Jayor da empleo a cientos de mexicanos,
                                    haciendo que los planes de expansión y crecimiento sigan, siempre
                                    procurando por la salud y economía de la gente; para así poder construir un
                                    futuro que deje huella.
                                </p>
                            </div>
                            <div class="col-lg-6 my-3 h-100" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <h5 class="mb-4">Política de Calidad</h5>
                                <p>
                                    Laboratorios Jayor estamos enfocados en proveer productos para la salud con excelente
                                    calidad mediante la aplicación de procesos estandarizados, para la comercialización,
                                    almacenamiento y distribución de dispositivos médicos, medicamentos y demás insumos
                                    para la salud.
                                </p>
                                <p>
                                    Trabajamos en equipo para garantizar la prestación de un servicio de calidad consistente y
                                    de excelencia operativa, comprometidos en asegurar el apego a los estándares normativos
                                    y regulatorios aplicables a nuestro negocio.
                                </p>
                                <p class="mb-0">
                                    Mediante la implementación del sistema de gestión de calidad fortalecemos nuestro
                                    negocio, con enfoque a mejora continua para la satisfacción del cliente y el logro de
                                    nuestras metas para garantizar la calidad, servicio, disponibilidad y precio de nuestros
                                    productos.
                                </p>
                            </div>
                            <div class="col-lg-6 ps-lg-8 my-3 h-100" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <h5 class="mb-4">Objetivos de Calidad</h5>
                                <p>
                                    Establecer y revisar periódicamente indicadores de desempeño operativos que
                                    soporten la estrategia del negocio para identificar e implementar mejoras al
                                    sistema de gestión de calidad a través de la implementación de planes de
                                    acción en cumplimiento con la normatividad aplicable.
                                </p>
                                <p>
                                    Establecer y mejorar continuamente la gestión de procesos para garantizar
                                    que las operaciones cumplen los requisitos y expectativas de nuestros clientes
                                    y normatividad aplicable.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section pt-0">
                    <div class="row g-3 justify-content-center align-items-center">
                        <div class="col-12 col-md-6 ps-3 pe-3 ps-md-0 pe-md-0">
                            <div class="row g-3">
                                <div class="col-12 col-md-4" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                    <div id="flip-1" class="flip-container mvv-card mvv-card-mission"
                                         ontouchstart="this.classList.toggle('hover');" onclick="$('#flip-1').toggleClass('flip');">
                                        <div class="flipper h-100">
                                            <div class="front mvv-card-front w-100 h-100">
                                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                                    <div class="mvv-icon">
                                                        <img src="../../assets/src/aboutus/item-3.webp" alt="Misión" title="">
                                                    </div>
                                                    <h3 class="mvv-title">MISIÓN</h3>
                                                    <div class="d-block d-sm-none mt-5">
                                                        <p class="dp-text-yellow">
                                                            <i class="fa fa-sync"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="back w-100 h-100" style="padding: 40px 20px 40px 20px">
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <p class="text-start">
                                                        MISIÓN DE NEGOCIO
                                                        <br>
                                                        La razón de existir nos une.
                                                        <br><br>
                                                        Ser un proveedor confiable de productos para la salud,
                                                        ofreciendo excelente calidad, precios competitivos y un servicio
                                                        sobresaliente tanto en el sector público como en el privado.
                                                        <br><br>
                                                        Estamos comprometidos con la salud y el bienestar de los
                                                        consumidores, garantizando la disponibilidad, accesibilidad y
                                                        eficacia de nuestros productos.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                    <div id="flip-3" class="flip-container mvv-card mvv-card-vision"
                                         ontouchstart="this.classList.toggle('hover');" onclick="$('#flip-3').toggleClass('flip');">
                                        <div class="flipper h-100">
                                            <div class="front mvv-card-front w-100 h-100">
                                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                                    <div class="mvv-icon">
                                                        <img src="../../assets/src/aboutus/item-4.webp" alt="Visión" title="">
                                                    </div>
                                                    <h3 class="mvv-title">VISIÓN</h3>
                                                    <div class="d-block d-sm-none mt-5">
                                                        <p class="dp-text">
                                                            <i class="fa fa-sync"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="back w-100 h-100" style="padding: 40px 20px 40px 20px">
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <p class="text-start">
                                                        VISIÓN DE NEGOCIO
                                                        <br><br>
                                                        Fortalecer la relación comercial y las ventas con nuestros
                                                        clientes actuales mediante un portafolio de productos rentables,
                                                        así como posicionar nuestras marcas con nuevos clientes de
                                                        retail y cadenas de farmacias.
                                                        <br><br>
                                                        Nos encanta soñar,<br>
                                                        ¡allá vamos!
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                    <div id="flip-4" class="flip-container mvv-card mvv-card-values"
                                         ontouchstart="this.classList.toggle('hover');" onclick="$('#flip-4').toggleClass('flip');">
                                        <div class="flipper h-100">
                                            <div class="front mvv-card-front w-100 h-100">
                                                <div class="d-flex flex-column justify-content-center align-items-center h-100">
                                                    <div class="mvv-icon">
                                                        <img src="../../assets/src/aboutus/item-5.webp" alt="Valores" title="">
                                                    </div>
                                                    <h3 class="mvv-title">VALORES</h3>
                                                    <div class="d-block d-sm-none mt-5">
                                                        <p class="dp-text">
                                                            <i class="fa fa-sync"></i>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="back w-100 h-100">
                                                <div class="d-flex justify-content-center align-items-center h-100">
                                                    <p class="text-start">
                                                        VALORES ORGANIZACIONALES
                                                        <br><br>
                                                        Cualidades que marcarán nuestro camino.
                                                        <br><br>
                                                        . Respeto<br>
                                                        . Trabajo en equipo<br>
                                                        . Ética<br>
                                                        . Compromiso organizacional<br>
                                                        . Orientación a resultados
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section pt-0" id="certifications">
                    <div class="container">
                        <div class="row" data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
                            <div class="col-md-8 offset-md-2 text-md-center">
                                <h5 class="mb-4 h5">Certificaciones</h5>
                                <p>
                                    Compromiso que se demuestra con hechos
                                </p>
                                <p>
                                    En Laboratorios Jayor sabemos que la calidad, la ética y la responsabilidad no se dicen: se demuestran.
                                    Por eso, obtener certificaciones no es solo un requisito, sino un reflejo de nuestro compromiso constante por hacer las cosas bien.
                                    Cada certificación representa un paso más en la mejora continua, una garantía para nuestros clientes
                                    y un orgullo para nuestro equipo. Creemos en trabajar con altos estándares porque eso se traduce en confianza,
                                    seguridad y valor para todos los que forman parte de nuestra cadena.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-2 pb-3 pb-md-0 offset-md-2 text-center"
                                 data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <img src="../../assets/src/badge/jayor-great-place.webp" alt="" title="">
                            </div>
                            <div class="col-12 col-md-5 ps-lg-8 d-flex align-items-center text-start"
                                 data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <div>
                                    <h3 class="mb-4 h5">
                                        GPW 2025 <br>
                                        Construyendo lugares de trabajo increíbles
                                    </h3>
                                    <p>
                                        Ser reconocidos por Great Place to Work (GPW) no es únicamente un sello: es el reflejo
                                        de una cultura laboral sólida, humana y auténtica. En Jayor, creemos que las personas
                                        son el motor de todo lo que hacemos, y por eso impulsamos entornos donde se valora la
                                        confianza, la comunicación y el crecimiento profesional.
                                    </p>
                                    <p>
                                        Obtener el distintivo GPW 2025 confirma que nuestro compromiso con el bienestar,
                                        el respeto y la integridad se vive todos los días, fortaleciendo relaciones y
                                        generando orgullo de pertenencia. Porque aquí, cada voz cuenta, cada talento suma y
                                        <b>juntos dejamos huella</b>, construyendo un lugar donde trabajar se convierte en motivo de inspiración.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-2 pb-3 pb-md-0 offset-md-2 text-center"
                                 data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <img src="../../assets/src/badge/jayor-esr.webp" alt="" title="">
                            </div>
                            <div class="col-12 col-md-5 ps-lg-8 d-flex align-items-center text-start"
                                 data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <div>
                                    <h3 class="mb-4 h5">
                                        ESR 2025 <br>
                                        Responsabilidad que deja huella
                                    </h3>
                                    <p>
                                        Ser Empresa Socialmente Responsable (ESR) no es solo un distintivo: es una forma de ser.
                                        En Jayor, asumimos con convicción el compromiso de generar un impacto positivo en nuestra
                                        comunidad, nuestro entorno y nuestra gente.
                                    </p>
                                    <p>
                                        La obtención del distintivo ESR 2025 reafirma que nuestros esfuerzos en temas éticos,
                                        sociales y ambientales están alineados con las mejores prácticas. Desde el respeto a
                                        los derechos humanos hasta la promoción del desarrollo sostenible, trabajamos para
                                        ser una empresa que no solo crece, sino que también suma.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-6 col-md-2 pb-3 pb-md-0 offset-md-2 text-center"
                                 data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <img src="../../assets/src/badge/jayor-iso.webp" alt="" title="">
                            </div>
                            <div class="col-12 col-md-5 ps-lg-8 d-flex align-items-center text-start"
                                 data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <div>
                                    <h3 class="mb-4 h5">
                                        ISO 9001:2015 <br>
                                        Calidad con respaldo internacional
                                    </h3>
                                    <p>
                                        La calidad no es una meta, es un proceso diario. Por eso, en Jayor
                                        trabajamos bajo un Sistema de Gestión de Calidad certificado bajo la
                                        norma ISO 9001:2015, lo que asegura que cada uno de nuestros procesos
                                        están enfocados en la mejora continua, la eficiencia operativa y la
                                        satisfacción de nuestros clientes. Esta certificación internacional respalda
                                        que nuestras operaciones cumplen con los más altos estándares,
                                        garantizando productos y servicios confiables en cada paso.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <section id="global-presence" class="py-12 bg-cover bg-center bg-no-repeat"
                         style="background-image: url('../../assets/src/aboutus/item-2.webp');"
                         data-aos="zoom-in" data-aos-delay="300" data-aos-duration="1000">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 col-xl-5">
                                <div class="p-5 p-xl-6">
                                    <h4>Jayor sin fronteras</h4>
                                    <p>
                                        En Grupo Jayor y Laboratorios Jayor México
                                        contamos con oficinas y centros de distribución
                                        en todo el continente Americano, donde
                                        abastecemos al mercado con productos
                                        importados de países como Brasil, Grecia, Egipto,
                                        Holanda, India, China y E.E. U.U. entre otros.
                                    </p>
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
                setNavActive('header-nav-about-us');
            });
        </script>
    </body>
</html>