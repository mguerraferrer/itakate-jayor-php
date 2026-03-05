<?php
    if (!isset($topProducts)) {
        $topProducts = [];
    }
?>
<section class="section" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
    <div class="container">
        <div class="row justify-content-center section-heading">
            <div class="col-lg-6 text-center">
                <h4 class="m-0">Productos TOP</h4>
                <h6 class="h6 mt-2 fw-normal">Conoce los productos que nos impulsan.</h6>
            </div>
        </div>
        <div class="row g-3 g-lg-4">
            <!-- Product Box -->
            <?php foreach ($topProducts as $product): ?>
                <div class="col-6 col-lg-3">
                    <div class="product-card-1 h-100">
                        <div class="product-card-image">
                            <div class="badge-ribbon">
                                <span class="badge bg-danger text-uppercase">Top <?php echo htmlspecialchars($product['top_ten_order']); ?></span>
                            </div>
                            <div class="product-media">
                                <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>">
                                    <img class="img-fluid" src="<?php echo $assetsPath . htmlspecialchars($product['img']); ?>" title="" alt="">
                                </a>
                                <div class="product-cart-btn">
                                    <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>" class="btn btn-jy-primary btn-sm w-100 btn-quotation">
                                        Ver detalles
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="product-card-info">
                            <h6 class="product-title fs-85">
                                <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>"><?php echo htmlspecialchars($product['line_name']) . ' - ' . htmlspecialchars($product['sku']); ?></a>
                            </h6>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
            <!-- End Product Box -->
        </div>
    </div>
</section>
