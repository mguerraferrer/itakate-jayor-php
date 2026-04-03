<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Sección Redes Sociales';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" type="text/css" href="../../assets/css/admin-dashboard.css">
        <!-- Bootstrap Datepicker -->        
        <link rel="stylesheet" href="../../assets/vendor/datepicker/datepicker-bs5.min.css">
        <link rel="stylesheet" href="../../assets/css/datepicker.custom.css">
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
                <?php include '../fragments/admin-page-info.php'; ?>
                <?php include '../fragments/admin-user-info.php'; ?>
                <section class="section-pt mt-5 mt-md-0">
                    <div class="container">                        
                        <div class="row counter">
                            <div class="col-6 col-md-4 col-lg mb-3">
                                <div class="counter-col-02 d-flex justify-content-center">
                                    <div class="cc-icon">
                                        <i class="fab fa-facebook theme-color"></i>
                                    </div>
                                    <div class="count-data">
                                        <div id="facebook-count" class="count dark-color"></div>
                                        <h6>Visitas</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg mb-3">
                                <div class="counter-col-02 d-flex justify-content-center">
                                    <div class="cc-icon">
                                        <i class="fab fa-whatsapp theme-color"></i>
                                    </div>
                                    <div class="count-data">
                                        <div id="whatsapp-count" class="count dark-color"></div>
                                        <h6>Clicks</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg mb-3">
                                <div class="counter-col-02 d-flex justify-content-center">
                                    <div class="cc-icon">
                                        <i class="fab fa-linkedin-in theme-color"></i>
                                    </div>
                                    <div class="count-data">
                                        <div id="linkedin-count" class="count dark-color"></div>
                                        <h6>Visitas</h6>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4 col-lg mb-3">
                                <div class="counter-col-02 d-flex justify-content-center">
                                    <div class="cc-icon">
                                        <i class="fab fa-youtube theme-color"></i>
                                    </div>
                                    <div class="count-data">
                                        <div id="youtube-count" class="count dark-color"></div>
                                        <h6>Visitas</h6>
                                    </div>
                                </div>
                            </div>
                        </div>                       
                    </div>
                </section>
                <section class="section pt-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <div class="card card-border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div id="div-monthYear" class="col-12 col-md-4 mb-3 form-group">
                                                <label for="monthYear" class="form-label">Mes/Año:</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="monthYear" name="monthYear" aria-describedby="monthYear-addon">                                                                
                                                    <button type="button" class="btn btn-info btn-search search">
                                                        <i class="fas fa-search"></i> <span>Buscar</span>
                                                    </button>
                                                </div>
                                                <small id="small-monthYear"></small>
                                            </div>
                                        </div>
                                        <div class="row mt-5">
                                            <div class="col-lg col-sm-6 mb-3">
                                                <div class="hover-top-in text-center">
                                                    <div class="avatar-50 border-radius-50 d-inline-block border-all-5 border-color-white position-relative z-index-1 box-shadow">
                                                        <i class="fab fa-facebook i-color" style="margin-top: 4px;"></i>
                                                    </div>
                                                    <div class="m-10px-lr box-shadow border-radius-15 mt-n5 white-bg p-65px-t p-25px-b p-15px-lr text-center hover-top--in">
                                                        <h1 class="m-5px-b" id="social-f"></h1>
                                                        <h6 class="text-muted">Visitas</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 mb-3">
                                                <div class="hover-top-in text-center">
                                                    <div class="avatar-50 border-radius-50 d-inline-block border-all-5 border-color-white position-relative z-index-1 box-shadow">
                                                        <i class="fab fa-whatsapp i-color" style="margin-top: 1px;"></i>
                                                    </div>
                                                    <div class="m-10px-lr box-shadow border-radius-15 mt-n5 white-bg p-65px-t p-25px-b p-15px-lr text-center hover-top--in">
                                                        <h1 class="m-5px-b" id="social-w"></h1>
                                                        <h6 class="text-muted">Clicks</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 mb-3">
                                                <div class="hover-top-in text-center">
                                                    <div class="avatar-50 border-radius-50 d-inline-block border-all-5 border-color-white position-relative z-index-1 box-shadow">
                                                        <i class="fab fa-linkedin-in i-color" style="margin-top: 5px;"></i>
                                                    </div>
                                                    <div class="m-10px-lr box-shadow border-radius-15 mt-n5 white-bg p-65px-t p-25px-b p-15px-lr text-center hover-top--in">
                                                        <h1 class="m-5px-b" id="social-l"></h1>
                                                        <h6 class="text-muted">Visitas</h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg col-sm-6 mb-3">
                                                <div class="hover-top-in text-center">
                                                    <div class="avatar-50 border-radius-50 d-inline-block border-all-5 border-color-white position-relative z-index-1 box-shadow">
                                                        <i class="fab fa-youtube i-color" style="margin-top: 5px;"></i>
                                                    </div>
                                                    <div class="m-10px-lr box-shadow border-radius-15 mt-n5 white-bg p-65px-t p-25px-b p-15px-lr text-center hover-top--in">
                                                        <h1 class="m-5px-b" id="social-y"></h1>
                                                        <h6 class="text-muted">Visitas</h6>
                                                    </div>
                                                </div>
                                            </div>
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
        <!-- Bootstrap Datepicker -->
        <script src="../../assets/vendor/datepicker/datepicker-full.min.js" type="text/javascript"></script>
        <script src="../../assets/vendor/datepicker/datepicker-full-es.js" type="text/javascript"></script>
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/dashboard-social.js" type="text/javascript"></script>
    </body>
</html>