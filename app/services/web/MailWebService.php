<?php

require_once __DIR__ . '/../../mail/PHPMailer/src/PHPMailer.php';
require_once __DIR__ . '/../../mail/PHPMailer/src/SMTP.php';
require_once __DIR__ . '/../../mail/PHPMailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Mail Web Service
 * Handles email sending operations
 */
class MailWebService {

    private MailConfig $mailConfig;
    private MailTemplateWebService $mailTemplateWebService;
    private $phpMailer;
    private array $config;

    /**
     * @throws Exception
     */
    public function __construct() {
        $this->mailConfig = new MailConfig();
        $this->mailTemplateWebService = new MailTemplateWebService();
        $this->config = $this->mailConfig->getMailConfig();
        $this->initializeMailer();
    }

    /**
     * Initialize PHPMailer instance
     *
     * @return void
     * @throws Exception
     */
    private function initializeMailer(): void {
        $this->phpMailer = new PHPMailer(true);
        try {
            // SMTP configuration
            $this->phpMailer->isSMTP();
            $this->phpMailer->Host = $this->config['host'];
            $this->phpMailer->Port = (int)$this->config['port'];
            $this->phpMailer->SMTPAuth = true;
            $this->phpMailer->Username = $this->config['username'];
            $this->phpMailer->Password = $this->config['password'];
            
            // Set encryption based on port
            if ($this->config['port'] == 465) {
                $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            } else {
                $this->phpMailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            }
            
            // Set SMTP properties (similar to Java configuration)
            $this->phpMailer->SMTPOptions = [
                'ssl' => [
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                ]
            ];
            
            // Set timeout
            $this->phpMailer->Timeout = 8;
            
            // Set default encoding
            $this->phpMailer->CharSet = PHPMailer::CHARSET_UTF8;
            
            // Debug mode
            $this->phpMailer->SMTPDebug = SMTP::DEBUG_OFF;
        } catch (Exception $e) {
            throw new Exception("Error initializing mail service: {$e->getMessage()}");
        }
    }

    /**
     * @throws Exception|\Exception
     */
    public function sendContactEmail(array $data): array {
        $addAddress = $this->config['salesRecipient'];
        $subject = "¡Contacto Jayor!";
        // Load and prepare HTML template
        $htmlBody = $this->mailTemplateWebService->getContactTemplate($data);
        // Set plain text alternative
        $plainText = $this->mailTemplateWebService->getContactTemplatePlainText($data);
        return $this->sendEmail($addAddress, $subject, $htmlBody, $plainText);
    }

    /**
     * @throws Exception|\Exception
     */
    public function sendResumeEmail(array $data, array $file): array {
        $addAddress = $this->config['vacancyRecipient'];
        $subject = "Solicitud de vacante";
        // Load and prepare HTML template
        $htmlBody = $this->mailTemplateWebService->getVacancyTemplate($data);
        // Set plain text alternative
        $plainText = $this->mailTemplateWebService->getVacancyTemplatePlainText($data);
        return $this->sendEmail($addAddress, $subject, $htmlBody, $plainText, $file);
    }

    /**
     * @throws Exception|\Exception
     */
    public function sendPharmaReport(array $data): array {
        $addAddress = $this->config['pharmaRecipient'];
        $subject = "Reporte de Farmacovigilancia";
        // Load and prepare HTML template
        $htmlBody = $this->mailTemplateWebService->getPharmaTemplate($data);
        // Set plain text alternative
        $plainText = $this->mailTemplateWebService->getPharmaTemplatePlainText($data);
        return $this->sendEmail($addAddress, $subject, $htmlBody, $plainText);
    }

    /**
     * @throws Exception|\Exception
     */
    public function sendQuotation(array $products, array $data): array {
        $subject = "Nueva Cotización - Folio " . $data['folio'];
        
        // Generate HTML and plain text versions
        $htmlBody = $this->mailTemplateWebService->getQuotationTemplate($products, $data);
        $plainText = $this->mailTemplateWebService->getQuotationTemplatePlainText($products, $data);

        // Send email to sales recipient
        $addAddress = $this->config['salesRecipient'];
        return $this->sendEmail($addAddress, $subject, $htmlBody, $plainText);
    }

    /**
     * Send contact form email
     *
     * @param string $addAddress Single email or multiple emails separated by commas
     * @param string $subject
     * @param string $htmlBody
     * @param string|null $plainText
     * @param array $file
     * @return array Response with success status and message
     */
    private function sendEmail(string $addAddress, string $subject, string $htmlBody, string $plainText = null, array $file = []): array {
        try {
            // Clear previous recipients and body
            $this->phpMailer->clearAllRecipients();
            $this->phpMailer->clearReplyTos();
            
            // Sender (from)
            $this->phpMailer->setFrom($this->config['fromEmail'], $this->config['fromName']);
            
            // Recipient (to) - Handle multiple addresses separated by commas
            $addresses = array_map('trim', explode(',', $addAddress));
            foreach ($addresses as $email) {
                if (!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $this->phpMailer->addAddress($email);
                }
            }
            
            // Subject
            $this->phpMailer->Subject = $subject;

            // Load and prepare HTML template
            $this->phpMailer->isHTML(true);
            $this->phpMailer->Body = $htmlBody;

            // Set plain text alternative
            if (!empty($plainText)) {
                $this->phpMailer->AltBody = $plainText;
            }

            // Attach file
            if (!empty($file) && $file['uploadFilePath'] && file_exists($file['uploadFilePath'])) {
                $originalName = basename($file['originalName']);
                $this->phpMailer->addAttachment($file['uploadFilePath'], $originalName);
            }

            // Send email
            $this->phpMailer->send();

            return [
                'success' => true,
                'message' => 'Correo enviado exitosamente'
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => "Error enviando el correo: {$e->getMessage()}"
            ];
        }
    }
}