<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    // Initialize controller
    $quotationController = new QuotationWebController();
    $result = $quotationController->showQuotation();
    if (isset($result['redirect'])) {
        header('Location: ' . $result['redirect']);
        exit;
    }

    $quotationData = $result['data']['quotation'] ?? [];
    $items = $quotationData['items'] ?? [];

    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }

    $title = 'Laboratorio Jayor - Cotizador';
    $headlineTitle = 'Cotizador';
?>
<!doctype html>
<html lang="es-MX">
    <head>
        <?php include '../template/head.php'; ?>
        <link rel="stylesheet" href="../../assets/css/product.css"/>
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
                    $pageTitle = 'Cotizador';
                    include '../fragments/page-info.php'; 
                ?>
                <section class="section">
                    <div class="container">
                        <form id="checkoutForm" method="post">
                            <div class="row gy-4">
                                <div class="col-lg-8 cart-items">
                                    <div class="d-flex justify-content-between align-items-center pb-4 border-bottom mb-4">
                                        <h2 class="h5 mb-0">Productos</h2>
                                        <a class="btn btn-jy-outline-primary btn-sm" href="<?php echo $viewsPath; ?>lines">
                                            Agregar productos
                                        </a>
                                    </div>
                                    
                                    <?php foreach ($items as $index => $item): ?>
                                        <?php 
                                            $itemData = $item instanceof QuotationItemInfo ? $item->toArray() : $item;
                                            $product = $itemData['item'] ?? [];
                                        ?>
                                        <div id="item-container-<?php echo $index; ?>" class="d-flex align-items-center flex-row w-100 pb-3 mb-3 border-bottom">
                                            <input type="hidden" name="items[<?php echo $index; ?>][id]" value="<?php echo htmlspecialchars($itemData['id'] ?? ''); ?>" />
                                            <a class="d-inline-block flex-shrink-0 me-3" href="#">
                                                <img src="<?php echo $assetsPath . htmlspecialchars($product['img'] ?? ''); ?>"
                                                     width="120" 
                                                     alt="<?php echo htmlspecialchars($product['sku'] ?? ''); ?>">
                                            </a>
                                            <div class="d-flex flex-column flex-sm-row col">
                                                <div class="pe-sm-2">
                                                    <h3 class="product-title fs-5 mb-1">
                                                        <a class="text-reset" href="#">
                                                            <?php echo htmlspecialchars($product['sku'] ?? ''); ?>
                                                        </a>
                                                    </h3>
                                                    <?php include '../fragments/quotation-product-details.php'; ?>
                                                </div>
                                                <div class="pt-2 pt-sm-0 d-flex d-sm-block ms-sm-auto">
                                                    <label class="form-label d-none d-sm-inline-block">Cantidad</label>
                                                    <div class="cart-qty-01">
                                                        <div class="dec qty-btn qty_btn">
                                                            <i class="bi bi-caret-up-fill"></i>
                                                        </div>
                                                        <input name="items[<?php echo $index; ?>][quantity]" 
                                                               class="cart-qty-input form-control" 
                                                               type="text" 
                                                               value="<?php echo htmlspecialchars($itemData['quantity'] ?? 1); ?>" />
                                                        <div class="inc qty-btn qty_btn">
                                                            <i class="bi bi-caret-down-fill"></i>
                                                        </div>
                                                    </div>
                                                    <a class="btn btn-link px-0 text-danger ms-auto remove-from-checkout" 
                                                       href="javascript:void(0)"
                                                       data-product-id="<?php echo htmlspecialchars($product['id'] ?? ''); ?>"
                                                       data-container="item-container-<?php echo $index; ?>">
                                                        <i class="bi-trash3 me-2"></i><span class="">Eliminar</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <div class="col-lg-4 ps-xl-7 quotation-sidebar">
                                    <div class="card mb-4">
                                        <div class="card-header bg-transparent py-3">
                                            <h6 class="m-0 h5">Finalizar cotización</h6>
                                        </div>
                                        <div class="card-body">
                                            <!-- Name -->
                                            <div id="div-name" class="form-group mb-2">
                                                <label id="label-name" class="form-control-label" for="name">Nombre *</label>
                                                <input id="name" type="text" name="name" class="form-control" data-required="true">
                                                <small id="small-name"></small>
                                            </div>
                                            <!-- Business Name -->
                                            <div id="div-businessName" class="form-group mb-2">
                                                <label id="label-businessName" class="form-control-label" for="businessName">Razón social *</label>
                                                <input id="businessName" type="text" name="businessName" class="form-control" data-required="true">
                                                <small id="small-businessName"></small>
                                            </div>
                                            <!-- RFC -->
                                            <div id="div-rfc" class="form-group mb-2">
                                                <label id="label-rfc" class="form-control-label" for="rfc">RFC *</label>
                                                <input id="rfc" type="text" name="rfc" class="form-control" data-required="true">
                                                <small id="small-rfc"></small>
                                            </div>
                                            <!-- Email -->
                                            <div id="div-email" class="form-group mb-2">
                                                <label id="label-email" class="form-control-label" for="email">E-mail *</label>
                                                <input id="email" type="text" name="email" class="form-control" data-required="true">
                                                <small id="small-email"></small>
                                            </div>
                                            <!-- Cell -->
                                            <div id="div-cell" class="form-group mb-2">
                                                <label id="label-cell" class="form-control-label" for="cell">Celular *</label>
                                                <input id="cell" type="text" name="cell" class="form-control" data-required="true">
                                                <small id="small-cell"></small>
                                            </div>
                                            <!-- Phone -->
                                            <div id="div-phone" class="form-group mb-2">
                                                <label id="label-phone" class="form-control-label" for="phone">Teléfono</label>
                                                <input id="phone" type="text" name="phone" class="form-control">
                                                <small id="small-phone"></small>
                                            </div>
                                            <!-- Use -->
                                            <div id="div-use" class="form-group mb-2">
                                                <label id="label-use" class="form-control-label" for="use">Uso del producto *</label>
                                                <select name="use" id="use" class="form-control form-select" data-required="true">
                                                    <option value="">-- Seleccione --</option>
                                                    <option value="endUse">Para uso final</option>
                                                    <option value="saleUse">Para distribuidor</option>
                                                </select>
                                                <small id="small-use"></small>
                                            </div>
                                            <!-- Street -->
                                            <div id="div-street" class="form-group mb-2">
                                                <label id="label-street" class="form-control-label" for="street">Calle *</label>
                                                <input id="street" type="text" name="street" class="form-control" data-required="true">
                                                <small id="small-street"></small>
                                            </div>
                                            <!-- Zipcode -->
                                            <div id="div-zipcode" class="form-group mb-2">
                                                <label id="label-zipcode" class="form-control-label" for="zipcode">Código postal *</label>
                                                <input id="zipcode" type="text" name="zipcode" class="form-control" data-required="true">
                                                <small id="small-zipcode"></small>
                                            </div>
                                            <!-- Outside Number -->
                                            <div id="div-outsideNumber" class="form-group mb-2">
                                                <label id="label-outsideNumber" class="form-control-label" for="outsideNumber">No. exterior</label>
                                                <input id="outsideNumber" type="text" name="outsideNumber" class="form-control">
                                                <small id="small-outsideNumber"></small>
                                            </div>
                                            <!-- Inside Number -->
                                            <div id="div-insideNumber" class="form-group mb-2">
                                                <label id="label-insideNumber" class="form-control-label" for="insideNumber">No. interior</label>
                                                <input id="insideNumber" type="text" name="insideNumber" class="form-control">
                                                <small id="small-insideNumber"></small>
                                            </div>
                                            <!-- Colony -->
                                            <div id="div-colony" class="form-group mb-2">
                                                <label id="label-colony" class="form-control-label" for="colony">Colonia *</label>
                                                <input id="colony" type="text" name="colony" class="form-control" data-required="true">
                                                <small id="small-colony"></small>
                                            </div>
                                            <!-- State -->
                                            <div id="div-state" class="form-group mb-2">
                                                <label id="label-state" class="form-control-label" for="state">Estado *</label>
                                                <input id="state" type="text" name="state" class="form-control" data-required="true">
                                                <small id="small-state"></small>
                                            </div>
                                            <!-- Country -->
                                            <div id="div-country" class="form-group mb-2">
                                                <label id="label-country" class="form-control-label" for="country">País *</label>
                                                <input id="country" type="text" name="country" class="form-control" data-required="true">
                                                <small id="small-country"></small>
                                            </div>
                                            <!-- Comments -->
                                            <div id="div-comments" class="form-group mb-2">
                                                <label id="label-comments" class="form-control-label" for="comments">Comentarios</label>
                                                <textarea class="form-control" id="comments" name="comments" rows="3" style="resize: none;"></textarea>
                                                <small id="small-comments"></small>
                                            </div>
                                            <button id="checkoutBtn" class="btn btn-jy-outline-primary d-block w-100" type="button">¡COTIZA AHORA!</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </section>
            </main>
            <!-- Main End -->
            <!-- Footer -->
            <?php include '../template/footer.php'; ?>
            <!-- Footer End -->
        </div>
        <?php include '../template/script.php'; ?>
        <script src="../../assets/js/form.js" type="text/javascript"></script>
        <script src="../../assets/js/quotation-checkout.js"></script>
    </body>
</html>
