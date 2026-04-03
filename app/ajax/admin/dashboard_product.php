<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardProductController();

$action = $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_products':
        $monthYear = $_GET['monthYear'] ?? '';
        $initialLoad = $_GET['initialLoad'] ?? 0;
        $response = $controller->loadTop10($monthYear, $initialLoad);
        break;

    case 'export_excel':
        $reportType = $_GET['report_type'] ?? '';
        $monthYear = $_GET['month_year'] ?? '';
        $controller->exportToExcel($reportType, $monthYear);
        exit; // Exit after outputting the file
        break;    

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);