<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new DashboardSocialController();

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'register_social':
        $social = $_POST['social'] ?? '';        
        $response = $controller->saveSocial($social);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);