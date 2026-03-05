<?php
    if (!isset($vacancies)) {
        $vacancies = [];
    }
?>
<section class="section" data-aos="fade-up" data-aos-delay="300" data-aos-duration="1000">
    <div class="container">
        <div class="row g-3 g-lg-4">
            <!-- Vacancy Box -->
            <?php foreach ($vacancies as $vacancy): ?>
            <div class="col-6 col-lg-3">
                <div class="product-card-1 h-100">
                    <div class="product-card-image">
                        <div class="product-media d-flex justify-content-center align-items-center vacancy-media">
                            <a href="<?php echo $viewsPath; ?>vacancies/detail?code=<?php echo htmlspecialchars($vacancy['code']); ?>">
                                <p><?php echo htmlspecialchars($vacancy['title']); ?></p>
                            </a>
                            <div class="product-cart-btn">
                                <a href="<?php echo $viewsPath; ?>vacancy-detail?c=<?php echo htmlspecialchars($vacancy['code']); ?>" class="btn btn-jy-primary btn-sm w-100 btn-quotation">
                                    Conoce más
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <!-- End Vacancy Box -->
        </div>
    </div>
</section>
