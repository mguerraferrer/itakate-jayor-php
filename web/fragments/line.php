<?php
    if (!isset($lines)) {
        $lines = [];
    }
?>

<section class="section">
    <div class="container">
        <div class="row justify-content-center section-heading">
            <div class="col-lg-8 text-center">
                <h4 class="m-0">Productos</h4>
                <h6 class="h6 mt-2 fw-normal fs-80">Ofrecemos diferentes líneas de productos con insumos para la salud que brindan soluciones al alcance de sus manos.
                    Tenemos productos que te ayudarán a cuidar y mejorar la salud en México.</h6>
            </div>
        </div>
        <div class="row g-3 g-lg-4">
            <!-- Product Box -->
            <?php foreach ($lines as $line): ?>
            <div class="col-6 col-lg-3">
                <div class="product-card-1 h-100 line-card-<?php echo htmlspecialchars($line['code']); ?>">
                    <div class="product-card-image line-card-image-<?php echo htmlspecialchars($line['code']); ?>">
                        <div class="product-media">
                            <a href="<?php echo $viewsPath; ?>products?l=<?php echo htmlspecialchars($line['code']); ?>">
                                <img class="img-fluid" src="../../<?php echo htmlspecialchars($line['img']); ?>" title="" alt="">
                            </a>
                        </div>
                    </div>
                    <div class="product-card-info line-card-info line-card-info-<?php echo htmlspecialchars($line['code']); ?>">
                        <a href="<?php echo $viewsPath; ?>products?l=<?php echo htmlspecialchars($line['code']); ?>">
                            <div class="line-media mt-2 mb-3">
                                <img class="img-fluid" src="../../<?php echo htmlspecialchars($line['img1']); ?>" title="" alt="">
                            </div>
                            <h6 class="line-title fs-85 text-white"><?php echo htmlspecialchars($line['description']); ?></h6>
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- End Product Box -->
        </div>
    </div>
</section>
