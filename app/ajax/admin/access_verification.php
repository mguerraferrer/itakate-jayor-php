<?php

// Access verification for AJAX scripts
if (!isset($requiredRole)) {
    $requiredRole = 'isAdmin';
} 

$unauthorizedAccessResponse = null;
if (!isset($_SESSION['userSession'])) {
    $unauthorizedAccessResponse = Response::authenticationRequired();    
} else if ($_SESSION['userSession'][$requiredRole] !== true) {
    $unauthorizedAccessResponse = Response::permissionDenied();
}

// If unauthorized, output response and exit
if ($unauthorizedAccessResponse !== null) {
    echo json_encode($unauthorizedAccessResponse);
    exit;
}