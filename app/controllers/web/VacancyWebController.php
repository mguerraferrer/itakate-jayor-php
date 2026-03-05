<?php
require_once __DIR__ . '/../../../autoload.php';

class VacancyWebController {

    use FileTrait;
    private VacancyWebService $vacancyWebService;
    private MailWebService $mailWebService;

    public function __construct() {
        $this->vacancyWebService = new VacancyWebService();
        $this->mailWebService = new MailWebService();
    }

    /**
     * Get all active vacancies
     *
     * @return array Array of active vacancies
     */
    public function getActiveVacancies(): array {
        return $this->vacancyWebService->getActiveVacancies() ?? [];
    }

    public function getVacancy(string $code): array {
        return $this->vacancyWebService->getVacancy($code) ?? [];
    }

    public function sendResume(array $data): array {
        try {
            $rules = $this->getValidationRules();
            $validation = Validator::validateFields($data, $rules);
            if (!$validation['success']) {
                return $validation; // Return validation errors
            }

            $uploadResult = FileUtil::uploadFile($data['resumeFile']);
            if (!$uploadResult['success']) {
                return $uploadResult;
            }

            $file = [
                'uploadFilePath' => $uploadResult['uploadFilePath'],
                'filePath' => $uploadResult['filePath'],
                'fileName' => $uploadResult['fileName'],
                'originalName' => $uploadResult['originalName']
            ];

            $cleanData = [
                'name' => trim($data['name']),
                'email' => trim($data['email']),
                'phone' => trim($data['phone']),
                'address' => trim($data['address']),
                'area' => self::getAreaDescription(trim($data['area']))
            ];

            $sent = $this->mailWebService->sendResumeEmail($cleanData, $file);
            if ($sent['success']) {
                $filePath = __DIR__ . '/../../../' . $file['filePath'];
                @unlink($filePath);
            }

            $responseMessage = $sent['success']
                ? 'Gracias por enviar tu solicitud. Nos pondremos en contacto contigo pronto.'
                : 'No se ha podido enviar el formulario de vacantes. Por favor, intenta más tarde';
            return $sent['success'] ? Response::success($responseMessage) : Response::error($responseMessage);
        } catch (Exception $e) {
            return Response::error('Error al enviar el formulario de vacantes: ' . $e->getMessage());
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
            'phone' => ['required' => true, 'length' => 10, 'message' => 'El teléfono es requerido'],
            'address' => ['required' => true, 'message' => 'La alcaldía o municipio es requerido'],
            'area' => [
                'required' => true,
                'enum' => ['values' => ['com', 'sal', 'mar', 'acc', 'tra', 'war', 'qua', 'bil', 'col'], 'frontEndField' => 'Área de interés'],
                'message' => 'El área de interés es requerida'
            ],
            'resumeFile' => [
                'required' => true,
                'type' => 'file',
                'fileUploadMessage' => 'El archivo debe ser PDF, DOC o DOCX',
                'allowedTypes' => FileUtil::ALLOWED_DOC_TYPES,
                'maxFileSize' => FileUtil::MAX_FILE_SIZE_DEFAULT, // 1 MB
                'fileTypeMessage' => self::INVALID_EXTENSION,
                'fileSizeMessage' => self::INVALID_FILE_SIZE_1MB
            ]
        ];
    }

    /**
     * Update area description from code to full description
     *
     * @param string $area Area code
     * @return string Area description
     */
    private static function getAreaDescription(string $area): string {
        return match ($area) {
            'com' => 'Comercial',
            'sal' => 'Ventas - Compras',
            'mar' => 'Mercadotecnia - Finanzas',
            'acc' => 'Contabilidad - Logística',
            'tra' => 'Transporte - Operaciones',
            'war' => 'Almacén - Mantenimiento - Regulatorio',
            'qua' => 'Calidad - Recursos Humanos',
            'bil' => 'Capacitación - Facturación',
            'col' => 'Cobranza',
            default => 'Desconocida'
        };
    }

}