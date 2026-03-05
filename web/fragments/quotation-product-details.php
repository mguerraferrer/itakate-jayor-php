<?php
    if (!isset($product)) {
        $product = [];
    }
?>

<?php if (isset($product['brandName']) && $product['brandName'] != null): ?>
<div class="small"><span class="text-muted me-2">Marca:</span> <span><?php echo htmlspecialchars($product['brandName']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['code']) && $product['code'] != null): ?>
<div class="small"><span class="text-muted me-2">Código:</span> <span><?php echo htmlspecialchars($product['code']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['measure']) && $product['measure'] != null): ?>
<div class="small"><span class="text-muted me-2">Medida:</span> <span><?php echo htmlspecialchars($product['measure']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['presentation']) && $product['presentation'] != null): ?>
<div class="small"><span class="text-muted me-2">Presentación:</span> <span><?php echo htmlspecialchars($product['presentation']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['bagDimensions']) && $product['bagDimensions'] != null): ?>
<div class="small"><span class="text-muted me-2">Dimensiones (bolsa):</span> <span><?php echo htmlspecialchars($product['bagDimensions']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['neckDimensions']) && $product['neckDimensions'] != null): ?>
<div class="small"><span class="text-muted me-2">Dimensiones (cuello):</span> <span><?php echo htmlspecialchars($product['neckDimensions']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['caliber']) && $product['caliber'] != null): ?>
<div class="small"><span class="text-muted me-2">Calibre:</span> <span><?php echo htmlspecialchars($product['caliber']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['length']) && $product['length'] != null): ?>
<div class="small"><span class="text-muted me-2">Longitud:</span> <span><?php echo htmlspecialchars($product['length']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['capacity']) && $product['capacity'] != null): ?>
<div class="small"><span class="text-muted me-2">Capacidad:</span> <span><?php echo htmlspecialchars($product['capacity']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['cbKey']) && $product['cbKey'] != null): ?>
<div class="small"><span class="text-muted me-2">Clave C.B:</span> <span><?php echo htmlspecialchars($product['cbKey']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['salesFactor']) && $product['salesFactor'] != null): ?>
<div class="small"><span class="text-muted me-2">Factor de venta:</span> <span><?php echo htmlspecialchars($product['salesFactor']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['healthRegister']) && $product['healthRegister'] != null): ?>
<div class="small"><span class="text-muted me-2">Registro Sanitario:</span> <span><?php echo htmlspecialchars($product['healthRegister']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['size']) && $product['size'] != null): ?>
<div class="small"><span class="text-muted me-2">Tamaño: </span> <span><?php echo htmlspecialchars($product['size']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['guideDiameter']) && $product['guideDiameter'] != null): ?>
<div class="small"><span class="text-muted me-2">Diámetro guía:</span> <span><?php echo htmlspecialchars($product['guideDiameter']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['color']) && $product['color'] != null): ?>
<div class="small"><span class="text-muted me-2">Color:</span> <span><?php echo htmlspecialchars($product['color']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['weight']) && $product['weight'] != null): ?>
<div class="small"><span class="text-muted me-2">Peso:</span> <span><?php echo htmlspecialchars($product['weight']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['volume']) && $product['volume'] != null): ?>
<div class="small"><span class="text-muted me-2">Volumen:</span> <span><?php echo htmlspecialchars($product['volume']); ?></span></div>
<?php endif; ?>

<?php if (isset($product['needle']) && $product['needle'] != null): ?>
<div class="small"><span class="text-muted me-2">Aguja: </span> <span><?php echo htmlspecialchars($product['needle']); ?></span></div>
<?php endif; ?>
