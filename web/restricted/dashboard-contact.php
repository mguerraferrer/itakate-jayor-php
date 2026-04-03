<?php
    require_once '../auth/auth_handler.php';
    require_once '../auth/admin_handler.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';

    $title = 'Laboratorio Jayor - Dashboard';
    $headlineTitle = 'Sección Contacto';
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
                                        <span><b>Mensajes recibidos en <span id="dashboard-month"></span></b></span>
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
                                            <div class="col-12 col-sm-7 form-group">
                                                <div>
                                                    <label for="">Rango de fechas:</label>
                                                </div>
                                                <div id="date-range-container" class="input-group mb-3">                                                    
                                                    <input type="text" id="range-start-date" name="range-start-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha inicio">
                                                    <span class="input-group-text">hasta</span>
                                                    <input type="text" id="range-end-date" name="range-end-date" class="form-control" placeholder="dd/mm/yyyy" aria-label="Fecha fin">
                                                    <button type="button" class="btn btn-info btn-search search">
                                                        <i class="fas fa-search"></i> <span>Buscar</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive text-nowrap">
                                            <table id="contactsTable" class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3">Listado de usuarios</th>
                                                    </tr>
                                                    <tr>
                                                        <th>Fecha</th>
                                                        <th>Nombre</th>
                                                        <th>Correo electrónico</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                        <div class="mt-3 text-end">
                                            <a id="download-report" href="javascript:void(0)" class="btn btn-success d-none">
                                                <i class="fas fa-download"></i> <span>Descargar reporte</span>
                                            </a>
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
        <script src="../../assets/js/dashboard-contact.js" type="text/javascript"></script>
    </body>
</html>