<div class="col-lg-4 col-xl-3 pe-xl-5 offcanvas-lg offcanvas-start px-0 px-lg-3" tabindex="-1" id="shop_filter" aria-labelledby="shop_filterLabel">
    <div class="offcanvas-header border-bottom">
        <h5 class="offcanvas-title" id="shop_filterLabel">Shop Filter</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" data-bs-target="#shop_filter" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-column">
        <!-- Categories -->
        <div class="shop-sidebar-block">
            <div class="shop-sidebar-title">
                <a class="h5" data-bs-toggle="collapse" href="#shop_categories" role="button" aria-expanded="true" aria-controls="shop_categories">
                    CATEGORÍAS <i class="bi bi-chevron-up"></i>
                </a>
            </div>
            <div class="shop-category-list collapse show" id="shop_categories">
                <ul class="nav flex-column">
                    <?php foreach ($lines as $line): ?>
                    <li class="nav-item">
                        <a id="category-sidebar-<?php echo htmlspecialchars($line['code']); ?>" href="<?php echo $viewsPath; ?>products?l=<?php echo htmlspecialchars($line['code']); ?>"
                           class="nav-link category-sidebar <?php echo ($lineActive != null && $lineActive == $line['code']) ? 'active' : ''; ?>"><?php echo htmlspecialchars($line['name']); ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- Brands -->
        <div class="shop-sidebar-block">
            <div class="shop-sidebar-title">
                <a class="h5" data-bs-toggle="collapse" href="#shop_brand" role="button" aria-expanded="true" aria-controls="shop_brand">
                    MARCAS <i class="bi bi-chevron-up"></i>
                </a>
            </div>
            <div class="shop-category-list collapse show" id="shop_brand">
                <ul class="nav flex-column">
                    <?php foreach ($brands as $brand): ?>
                    <li class="nav-item">
                        <a id="brand-sidebar-<?php echo htmlspecialchars($brand['code']); ?>" href="<?php echo $viewsPath; ?>products?b=<?php echo htmlspecialchars($brand['code']); ?>"
                           class="nav-link brand-sidebar <?php echo ($brandActive != null && $brandActive == $brand['code']) ? 'active' : ''; ?>"><?php echo htmlspecialchars($brand['name']); ?></a>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <!-- End Brands -->
    </div>
</div>