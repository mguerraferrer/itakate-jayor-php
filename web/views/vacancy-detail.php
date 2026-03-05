<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    $code = $_GET['c'] ?? '';

    $vacancyController = new VacancyWebController();
    $vacancy = $vacancyController->getVacancy($code);

    if (empty($vacancy)) {
        // redirect to talent.php
        header('Location: talent.php');
        exit;
    }

    // Load reCAPTCHA configuration
    $recaptchaWebService = new RecaptchaWebService();
    $siteKey = $recaptchaWebService->getSiteKey();

    // Define viewsPath for use in fragments
    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Detalles de vacante';
    $headlineTitle = 'Talento';
    $sectionTitle = $vacancy['title'];
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
                        <div class="row align-items-stretch">
                            <div class="col-12" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <?php echo $vacancy['content']; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="section border-top">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8 offset-md-2 text-md-center">
                                <h1 class="headline-text text-jy-primary"
                                    data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
                                    Únete a nuestro equipo
                                </h1>
                                <p class="mt-5" data-aos="fade-right" data-aos-delay="300" data-aos-duration="1000">
                                    Queremos conocerte. Completa el formulario y da el primer paso para crecer con nosotros.
                                </p>
                            </div>
                            <div class="col-md-8 offset-md-2 mt-5" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
                                <form id="vacancyRequestForm" method="post" enctype="multipart/form-data"
                                      autocomplete="off" class="row g-3 pt-3">
                                    <div class="col-12">
                                        <div id="div-name" class="form-group">
                                            <label id="label-name" class="form-control-label" for="name">Nombre completo</label>
                                            <input id="name" type="text" name="name" class="form-control">
                                            <small id="small-name"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div id="div-email" class="form-group">
                                            <label id="label-email" class="form-control-label" for="email">Correo electrónico</label>
                                            <input id="email" type="text" name="email" class="form-control">
                                            <small id="small-email"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div id="div-phone" class="form-group">
                                            <label id="label-phone" class="form-control-label" for="phone">Teléfono / WhatsApp</label>
                                            <input id="phone" type="text" name="phone" class="form-control">
                                            <small id="small-phone"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div id="div-address" class="form-group">
                                            <label id="label-address" class="form-control-label" for="address">Alcaldía o Municipio donde radicas</label>
                                            <input id="address" type="text" name="address" class="form-control">
                                            <small id="small-address"></small>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div id="div-area" class="form-group">
                                            <label id="label-area" class="form-control-label" for="area">Área de interés (según tu perfil)</label>
                                            <select name="area" id="area" class="custom-select form-control">
                                                <option value="-">-- Seleccione --</option>
                                                <option value="com">Comercial</option>
                                                <option value="sal">Ventas - Compras</option>
                                                <option value="mar">Mercadotecnia - Finanzas</option>
                                                <option value="acc">Contabilidad - Logística</option>
                                                <option value="tra">Transporte - Operaciones</option>
                                                <option value="war">Almacén - Mantenimiento - Regulatorio</option>
                                                <option value="qua">Calidad - Recursos Humanos</option>
                                                <option value="bil">Capacitación - Facturación</option>
                                                <option value="col">Cobranza</option>
                                            </select>
                                            <small id="small-area"></small>
                                        </div>
                                    </div>
                                    <div id="div-resumeFile" class="col-12">
                                        <label id="label-resumeFile" class="form-control-label" for="resumeFile">
                                            Adjunta tu CV
                                        </label>
                                        <input type="file" id="resumeFile" name="resumeFile" class="form-control">
                                        <small id="small-resumeFile"></small>
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
                                                    <span class="btn-text">POSTÚLATE</span>
                                                    <span class="spinner-border spinner-border-sm d-none ms-2"></span>
                                                    <span class="processing-text d-none ms-2">Enviando...</span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
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
        <!-- Load reCAPTCHA script -->
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/vacancy-request.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-talent');
            });
        </script>
    </body>
</html>