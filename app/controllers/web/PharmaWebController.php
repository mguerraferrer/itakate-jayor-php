<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Contact Controller
 */
class PharmaWebController {

    private MailWebService $mailWebService;

    public function __construct() {
        $this->mailWebService = new MailWebService();
    }

    public function validateStep(int $step, array $data): array {
        try {
            $rules = $this->getValidationRules($step);
            $validation = Validator::validateFields($data, $rules);
            if (!$validation['success']) {
                return $validation; // Return validation errors
            }

            if ($step !== 4) {
                return Response::success('Step success');
            }

            $cleanData = [
                // Step 1
                'name' => trim($data['name']),
                'plName' => trim($data['plName']),
                'mlName' => trim($data['mlName']),
                'phone' => trim($data['phone']),
                'email' => trim($data['email']),
                'personType' => self::getPersonType(trim($data['personType'])),
                // Step 2
                'product' => trim($data['product']),
                'lote' => trim($data['lote']),
                'dueDate' => trim($data['dueDate']),
                'genericName' => trim($data['genericName']),
                'dose' => trim($data['dose']),
                'admWay' => trim($data['admWay']),
                'brand' => trim($data['brand']),
                'healthRegister' => trim($data['healthRegister']),
                'productUse' => self::getValue($data['productUseYes'], $data['productUseNo']),
                'startDate' => trim($data['startDate']),
                'endDate' => trim($data['endDate']),
                'reasonUse' => trim($data['reasonUse']),
                'otherDrug' => trim($data['otherDrug']),
                // Step 3
                'eventHappened' => trim($data['eventHappened']),
                'eventStartDate' => trim($data['eventStartDate']),
                'eventEndDate' => trim($data['eventEndDate']),
                'eventUse' => self::getValue($data['eventUseYes'], $data['eventUseNo']),
                'eventType' => self::getEventType(trim($data['eventType'])),
                // Step 4
                'patName' => trim($data['patName']),
                'patPlName' => trim($data['patPlName']),
                'patMlName' => trim($data['patMlName']),
                'gender' => self::getGender(trim($data['gender'])),
                'birthDate' => trim($data['birthDate']),
                'pregnancy' => self::getValue($data['pregnancyYes'], $data['pregnancyNo']),
                'height' => trim($data['height']),
                'weight' => trim($data['weight']),
                'doctorPrescribe' => self::getValue($data['doctorPrescribeYes'], $data['doctorPrescribeNo']),
                'patPhone' => trim($data['patPhone']),
                'patEmail' => trim($data['patEmail'])
            ];

            $sent = $this->mailWebService->sendPharmaReport($cleanData);
            $mailSent = ['mailSent' => (bool) $sent['success']];
            $responseMessage = $sent['success']
                ? 'Muchas gracias por enviar el reporte. En breve estaremos dándole seguimiento'
                : 'No se ha podido enviar el formulario de contacto. Por favor, intenta más tarde';
            return $sent['success']
                ? Response::success($responseMessage, $mailSent)
                : Response::error($responseMessage);
        } catch (Exception $e) {
            return Response::error('Error al enviar el formulario de contacto: ' . $e->getMessage());
        }
    }

    /**
     * Validation rules for a contact message
     *
     * @return array Validation rules
     */
    private function getValidationRules(int $step): array {
        if ($step === 1) {
            return [
                'name' => ['required' => true],
                'plName' => ['required' => true],
                'mlName' => ['required' => true],
                'phone' => ['required' => true, 'length' => 10],
                'email' => ['required' => true, 'type' => 'email'],
                'personType' => [
                    'required' => true,
                    'enum' => ['values' => ['doc', 'nur', 'pha', 'pat', 'fam'], 'frontEndField' => 'Tipo de persona'],
                    'message' => 'El tipo de persona es requerida'
                ]
            ];
        } else if ($step === 2) {
            return [
                'product' => ['required' => true],
                'lote' => ['required' => true]
            ];
        } else if ($step === 3) {
            return [
                'eventHappened' => ['required' => true],
                'eventType' => [
                    'required' => false,
                    'enum' => ['values' => ['none', 'death', 'hosp', 'inability', 'alter'], 'frontEndField' => 'Tipo de evento'],
                ],
                'patPhone' => ['required' => false, 'length' => 10],
            ];
        } else if ($step === 4) {
            return [
                'patName' => ['required' => true],
                'patPlName' => ['required' => true],
                'gender' => [
                    'required' => false,
                    'enum' => ['values' => ['female', 'male'], 'frontEndField' => 'Género'],
                    'message' => 'El tipo de persona es requerida'
                ]
            ];
        }
        return [];
    }

    /**
     * Get person type description from code
     *
     * @param string $personType Person type code
     * @return string Person type description
     */
    private static function getPersonType(string $personType): string {
        if(empty($personType)) {
            return '';
        }

        return match ($personType) {
            'doc' => 'Médico',
            'nur' => 'Enfermera',
            'pha' => 'Farmacéutico',
            'pat' => 'Paciente',
            'fam' => 'Familiar',
            default => 'Desconocida'
        };
	}

    /**
     * Get event type description from code
     *
     * @param string $eventType Event type code
     * @return string Event type description
     */
    private static function getEventType(string $eventType): string {
        if(empty($eventType)) {
            return '';
        }

        return match ($eventType) {
            'none' => 'Ninguna',
            'death' => 'Muerte',
            'hosp' => 'Hospitalización o Prolonga la hospitalización',
            'inability' => 'Invalidez o De incapacidad',
            'alter' => 'Alteraciones o malformaciones en el recién nacido',
            default => 'Desconocido'
        };
	}

    /**
     * Get gender description from code
     *
     * @param string $gender Gender code
     * @return string Gender description
     */
	private static function getGender(string $gender): string {
        if(empty($gender)) {
            return '';
        }

        return match ($gender) {
            'female' => 'Femenino',
            'male' => 'Masculino',
            default => 'Desconocido'
        };
	}

    private static function getValue(int $yesValue, int $noValue): string {
        if (empty($yesValue) && empty($noValue)) {
            return '';
        } else if (!empty($yesValue)) {
            return 'Sí';
        }
        return 'No';
    }
}