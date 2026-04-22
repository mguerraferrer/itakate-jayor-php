<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new DashboardCatalogDownloadController;

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'register_catalog':
        $response = $controller->saveCatalogDownload();
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);