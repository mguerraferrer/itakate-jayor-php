<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new ContactWebController();
$recaptchaWebService = new RecaptchaWebService();

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'send_message':
        // Validate reCAPTCHA token
        $recaptchaToken = $_POST['g-recaptcha-response'] ?? ($_POST['recaptcha_token'] ?? '');
        if (empty($recaptchaToken)) {
            $response = [
                'success' => false,
                'message' => 'Por favor, completa la validación de reCAPTCHA'
            ];
            break;
        }

        // Verify reCAPTCHA with Google
        $recaptchaResult = $recaptchaWebService->verify($recaptchaToken);
        if (!$recaptchaResult['success']) {
            $response = [
                'success' => false,
                'message' => $recaptchaResult['message']
            ];
            break;
        }

        // If reCAPTCHA validation passed, proceed with the message sending
        $data = [
            'name' => trim($_POST['name'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'subject' => trim($_POST['subject'] ?? ''),
            'comments' => trim($_POST['comments'] ?? '')
        ];
        $response = $controller->sendMessage($data);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);