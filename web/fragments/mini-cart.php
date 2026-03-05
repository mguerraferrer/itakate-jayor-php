<!-- Mini Cart  -->
<div class="offcanvas offcanvas-end" tabindex="-1" id="modalMiniCart" aria-labelledby="modalMiniCartLabel">
    <div class="offcanvas-header border-bottom">
        <h6 class="offcanvas-title" id="modalMiniCartLabel">
            Cotizador
        </h6>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <ul class="list-unstyled m-0 p-0" id="quotation-items-list">
            <?php
                $quotationItems = $quotationSessionCart->getItems();
            ?>
            <?php if (!empty($quotationItems)): ?>
                <?php foreach ($quotationItems as $itemInfo): ?>
                <?php 
                    $itemArray = $itemInfo->toArray();
                    $item = $itemArray['item'];
                ?>
                <li class="py-2 quotation-item" data-product-id="<?php echo htmlspecialchars($item['id']); ?>">
                    <div class="row align-items-center">
                        <div class="col-4">
                            <!-- Image -->
                            <a href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($item['productGroup']); ?>">
                                <img class="img-fluid border" src="<?php echo $assetsPath . htmlspecialchars($item['img'] ?? ''); ?>" alt="<?php echo htmlspecialchars($item['sku']); ?>">
                            </a>
                        </div>
                        <div class="col-8">
                            <!-- Title -->
                            <p class="mb-1">
                                <a class="text-mode fw-500" href="<?php echo $viewsPath; ?>product-detail?g=<?php echo htmlspecialchars($item['productGroup']); ?>">
                                    <?php echo htmlspecialchars($item['sku']); ?>
                                </a>
                                <span class="m-0 text-muted w-100 d-block fs-80">
                                    <?php echo htmlspecialchars($item['brandName']); ?>
                                </span>
                            </p>
                            <!--Footer -->
                            <div class="d-flex align-items-center">
                                <!-- Remove -->
                                <a class="small text-danger fw-700 p-1 remove-from-modal" href="#!" data-product-id="<?php echo htmlspecialchars($item['id']); ?>">
                                    Eliminar
                                </a>
                            </div>
                        </div>
                    </div>
                </li>
                <?php endforeach; ?>
            <?php else: ?>
                <li class="text-center py-4">
                    <p class="text-muted">Todavía no has seleccionado ningún producto</p>
                </li>
            <?php endif; ?>
        </ul>
    </div>
    <div class="offcanvas-footer border-top p-3">
        <div class="pt-4">
            <a class="btn btn-block btn-jy-black w-100 mb-3" href="<?php echo $viewsPath; ?>lines">
                Agregar productos
            </a>
            <?php if (!empty($quotationItems)): ?>
            <a class="btn btn-block btn-jy-outline-primary w-100" href="<?php echo $viewsPath; ?>quotation">
                Ir al cotizador
            </a>
            <?php else: ?>
            <a class="btn btn-block btn-jy-outline-primary w-100 disabled" href="#!">
                Ir al cotizador
            </a>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- End Mini Cart  -->
