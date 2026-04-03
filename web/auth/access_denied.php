<?php
    require_once __DIR__ . '/../../autoload.php';
    require_once __DIR__ . '/../template/quotation-admin-init.php';
    
    if (!isset($rootPath)) {
        $rootPath = '../../';
    }

    $title = 'Laboratorio Jayor - Acceso denegado';
?>
<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" type="text/css" href="../../assets/css/admin-dashboard.css">
    </head>
    <body>
        <div class="error-area">
            <div class="container">
                <div class="section-inner">
                    <div class="page-title">
                        <span class="text zero">
                            <i class="fal fa-exclamation-triangle"></i>
                        </span>                        
                    </div>
                    <div class="title">
                        <h2 class="sub-title">Acceso denegado</h2>
                        <h3 class="sect-title">No tienes permiso </br> para acceder a esta página</h3>
                    </div>
                    <div class="section-button">
                        <a href="../restricted/dashboard">
                            <i class="fal fa-long-arrow-left"></i> Ir al panel de control
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>