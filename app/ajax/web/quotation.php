<?php
session_start();
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$quotationController = new QuotationWebController();

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$productId = intval($_POST['productId'] ?? $_GET['productId'] ?? 0);

$response = match ($action) {
    'get' => $quotationController->getQuotation(),
    'add' => $quotationController->addToQuotation($productId),
    'remove' => $quotationController->removeFromQuotation($productId),
    default => ['success' => false, 'message' => 'Acción inválida'],
};

echo json_encode($response);