<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardContactController();

$action = $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_contacts':
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $initialLoad = $_GET['initialLoad'] ?? 0;
        $response = $controller->getContacts($startDate, $endDate, $initialLoad);
        break;

    case 'export_excel':
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        $controller->exportToExcel($startDate, $endDate);
        exit; // Exit after outputting the file
        break;    

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);