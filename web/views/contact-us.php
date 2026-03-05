<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    // Load reCAPTCHA configuration
    $recaptchaWebService = new RecaptchaWebService();
    $siteKey = $recaptchaWebService->getSiteKey();

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Contacto';
    $headlineTitle = 'Contacto';
    $sectionTitle = 'Contacto';
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
                <!-- Contact us -->
                <section class="section">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-6 my-3 pe-lg-8" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <h4 class="mb-2 h4">Gracias por confiar en Jayor.</h4>
                                <p class="fw-400">
                                    Cada mensaje que recibimos nos impulsa a seguir trabajando con calidad,
                                    responsabilidad y compromiso con la salud.
                                </p>
                                <form id="contactForm" method="post" autocomplete="off" class="row g-3 pt-3">
                                    <div class="col-md-6">
                                        <div id="div-name" class="form-group">
                                            <input id="name" type="text" name="name" placeholder="Nombre" class="form-control" data-required="true">
                                            <small id="small-name"></small>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div id="div-email" class="form-group">
                                            <input id="email" type="text" name="email" placeholder="Correo" class="form-control" data-required="true">
                                            <small id="small-email"></small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="div-subject" class="form-group">
                                            <input id="subject" type="text" name="subject" placeholder="Asunto" class="form-control" data-required="true">
                                            <small id="small-subject"></small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div id="div-comments" class="form-group">
                                            <textarea class="form-control" id="comments" name="comments" placeholder="Comentarios" rows="5" style="resize: none;" data-required="true"></textarea>
                                            <small id="small-comments"></small>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-start">
                                            <!-- reCAPTCHA v2 -->
                                            <div id="recaptcha-container" class="mb-10 form-group">
                                                <div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($siteKey); ?>" data-callback="onRecaptchaSuccess"></div>
                                                <small id="small-recaptcha-container"></small>
                                            </div>
                                            <div>
                                                <button type="button" class="btn btn-jy-primary w-100 w-md-auto" id="sendBtn">
                                                    <span class="btn-text">ENVIAR</span>
                                                    <span class="spinner-border spinner-border-sm d-none ms-2"></span>
                                                    <span class="processing-text d-none ms-2">Enviando...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 my-3" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <div class="ratio ratio-16x9">
                                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3760.9032429068634!2d-99.1958274852954!3d19.502798186844526!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f87c692af8f3%3A0xd9f27af5bcadb84e!2sLaboratorios%20Jayor!5e0!3m2!1ses!2smx!4v1582867760714!5m2!1ses!2smx"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <div class="section pt-0 mt-0">
                    <div class="container">
                        <div class="row g-4">
                            <div class="col-lg-3 col-sm-6" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="contact-icon mb-3">
                                            <img src="../../assets/src/contact/phone.webp" title="" alt="Teléfono Jayor">
                                        </div>
                                        <div class="fs-small">
                                            <a class="text-secondary" href="tel:015553196961">
                                                55 5319 6961 • Opción 1
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="contact-icon mb-3">
                                            <img src="../../assets/src/contact/mail.webp" title="" alt="Correo electrónico Jayor">
                                        </div>
                                        <div class="fs-small">
                                            <a class="text-secondary" href="mailto:experienciaalcliente@jayor.com.mx">
                                                experienciaalcliente@jayor.com.mx
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="contact-icon mb-3">
                                            <img src="../../assets/src/contact/location.webp" title="" alt="Dirección Jayor">
                                        </div>
                                        <div class="fs-small">
                                            <p class="mb-0 text-reset">
                                                Calz. de los Angeles 303-Bodega 3A, <br>
                                                San Martin Xochinahuac, Azcapotzalco, <br>
                                                02120 Ciudad de México, CDMX
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <div class="contact-icon mb-3">
                                            <img src="../../assets/src/contact/social.webp" title="" alt="Social Jayor">
                                        </div>
                                        <div class="nav dark-link d-flex justify-content-between w-100 mt-4">
                                            <a class="contact-social" href="https://www.facebook.com/laboratorios.jayor/" target="_blank">
                                                <img src="../../assets/src/social/facebook.webp" title="" alt="Facebook Jayor">
                                            </a>
                                            <a class="contact-social" href="https://www.youtube.com/channel/UCwwarkvH0DBYBt87r3faHdw/videos" target="_blank">
                                                <img src="../../assets/src/social/youtube.webp" title="" alt="Youtube Jayor">
                                            </a>
                                            <a class="contact-social" href="https://www.linkedin.com/company/laboratorios-jayor/" target="_blank">
                                                <img src="../../assets/src/social/linkedin.webp" title="" alt="Linkedin Jayor">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <!-- Load reCAPTCHA script -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/contact-us.js" type="text/javascript"></script>
    </body>
</html>