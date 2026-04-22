<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardCatalogDownloadController;

$action = $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_catalog_downloads':
        $monthYear = $_GET['monthYear'] ?? '';
        $initialLoad = $_GET['initialLoad'] ?? 0;
        $response = $controller->getCatalogDownloadsByMonthYear($monthYear, $initialLoad);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);