<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../../../autoload.php';

$controller = new PharmaWebController();
$recaptchaWebService = new RecaptchaWebService();

$action = $_POST['action'] ?? '';
$response = [];

switch ($action) {
    case 'validate_step':
        $step = $_POST['step'] ?? -1;
        if ($step === 4) {
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
        }

        $data = [
            // Step 1
            'name' => trim($_POST['name'] ?? ''),
            'plName' => trim($_POST['plName'] ?? ''),
            'mlName' => trim($_POST['mlName'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'personType' => trim($_POST['personType'] ?? ''),
            // Step 2
            'product' => trim($_POST['product'] ?? ''),
            'lote' => trim($_POST['lote'] ?? ''),
            'dueDate' => trim($_POST['dueDate'] ?? ''),
            'genericName' => trim($_POST['genericName'] ?? ''),
            'dose' => trim($_POST['dose'] ?? ''),
            'admWay' => trim($_POST['admWay'] ?? ''),
            'brand' => trim($_POST['brand'] ?? ''),
            'healthRegister' => trim($_POST['healthRegister'] ?? ''),
            'productUseYes' => DataUtil::toIntBool($_POST['productUseYes'] ?? 0),
            'productUseNo' => DataUtil::toIntBool($_POST['productUseNo'] ?? 0),
            'startDate' => trim($_POST['startDate'] ?? ''),
            'endDate' => trim($_POST['endDate'] ?? ''),
            'reasonUse' => trim($_POST['reasonUse'] ?? ''),
            'otherDrug' => trim($_POST['otherDrug'] ?? ''),
            // Step 3
            'eventHappened' => trim($_POST['eventHappened'] ?? ''),
            'eventStartDate' => trim($_POST['eventStartDate'] ?? ''),
            'eventEndDate' => trim($_POST['eventEndDate'] ?? ''),
            'eventUseYes' => DataUtil::toIntBool($_POST['eventUseYes'] ?? 0),
            'eventUseNo' => DataUtil::toIntBool($_POST['eventUseNo'] ?? 0),
            'eventType' => trim($_POST['eventType'] ?? ''),
            // Step 4
            'patName' => trim($_POST['patName'] ?? ''),
            'patPlName' => trim($_POST['patPlName'] ?? ''),
            'patMlName' => trim($_POST['patMlName'] ?? ''),
            'gender' => trim($_POST['gender'] ?? ''),
            'birthDate' => trim($_POST['birthDate'] ?? ''),
            'pregnancyYes' => DataUtil::toIntBool($_POST['pregnancyYes'] ?? 0),
            'pregnancyNo' => DataUtil::toIntBool($_POST['pregnancyNo'] ?? 0),
            'height' => trim($_POST['height'] ?? ''),
            'weight' => trim($_POST['weight'] ?? ''),
            'doctorPrescribeYes' => DataUtil::toIntBool($_POST['doctorPrescribeYes'] ?? 0),
            'doctorPrescribeNo' => DataUtil::toIntBool($_POST['doctorPrescribeNo'] ?? 0),
            'patPhone' => trim($_POST['patPhone'] ?? ''),
            'patEmail' => trim($_POST['patEmail'] ?? '')
        ];
        $response = $controller->validateStep($step, $data);
        break;

    default:
        $response = ['success' => false, 'message' => 'Acción no válida'];
}

echo json_encode($response);