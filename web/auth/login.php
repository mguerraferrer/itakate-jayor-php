<?php
    // Include authentication handler to check if user is logged in
    require_once '../../app/controllers/admin/AuthController.php';

    $auth = new AuthController();
    if ($auth->isLoggedIn()) {
        // Si está autenticado → redirigir al área protegida
        header('Location: ../restricted/dashboard');
        exit;
    }

    require_once __DIR__ . '/../template/quotation-admin-init.php';
    $title = 'Laboratorio Jayor - Dashboard Login';
?>
<!DOCTYPE html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" type="text/css" href="../../assets/css/admin-dashboard.css">
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
                <div class="py-3 bg-gray-100">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg-6 my-2">
                                <h1 class="m-0 h6 text-center text-lg-start text-jy-gray">Zona administrativa</h1>
                            </div>
                            <div class="col-lg-6 my-2">
                                <ol class="breadcrumb m-0 fs-small justify-content-center justify-content-lg-end">
                                    <li class="breadcrumb-item">
                                        <a class="text-nowrap text-reset" href="<?php echo $rootPath; ?>">
                                            <i class="fas fa-house me-1"></i>Inicio
                                        </a>
                                    </li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
                <section class="section-pt">
                    <div class="container">
                        <div class="justify-content-center row">
                            <div class="col-lg-5 col-xxl-4">
                                <div class="card">
                                    <div class="card-header bg-transparent py-3">
                                        <h4><i class="fas fa-user-shield me-1"></i> Iniciar sesión</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="alert-message" class="alert d-none"></div>
                                        <form id="login-form">
                                            <div class="form-group mb-3">
                                                <label for="email" class="form-label">Correo electrónico <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="email" name="email" required />
                                            </div>
                                            <div class="form-group mb-3">
                                                <div class="row align-items-center">
                                                    <label class="form-label col" for="password">Contraseña <span class="text-danger">*</span></label>
                                                </div>
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña *" required />
                                            </div>
                                            
                                            <div class="form-group text-center">
                                                <button id="login-btn" type="submit" name="login-btn" class="btn btn-primary w-100">
                                                    Iniciar sesión <i class="fal fa-long-arrow-right"></i>
                                                </button>
                                            </div>
                                        </form>                                        
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
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/login.js"></script>
    </body>
</html>