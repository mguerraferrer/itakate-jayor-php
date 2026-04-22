<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardTalentController();

$action = $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_talent':
        $monthYear = $_GET['monthYear'] ?? '';
        $initialLoad = $_GET['initialLoad'] ?? 0;
        $response = $controller->getTalentDataByMonthYear($monthYear, $initialLoad);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);