<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardQuotationController();

$action = $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_quotations':        
        $response = $controller->getQuotations();
        break;

    case 'load_user_quotations':
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $response = $controller->getUserQuotations($startDate, $endDate);
        break;

    case 'load_product_quotations':
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $response = $controller->getProductQuotations($startDate, $endDate);
        break;

    case 'export_excel':
        $reportType = $_GET['report_type'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $controller->exportToExcel($reportType, $startDate, $endDate);
        exit; // Exit after outputting the file
        break;    

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);