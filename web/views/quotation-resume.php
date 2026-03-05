<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    // Get folio from URL parameter
    $folio = $_GET['f'] ?? null;

    // Validate folio and check creation date
    if (empty($folio)) {
        header('Location: products.php');
        exit;
    }

    // Initialize service and get creation date
    $quotationCheckoutWebService = new QuotationCheckoutWebService();
    $result = $quotationCheckoutWebService->getQuotationCreationDate($folio);

    if (!$result || empty($result['creation_date'])) {
        // No creation_date found or is null - redirect
        header('Location: products');
        exit;
    }

    // Check if creation_date is within 1-minute using timestamps
    try {
        $mxTz = new DateTimeZone('America/Mexico_City');

        // Interpret DB datetime as Mexico local time
        $creationDate = DateTimeImmutable::createFromFormat(
                'Y-m-d H:i:s',
                $result['creation_date'],
                $mxTz
        );

        if (!$creationDate) {
            header('Location: products');
            exit;
        }

        // Current time in same timezone
        $currentDate = new DateTimeImmutable('now', $mxTz);

        // Difference in seconds
        $secondsDiff = abs($currentDate->getTimestamp() - $creationDate->getTimestamp());

        // If more than 60 seconds (1 minute), redirect
        if ($secondsDiff > 60) {
            header('Location: products');
            exit;
        }
    } catch (Exception $e) {
        header('Location: products');
        exit;
    }

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Cotización Enviada';
    $headlineTitle = 'Cotizador';
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
                <?php 
                    $pageTitle = 'Cotización Enviada';
                    include '../fragments/page-info.php'; 
                ?>
                <section class="section py-6">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card border-0 shadow-sm">
                                    <div class="card-body text-center py-5">
                                        <div class="mb-4">
                                            <i class="bi bi-check-circle text-success" style="font-size: 4rem;"></i>
                                        </div>
                                        <h2 class="h3 mb-3">¡Cotización Enviada con Éxito!</h2>
                                        <p class="text-muted mb-4">
                                            Hemos recibido su solicitud de cotización. Nuestro equipo la revisará y se pondrá en contacto con usted a la brevedad posible.
                                        </p>
                                        <p class="text-muted mb-4">
                                            Recibirá una copia de su solicitud en el correo electrónico proporcionado.
                                        </p>
                                        <div class="d-flex justify-content-center gap-3 flex-wrap">
                                            <a href="<?php echo $viewsPath; ?>products" class="btn btn-jy-outline-primary">
                                                <i class="bi bi-arrow-left me-2"></i>Volver a Productos
                                            </a>
                                            <a href="<?php echo $rootPath; ?>" class="btn btn-jy-primary">
                                                <i class="bi bi-house me-2"></i>Ir al Inicio
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </main>
            <!-- Main End -->
            <!-- Footer -->
            <?php include '../template/footer.php'; ?>
            <!-- Footer End -->
        </div>
        <?php include '../template/script.php'; ?>
    </body>
</html>
