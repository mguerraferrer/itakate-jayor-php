<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';
include __DIR__ . '/access_verification.php';

$controller = new DashboardSocialController();

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$response = [];

switch ($action) {
    case 'load_social':
        $monthYear = $_GET['monthYear'] ?? '';
        $initialLoad = $_GET['initialLoad'] ?? 0;
        $response = $controller->getSocialNetworksCounts($monthYear, $initialLoad);
        break;

    case 'register_social':
        $social = $_POST['social'] ?? '';        
        $response = $controller->saveSocial($social);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);