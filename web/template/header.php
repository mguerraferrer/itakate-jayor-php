<!-- Header -->
<header class="header-main bg-mode-re header-light fixed-top header-height header-option-1">
    <!-- Header Top -->
    <div class="header-top small bg-jy-blue pt-1 pb-1 small">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <!-- Left -->
                <div class="d-flex align-items-center justify-content-center d-none d-lg-block">
                    <ul class="nav white-link">
                        <li class="nav-item">
                            <a href="tel:015553196961" class="navbar-link">
                                <i class="bi bi-telephone me-2"></i> 55 5319 6961 • Opción 1
                            </a>
                        </li>
                    </ul>
                </div>
                <!-- Right -->
                <div class="d-flex align-items-center justify-content-center w-100 w-lg-auto">
                    <div class="ms-0 w-100 d-block d-md-none text-start">
                        <ul class="nav white-link">
                            <li class="nav-item">
                                <a href="tel:015553196961" class="navbar-link">
                                    <i class="bi bi-telephone me-2"></i> 55 5319 6961 • Opción 1
                                </a>
                            </li>
                        </ul>
                    </div>
                    <!-- Top social -->
                    <div class="nav header-social justify-content-end d-none d-lg-block white-link">
                        <a class="h-social-link" href="https://www.facebook.com/laboratorios.jayor/" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/facebook-w.webp" title="" alt="Facebook Jayor">
                        </a>
                        <a class="h-social-link" href="https://www.youtube.com/channel/UCwwarkvH0DBYBt87r3faHdw/videos" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/youtube-w.webp" title="" alt="Youtube Jayor">
                        </a>
                        <a class="h-social-link" href="https://www.linkedin.com/company/laboratorios-jayor/" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/linkedin-w.webp" title="" alt="Linkedin Jayor">
                        </a>
                        <a class="h-social-link" href="https://api.whatsapp.com/message/454WIVFMWCYSG1" target="_blank">
                            <img src="<?php echo $assetsPath; ?>assets/src/social/whatsapp-w.webp" title="" alt="WhatsApp Jayor">
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Top -->
    <nav class="navbar navbar-expand-lg navbar-light d-none d-lg-flex">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="<?php echo $rootPath; ?>">
                <img class="logo-dark h-logo" src="<?php echo $assetsPath; ?>assets/src/header/jayor-logo.webp" title="" alt="Jayor Logo">
            </a>
            <!-- Logo -->
            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a id="header-nav-about-us" href="<?php echo $viewsPath; ?>about-us" class="nav-link">Nuestro ADN</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-product" href="<?php echo $viewsPath; ?>lines" class="nav-link">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-tracker" href="<?php echo $viewsPath; ?>tracker" class="nav-link">Rastrea tu pedido</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-outlet" href="<?php echo $viewsPath; ?>outlet" class="nav-link">Outlet</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-pharmaco-vigilance" href="<?php echo $viewsPath; ?>pharmaco-vigilance" class="nav-link">Farma y Tecno</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-talent" href="<?php echo $viewsPath; ?>talent" class="nav-link">Talento</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-contact-us" href="<?php echo $viewsPath; ?>contact-us" class="nav-link">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a id="header-nav-announcements" href="<?php echo $viewsPath; ?>announcements" class="nav-link">Comunicados</a>
                    </li>
                </ul>
            </div>
            <!-- End Menu -->
            <div class="nav flex-nowrap align-items-center header-right">
                <div class="nav-item d-none">
                    <a class="nav-link collapsed" data-bs-toggle="collapse"
                       href="javascript:void(0)" data-bs-target="#search-open" aria-expanded="false">
                        <img class="h-icon" src="<?php echo $assetsPath; ?>assets/src/header/search.webp" title="" alt="Buscar">
                    </a>
                </div>
                <div class="nav-item">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#modalMiniCart" role="button" aria-controls="modalMiniCart">
                        <?php
                            $itemsCount = $quotationSession->getItemsCount();
                        ?>
                        <span class="quotation-badge" data-cart-items="<?php echo $itemsCount; ?>">
                            <img class="h-icon" src="<?php echo $assetsPath; ?>assets/src/header/item-1.webp" title="Cotizar" alt="">
                        </span>
                    </a>
                </div>
                <!-- Cart -->
                <div class="nav-item">
                    <a class="nav-link" href="<?php echo $assetsPath; ?>assets/src/catalogue/catalogo-jayor.pdf" target="_blank">
                        <img class="h-icon" src="<?php echo $assetsPath; ?>assets/src/header/item-2.webp" title="Descargar catálogo" alt="">
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile Menu -->
    <div class="mobile-header-01 d-lg-none">
        <div class="mob-head-in">
            <div class="mob-toggle">
                <button class="hm-toggle-mob" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvas_mobile_header_01" aria-controls="offcanvas_mobile_header_01">
                    <span></span>
                </button>
            </div>
            <div class="mob-logo text-center w-100 d-flex justify-content-center">
                <a href="<?php echo $rootPath; ?>">
                    <img class="logo-dark h-logo" src="<?php echo $assetsPath; ?>assets/src/header/jayor-logo.webp" title="" alt="Jayor Logo">
                </a>
            </div>
            <div class="mob-end">
                <!-- Cart -->
                <div class="nav-item">
                    <a class="nav-link" data-bs-toggle="offcanvas" href="#modalMiniCart" role="button" aria-controls="modalMiniCart">
                            <span class="quotation-badge" data-cart-items="<?php echo $itemsCount; ?>">
                                <img class="h-icon" src="<?php echo $assetsPath; ?>assets/src/header/item-2.webp" title="" alt="">
                            </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- End Mobile Menu -->
</header>
<!-- Mobile Bottom -->
<!-- Mobile  -->
<div class="offcanvas-lg mobile-nav-offcanvas offcanvas-start d-lg-none @@MobExtraClass" tabindex="-1" id="offcanvas_mobile_header_01" aria-labelledby="offcanvas_mobile_header_01">
    <div class="offcanvas-header">
        <div class="offcanvas-header-overlay"></div>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#offcanvas_mobile_header_01" aria-label="Close">
            <i class="fi-x"></i>
        </button>
    </div>
    <div class="offcanvas-body">
        <ul class="navbar-nav mx-auto">
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>about-us" class="nav-link">Nuestro ADN</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>lines" class="nav-link">Productos</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>tracker" class="nav-link">Rastrea tu pedido</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>outlet" class="nav-link">Outlet</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>pharmaco-vigilance" class="nav-link">Farma y Tecno</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>talent" class="nav-link">Talento</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>contact-us" class="nav-link">Contacto</a>
            </li>
            <li class="nav-item">
                <a href="<?php echo $viewsPath; ?>announcements" class="nav-link">Comunicados</a>
            </li>
        </ul>
    </div>
</div>
<!-- End Mobile Bottom --><!-- End Header -->
