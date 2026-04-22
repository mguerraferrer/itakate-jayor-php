<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new DashboardTalentController;

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'register_talent':
        $response = $controller->saveTalentEntry();
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);