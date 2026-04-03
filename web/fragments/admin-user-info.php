<?php
    if (!isset($showBackButton)) {
        $showBackButton = true;
    }
?>
<div class="container">
    <div class="row">                        
        <div class="col-12">
            <div class="d-flex justify-content-end align-items-center pt-5">
                <?php if ($showBackButton): ?>
                    <a href="dashboard" class="btn btn-info btn-sm me-2">
                        <i class="fas fa-home"></i> <span class="ms-1 btn-media-display">Dashboard</span>
                    </a>
                <?php endif; ?>    
                <button class="btn btn-success btn-sm me-2" type="button">
                    <i class="fas fa-user-lock"></i> <span id="user-name" class="ms-1"><?php echo $_SESSION['user_name']; ?></span>
                </button>                
                <a href="?logout=1" class="btn btn-primary btn-sm">
                    <i class="fas fa-sign-out-alt"></i> <span class="ms-1 btn-media-display">Cerrar sesión</span>
                </a>                    
            </div>
        </div>
    </div>
</div>