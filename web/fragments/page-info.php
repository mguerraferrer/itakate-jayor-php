<?php
    if (!isset($headlineTitle)) {
        $headlineTitle = '';
    }
    
    if (!isset($sectionTitle)) {
        $sectionTitle = null;
    }
?>

<div class="py-3 bg-gray-100">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 my-2">
                <h1 class="m-0 h6 text-center text-lg-start text-jy-gray"><?php echo htmlspecialchars($headlineTitle); ?></h1>
            </div>
            <div class="col-lg-6 my-2">
                <ol class="breadcrumb m-0 fs-small justify-content-center justify-content-lg-end">
                    <li class="breadcrumb-item">
                        <a class="text-nowrap text-reset" href="<?php echo $rootPath; ?>">
                            <i class="bi bi-home"></i>Inicio
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo htmlspecialchars($headlineTitle); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>
<?php if (!empty($sectionTitle)): ?>
<section class="section pb-0">
    <div class="container">
        <div class="d-flex justify-content-center align-self-center" data-aos="fade-down" data-aos-delay="300" data-aos-duration="1000">
            <h3 class="mb-0"><?php echo htmlspecialchars($sectionTitle); ?></h3>
        </div>
    </div>
</section>
<?php endif; ?>
