<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$auth = new AuthController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read JSON data sent
    $input = json_decode(file_get_contents('php://input'), true);
    
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        http_response_code(400);
        echo json_encode(Response::error('Correo electrónico y contraseña son requeridos'));
        exit;
    }

    if ($auth->login($email, $password)) {
        echo json_encode(Response::success('Inicio de sesión exitoso', ['redirect' => '../../web/restricted/dashboard']));
    } else {
        http_response_code(401);
        echo json_encode(Response::error('Credenciales inválidas'));
    }
} else {
    http_response_code(405);
    echo json_encode(Response::error('Método no permitido'));
}
?>