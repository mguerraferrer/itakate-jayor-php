<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new VacancyWebController();

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'send_resume':
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'area' => trim($_POST['area'] ?? ''),
            'resumeFile' => $_FILES['resumeFile'] ?? null
        ];
        $response = $controller->sendResume($data);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción inválida'];
}

echo json_encode($response);