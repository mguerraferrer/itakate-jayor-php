<section class="py-3">
    <div class="container-fluid">
        <div class="row g-3" data-aos="fade-left" data-aos-delay="300" data-aos-duration="1000">
            <?php
            $imageItems = [
                [
                    'imageName' => 'item-4.webp',
                    'title' => 'Nuestro ADN',
                    'subtitle' => 'Nuestra fuerza es aquello que no se ve, pero se siente y nos impulsa. Conoce nuestro ADN.',
                    'href' => '/about-us'
                ],
                [
                    'imageName' => 'item-5.webp',
                    'title' => 'Productos',
                    'subtitle' => 'Todo lo que somos, expresado en marcas, líneas de productos y emociones.',
                    'href' => '/lines'
                ],
                [
                    'imageName' => 'item-6.webp',
                    'title' => 'Certificaciones',
                    'subtitle' => 'Nuestras certificaciones respaldan nuestra calidad y compromiso, son la marca de tu confianza.',
                    'href' => '/about-us#certifications'
                ],
                [
                    'imageName' => 'item-7.webp',
                    'title' => 'Sin fronteras',
                    'subtitle' => '¡Por la sonrisa del mundo! Expandimos y replicamos nuestras raíces sin fronteras.',
                    'href' => '/about-us#global-presence'
                ]
            ];

            foreach ($imageItems as $item) {
                ?>
                <div class="col-sm-6 col-lg-3">
                    <div class="position-relative hover-scale">
                        <div class="hover-scale-in">
                            <a href="<?php echo $viewsPath . ltrim($item['href'], '/'); ?>">
                                <img class="w-100" src="<?php echo $assetsPath; ?>assets/src/home/<?php echo $item['imageName']; ?>" title="" alt="">
                            </a>
                        </div>
                        <div class="position-absolute bottom-0 start-0 w-100 p-4">
                            <a href="<?php echo $viewsPath . ltrim($item['href'], '/'); ?>" class="jy-link">
                                <div class="w-100 p-4 text-center bg-mode-re">
                                    <h3 class="h6 fw-700 letter-spacing-2 text-uppercase"><?php echo $item['title']; ?></h3>
                                    <p class="fs-small mb-0"><?php echo $item['subtitle']; ?></p>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
</section>
