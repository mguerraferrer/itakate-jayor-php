<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Contact Controller
 */
class ContactWebController {

    private MailWebService $mailWebService;
    private DashboardContactService $dashboardContactService;

    public function __construct() {
        $this->mailWebService = new MailWebService();
        $this->dashboardContactService = new DashboardContactService();
    }

    /**
     * Send a contact message
     *
     * @param array $data Contact message data
     * @return array Response message
     */
    public function sendMessage(array $data): array {
        try {
            $rules = $this->getValidationRules();
            $validation = Validator::validateFields($data, $rules);
            if (!$validation['success']) {
                return $validation; // Return validation errors
            }

            $cleanData = [
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'subject' => trim($data['subject']),
                'comments' => trim($data['comments'])
            ];

            $sent = $this->mailWebService->sendContactEmail($cleanData);
            // If email sent successfully, save the contact info to the database
            if ($sent['success']) {
                $this->dashboardContactService->saveContact($cleanData['name'], $cleanData['email']);
            }

            $responseMessage = $sent['success']
                ? 'Muchas gracias por contactarnos. En breve estaremos atendiendo tu solicitud'
                : 'No se ha podido enviar el formulario de contacto. Por favor, intenta más tarde';
            return $sent['success'] ? Response::success($responseMessage) : Response::error($responseMessage);
        } catch (Exception $e) {
            return Response::error('Error al enviar el formulario de contacto: ' . $e->getMessage());
        }
    }

    /**
     * Validation rules for a contact message
     *
     * @return array Validation rules
     */
    private function getValidationRules(): array {
        return [
            'name' => ['required' => true, 'message' => 'El nombre es requerido'],
            'email' => ['required' => true, 'message' => 'El correo electrónico es requerido', 'type' => 'email'],
            'subject' => ['required' => true, 'message' => 'El asunto es requerido'],
            'comments' => ['required' => true, 'message' => 'El comentario es requerido'],
        ];
    }
}