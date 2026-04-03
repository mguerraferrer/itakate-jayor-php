<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Sección Cotizador';
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
                                <div class="card card-border mb-3">
                                    <div class="card-body text-center">
                                        <span><b>Cotizaciones recibidas en <span id="user-dashboard-month"></span></b></span>
                                        <div class="dashboard-chart-circle mt-3">
                                            <div class="dashboard-percent-container mx-auto">
                                                <div class="dashboard-ab">
                                                    <div class="dashboard-cir">
                                                        <span id="user-dashboard-perc" class="dashboard-perc"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card card-border">
                                    <div class="card-body text-center">
                                        <span><b>Productos cotizados en <span id="product-dashboard-month"></span></b></span>
                                        <div class="dashboard-chart-circle mt-3">
                                            <div class="dashboard-percent-container mx-auto">
                                                <div class="dashboard-ab">
                                                    <div class="dashboard-cir">
                                                        <span id="product-dashboard-perc" class="dashboard-perc"></span>
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
                                        <ul class="nav nav-tabs">
                                            <li class="nav-item">
                                                <a class="nav-link active" data-bs-toggle="tab" data-bs-target="#user-tab-pane" type="button" role="tab" aria-controls="user-tab-pane" aria-selected="true">Usuarios</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" data-bs-toggle="tab" data-bs-target="#product-tab-pane" type="button" role="tab" aria-controls="product-tab-pane" aria-selected="false">Productos</a>
                                            </li>
                                        </ul>
                                        <div class="tab-style-1 ixx-tab-style-3">                                            
                                            <div class="tab-content">
                                                <div id="user-tab-pane" class="tab-pane fade in active show">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-7 form-group">
                                                            <div>
                                                                <label for="">Rango de fechas:</label>
                                                            </div>
                                                            <div id="user-date-range-container" class="input-group mb-3">                                                    
                                                                <input type="text" id="user-range-start-date" name="user-range-start-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha inicio">
                                                                <span class="input-group-text">hasta</span>
                                                                <input type="text" id="user-range-end-date" name="user-range-end-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha fin">
                                                                <button type="button" id="search-user-quotations" class="btn btn-info btn-search search">
                                                                    <i class="fas fa-search"></i> <span>Buscar</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive text-nowrap">
                                                        <table id="userTable" class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="6">Listado de usuarios que cotizaron</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Fecha</th>
                                                                    <th>Nombre</th>
                                                                    <th>Razón social</th>
                                                                    <th>Correo electrónico</th>
                                                                    <th>Folio</th>
                                                                    <th>Uso</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mt-3 text-end">
                                                        <a id="download-user-report" href="javascript:void(0)" class="btn btn-success d-none">
                                                            <i class="fas fa-download"></i> <span>Descargar reporte</span>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div id="product-tab-pane" class="tab-pane fade in">
                                                    <div class="row">
                                                        <div class="col-12 col-sm-7 form-group">
                                                            <div>
                                                                <label for="">Rango de fechas:</label>
                                                            </div>
                                                            <div id="product-date-range-container" class="input-group mb-3">                                                    
                                                                <input type="text" id="product-range-start-date" name="product-range-start-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha inicio">
                                                                <span class="input-group-text">hasta</span>
                                                                <input type="text" id="product-range-end-date" name="product-range-end-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha fin">
                                                                <button type="button" id="search-product-quotations" class="btn btn-info btn-search search">
                                                                    <i class="fas fa-search"></i> <span>Buscar</span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="table-responsive text-nowrap">
                                                        <table id="productTable" class="table table-striped">
                                                            <thead>
                                                                <tr>
                                                                    <th colspan="5">Listado de productos cotizados</th>
                                                                </tr>
                                                                <tr>
                                                                    <th>Fecha</th>
                                                                    <th>SKU</th>
                                                                    <th>Código</th>
                                                                    <th>Folio</th>
                                                                    <th>Cantidad</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody></tbody>
                                                        </table>
                                                    </div>
                                                    <div class="mt-3 text-end">
                                                        <a id="download-product-report" href="javascript:void(0)" class="btn btn-success d-none">
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
        <script src="../../assets/js/dashboard-quotation.js" type="text/javascript"></script>
    </body>
</html>