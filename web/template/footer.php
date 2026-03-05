<?php
    if (!isset($assetsPath)) {
        $assetsPath = '../../';
    }

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }
?>

<footer class="bg-mode-re footer border-top">
    <div class="footer-top py-6">
        <div class="container">
            <div class="row">
                <div class="col-sm-6 col-lg-4 my-3">
                    <div class="pb-3">
                        <img class="logo-dark" style="width: 40%"
                             src="<?php echo $assetsPath; ?>assets/src/footer/jayor-logo.webp" title="" alt="Logo Jayor">
                    </div>
                    <address class="dark-link mb-4">
                        <p class="mb-2">
                            <a class="border-bottom border-secondary" href="tel:015553196961">55 5319 6961 • Opción 1</a>
                        </p>
                        <p class="mb-2">
                            <a class="border-bottom border-secondary" href="mailto:experienciaalcliente@jayor.com.mx">
                                experienciaalcliente@jayor.com.mx
                            </a>
                        </p>
                        <p class="mb-2">
                            <a class="border-bottom border-secondary" href="<?php echo $viewsPath; ?>integrity">
                                Integridad y cumplimiento
                            </a>
                        </p>
                        <p class="mb-2">
                            <a class="border-bottom border-secondary" href="<?php echo $viewsPath; ?>privacy-notice">
                                Aviso de privacidad
                            </a>
                        </p>
                    </address>
                    <div class="nav dark-link fs-5">
                        <a class="me-3 me-md-5 social" href="https://www.facebook.com/laboratorios.jayor/" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/facebook.webp" title="" alt="Facebook Jayor">
                        </a>
                        <a class="me-3 me-md-5 social" href="https://www.youtube.com/channel/UCwwarkvH0DBYBt87r3faHdw/videos" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/youtube.webp" title="" alt="Youtube Jayor">
                        </a>
                        <a class="me-3 me-md-5 social" href="https://www.linkedin.com/company/laboratorios-jayor/" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/linkedin.webp" title="" alt="Linkedin Jayor">
                        </a>
                        <a class="me-3 me-md-5 social" href="https://api.whatsapp.com/message/454WIVFMWCYSG1" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/whatsapp.webp" title="" alt="WhatsApp Jayor">
                        </a>
                    </div>
                </div>
                <div class="col-sm-6 col-lg-8 my-3 text-end">
                    <img src="<?php echo $assetsPath; ?>assets/src/badge/jayor-badges-2.webp" title="" alt="Badges Jayor">
                </div>
            </div>
        </div>
    </div>
    <div class="footer-bottom py-4 border-top small">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center py-1">
                    <p class="m-0"><?php echo date('Y'); ?>. Derechos Reservados. Laboratorios Jayor S.A de C.V.</p>
                </div>
            </div>
        </div>
    </div>
</footer>
<!-- WhatsApp Float Button -->
<a href="https://api.whatsapp.com/message/454WIVFMWCYSG1" class="whatsapp-float-button" data-rel="social-W" target="_blank">
    <img src="<?php echo $assetsPath; ?>assets/src/social/whatsapp-float-btn.webp" title="" alt="WhatsApp Jayor">
</a>
<!-- End WhatsApp Float Button -->
