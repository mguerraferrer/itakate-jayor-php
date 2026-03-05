<?php foreach ($products as $product): ?>
    <!-- Product Box -->
    <div class="col-sm-6 col-lg-4">
        <div class="product-card-1 h-100">
            <div class="product-card-image">
                <div class="badge-ribbon">
                    <?php if (isset($product['top_ten']) && $product['top_ten']): ?>
                        <span class="badge bg-danger text-uppercase">Top <?php echo htmlspecialchars($product['top_ten_order']); ?></span>
                    <?php endif; ?>
                    <?php if (isset($product['outlet']) && $product['outlet']): ?>
                        <span class="badge bg-danger text-uppercase">Oferta</span>
                    <?php endif; ?>
                </div>
                <div class="product-media">
                    <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>">
                        <img class="img-fluid" src="../../<?php echo htmlspecialchars($product['img']); ?>" title="" alt="">
                    </a>
                    <div class="product-cart-btn">
                        <?php if ($lineActive != null): ?>
                            <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>&lb=l&c=<?php echo htmlspecialchars($product['line_code']); ?>" class="btn btn-jy-primary btn-sm w-100 btn-quotation">
                                <i class="fi-shopping-cart"></i> Ver detalles
                            </a>
                        <?php endif; ?>
                        <?php if ($brandActive != null): ?>
                            <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>&lb=b&c=<?php echo htmlspecialchars($product['brand_code']); ?>" class="btn btn-jy-primary btn-sm w-100 btn-quotation">
                                <i class="fi-shopping-cart"></i> Ver detalles
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="product-card-info">
                <h6 class="product-title fs-80">
                    <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($product['product_group']); ?>"><?php echo htmlspecialchars($product['sku']); ?></a>
                </h6>
            </div>
        </div>
    </div>
    <!-- End Product Box -->
<?php endforeach; ?>