<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Sección Productos';
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
                            <div class="col-12 mb-5">
                                <div class="card">
                                    <div class="card-body">
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#general-tab-pane" type="button" role="tab" aria-controls="general-tab-pane" aria-selected="true">Top 10 general</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#monthly-tab-pane" type="button" role="tab" aria-controls="monthly-tab-pane" aria-selected="false">Top 10 mensual</a>
                                            </li>
                                        </ul>
                                        <div class="tab-style-1 ixx-tab-style-3">                                            
                                            <div class="tab-content">
                                                <div id="general-tab-pane" class="tab-pane fade in active show">
                                                    <div class="table-responsive text-nowrap">
                                                        <table id="productsTopTenGeneralTable" class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="5">Top 10 productos más cotizados general</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>SKU</th>
                                                                    <th class="text-center">Código</th>
                                                                    <th class="text-center">Línea</th>
                                                                    <th class="text-center">Marca</th>
                                                                    <th class="text-center">Cantidades (piezas)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mt-3 text-end">
                                                        <a id="download-general-report" href="javascript:void(0)" class="btn btn-success d-none">
                                                            <i class="fas fa-download"></i> <span>Descargar reporte</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div id="monthly-tab-pane" class="tab-pane fade in">
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
                                                    <div class="table-responsive text-nowrap">
                                                        <table id="productsTopTenMonthlyTable" class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="5">Top 10 productos más cotizados mensualmente</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>SKU</th>
                                                                    <th class="text-center">Código</th>
                                                                    <th class="text-center">Línea</th>
                                                                    <th class="text-center">Marca</th>
                                                                    <th class="text-center">Cantidades (piezas)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mt-3 text-end">
                                                        <a id="download-monthly-report" href="javascript:void(0)" class="btn btn-success d-none">
                                                            <i class="fas fa-download"></i> <span>Descargar reporte</span>
                                                        </a>
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
        <script src="../../assets/js/dashboard-product.js" type="text/javascript"></script>
    </body>
</html>