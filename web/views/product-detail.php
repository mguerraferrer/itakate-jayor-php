<?php
    require_once __DIR__ . '/../template/quotation-session-init.php';
    require_once __DIR__ . '/../../autoload.php';

    $quotationSessionCheck = new QuotationSession();

    // Get parameters from URL
    $productGroup = $_GET['g'] ?? null;
    $loadedBy = $_GET['lb'] ?? 'l';
    $code = $_GET['c'] ?? 'adh';
    
    // Initialize variables
    $productDetail = null;
    
    // Load product data if product group is provided
    if (!empty($productGroup)) {
        $productController = new ProductWebController();
        $productDetail = $productController->loadByProductGroup($productGroup, $loadedBy, $code);
    }
    
    if (!isset($viewsPath)) {
        $viewsPath = '../views/';
    }
    
    $title = 'Laboratorio Jayor - Detalles del producto';
    $headlineTitle = 'Productos';
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
                <?php include '../fragments/page-info.php'; ?>
                <section class="product-details py-6">
                    <div class="container">
                        <?php if ($productDetail === null): ?>
                        <!-- Product Not Found -->
                        <div class="row justify-content-center align-items-center">
                            <div class="col-12">
                                <div class="alert alert-danger text-center">
                                    Producto no encontrado
                                </div>
                            </div>
                            <div class="col-12 col-md-3 pt-4">
                                <a class="btn btn-block btn-jy-black w-100 mb-3" href="<?php echo $viewsPath; ?>lines">
                                    Seleccionar productos
                                </a>
                            </div>
                        </div>
                        <!-- End Product Not Found -->
                        <?php else: ?>
                        <!-- Product Details -->
                        <div class="row align-items-start">
                            <!-- Product Gallery -->
                            <div class="col-lg-6 lightbox-gallery">
                                <div class="mb-3">
                                    <a class="gallery-link" href="<?php echo '../../' . htmlspecialchars($productDetail['img']); ?>">
                                        <img class="img-fluid" src="<?php echo '../../' . htmlspecialchars($productDetail['img']); ?>" title="" alt="<?php echo htmlspecialchars($productDetail['sku']); ?>">
                                    </a>
                                </div>
                            </div>
                            <!-- End Product Gallery -->
                            <!-- Product Details -->
                            <div class="col-lg-6 ps-lg-5 pt-5 pt-lg-0 sticky-lg-top sticky-lg-top-header">
                                <div class="product-detail">
                                    <!-- Product Badges -->
                                    <?php if (!empty($productDetail['topTen']) || !empty($productDetail['outlet'])): ?>
                                    <div class="products-brand pb-2">
                                        <?php if (!empty($productDetail['topTen'])): ?>
                                        <span class="badge bg-danger text-uppercase">
                                            Top <?php echo htmlspecialchars($productDetail['topTenOrder']); ?>
                                        </span>
                                        <?php endif; ?>

                                        <?php if (!empty($productDetail['outlet'])): ?>
                                        <span class="badge bg-danger text-uppercase">Oferta</span>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                    <!-- End Product Badges -->
                                    <!-- Product Title -->
                                    <div class="products-title mb-2">
                                        <h4 class="h4"><?php echo htmlspecialchars($productDetail['sku']); ?></h4>
                                    </div>
                                    <!-- End Product Title -->
                                    <!-- Product Attributes -->
                                    <div class="product-attribute pt-5">
                                        <?php foreach ($productDetail['products'] as $product): ?>
                                        <div class="row g-2 g-md-3 product-detail-container pb-3 mb-3">
                                            <div class="col-12 col-md-8 product-detail-info">
                                                <div class="d-flex flex-column">
                                                    <span><?php echo htmlspecialchars($product['details'] ?? 'Sin descripción'); ?></span>
                                                    <?php if (!$product['inStock']): ?>
                                                        <span class="badge text-bg-danger mt-1">Producto agotado</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-4 text-end">
                                                <?php
                                                    // Check if product is in quotation session
                                                    $quotationItemsCheck = $quotationSessionCheck->getItems();
                                                    $inQuotation = false;
                                                    foreach ($quotationItemsCheck as $quotItem) {
                                                        if ($quotItem->getId() === $product['id']) {
                                                            $inQuotation = true;
                                                            break;
                                                        }
                                                    }
                                                ?>

                                                <?php if (!$inQuotation): ?>
                                                <a href="javascript:void(0)" 
                                                   class="btn btn-jy-primary btn-sm w-100 btn-quotation add-to-quotation" 
                                                   data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                                                    Agregar al cotizador
                                                </a>
                                                <?php else: ?>
                                                <a href="javascript:void(0)" 
                                                   class="btn btn-primary btn-sm w-100 btn-quotation remove-from-quotation" 
                                                   data-product-id="<?php echo htmlspecialchars($product['id']); ?>">
                                                    Eliminar del cotizador
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                        <?php endforeach; ?>
                                    </div>
                                    <!-- End Product Attributes -->
                                    <!-- Product Actions -->
                                    <div class="product-detail-actions d-flex flex-wrap pt-3">
                                        <div class="col-12 col-md-4 me-md-2 mb-2">
                                            <?php if ($loadedBy === 'l'): ?>
                                            <a href="<?php echo $viewsPath; ?>products?l=<?php echo htmlspecialchars($code); ?>" class="btn btn-jy-ocean btn-sm w-100">
                                                Ver más productos
                                            </a>
                                            <?php elseif ($loadedBy === 'b'): ?>
                                            <a href="<?php echo $viewsPath; ?>products?b=<?php echo htmlspecialchars($code); ?>" class="btn btn-jy-ocean btn-sm w-100">
                                                Ver más productos
                                            </a>
                                            <?php else: ?>
                                            <a href="<?php echo $viewsPath; ?>products" class="btn btn-jy-ocean btn-sm w-100">
                                                Ver más productos
                                            </a>
                                            <?php endif; ?>
                                        </div>
                                        <div class="col-12 col-md-4 mb-2">
                                            <a href="<?php echo $viewsPath; ?>quotation" class="btn btn-jy-black btn-sm w-100">
                                                Ir al cotizador
                                            </a>
                                        </div>
                                    </div>
                                    <!-- End Product Actions -->
                                </div>
                            </div>
                            <!-- End Product Details -->
                        </div>
                        <!-- End Product Details Content -->
                        <?php endif; ?>
                    </div>
                </section>
            </main>
            <!-- End Main -->
            <!-- Footer-->
            <?php include '../template/footer.php'; ?>
            <!-- End Footer -->
        </div>
        <?php include '../template/script.php'; ?>
        <!-- Magnific Popup -->
        <script src="../../assets/vendor/magnific/jquery.magnific-popup.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                setNavActive('header-nav-product');
            });
        </script>
    </body>
</html>
