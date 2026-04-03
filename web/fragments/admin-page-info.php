<?php
    if (!isset($headlineTitle)) {
        $headlineTitle = '';
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
                        <a class="text-nowrap text-reset" href="dashboard">
                            <i class="fas fa-house me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="breadcrumb-item text-nowrap active" aria-current="page"><?php echo htmlspecialchars($headlineTitle); ?></li>
                </ol>
            </div>
        </div>
    </div>
</div>