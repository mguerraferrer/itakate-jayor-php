<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Sección Farmacovigilancia';
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
                <section class="section-pt">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-3 mb-5">
                                <div class="card card-border">
                                    <div class="card-body text-center">
                                        <span><b>Reportes recibidos en <span id="dashboard-month"></span></b></span>
                                        <div class="dashboard-chart-circle mt-3">
                                            <div class="dashboard-percent-container mx-auto">
                                                <div class="dashboard-ab">
                                                    <div class="dashboard-cir">
                                                        <span id="dashboard-perc" class="dashboard-perc"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-9 mb-5">
                                <div class="card card-border">
                                    <div class="card-body">
                                        <div class="row">
                                            <div id="div-monthYear" class="col-12 col-md-6 mb-3 form-group">
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
                                        <div class="table-responsive text-nowrap">
                                            <table id="pharmaTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th colspan="5">Reportes realizados</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Nombre</th>
                                                        <th>Correo electrónico</th>
                                                        <th>Teléfono</th>
                                                        <th>Tipo</th>
                                                        <th>Fecha</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
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
        <script src="../../assets/js/dashboard-pharma.js" type="text/javascript"></script>
    </body>
</html>