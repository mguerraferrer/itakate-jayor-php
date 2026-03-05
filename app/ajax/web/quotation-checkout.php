<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new QuotationCheckoutWebController();

$action = $_POST['action'] ?? $_GET['action'] ?? '';

switch ($action) {
    case 'checkout':
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'businessName' => trim($_POST['businessName'] ?? ''),
            'rfc' => trim($_POST['rfc'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'cell' => trim($_POST['cell'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'use' => trim($_POST['use'] ?? ''),
            'street' => trim($_POST['street'] ?? ''),
            'zipcode' => trim($_POST['zipcode'] ?? ''),
            'outsideNumber' => trim($_POST['outsideNumber'] ?? ''),
            'insideNumber' => trim($_POST['insideNumber'] ?? ''),
            'colony' => trim($_POST['colony'] ?? ''),
            'state' => trim($_POST['state'] ?? ''),
            'country' => trim($_POST['country'] ?? ''),
            'comments' => trim($_POST['comments'] ?? '')
        ];
        
        // Parse products from JSON string
        $productsJson = $_POST['products'] ?? '[]';
        $products = json_decode($productsJson, true) ?? [];
        
        $response = $controller->checkout($products, $data);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción inválida'];
}

echo json_encode($response);