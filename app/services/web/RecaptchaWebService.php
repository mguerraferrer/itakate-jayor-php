<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * reCAPTCHA Validation Service
 * Handles validation of reCAPTCHA tokens
 */
class RecaptchaWebService {

    private RecaptchaConfig $recaptchaConfig;
    private string $siteKey;
    private string $secretKey;
    private string $version;

    public function __construct() {
        $this->recaptchaConfig = new RecaptchaConfig();
        $this->initializeRecaptcha();
    }

    private function initializeRecaptcha(): void {
        $config = $this->recaptchaConfig->getRecaptchaConfig();
        $this->siteKey = $config['site_key'];
        $this->secretKey = $config['secret_key'];
        $this->version = $config['version'];
    }

    /**
     * Get the site key (public key) for HTML rendering
     *
     * @return string
     */
    public function getSiteKey(): string {
        return $this->siteKey;
    }

    /**
     * Get reCAPTCHA version
     *
     * @return string
     */
    public function getVersion(): string {
        return $this->version;
    }

    /**
     * Verify reCAPTCHA token with Google's verification endpoint
     *
     * @param string $token The reCAPTCHA token from a client
     * @return array ['success' => bool, 'message' => string, 'errors' => array]
     */
    public function verify(string $token): array {
        // Check if keys are configured
        if (!$this->isConfigured()) {
            return [
                'success' => false,
                'message' => 'reCAPTCHA no está configurado correctamente',
                'errors' => []
            ];
        }

        if (empty($token)) {
            return [
                'success' => false,
                'message' => 'Token de reCAPTCHA no proporcionado',
                'errors' => []
            ];
        }

        try {
            $url = 'https://www.google.com/recaptcha/api/siteverify';
            $postData = [
                'secret' => $this->secretKey,
                'response' => $token
            ];

            // Initialize cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postData));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode !== 200) {
                return [
                    'success' => false,
                    'message' => 'Error comunicándose con Google reCAPTCHA',
                    'errors' => []
                ];
            }

            $result = json_decode($response, true);

            if (!empty($result['success'])) {
                return [
                    'success' => true,
                    'message' => 'reCAPTCHA validado correctamente',
                    'errors' => []
                ];
            }

            return [
                'success' => false,
                'message' => 'Falló la validación de reCAPTCHA',
                'errors' => $result['error-codes'] ?? []
            ];
        } catch (Exception $e) {
            return [
                'success' => false,
                'message' => 'Error validando reCAPTCHA: ' . $e->getMessage(),
                'errors' => []
            ];
        }
    }

    /**
     * Check if reCAPTCHA is properly configured
     *
     * @return bool
     */
    public function isConfigured(): bool {
        return $this->siteKey !== 'YOUR_SITE_KEY_HERE' && 
               $this->secretKey !== 'YOUR_SECRET_KEY_HERE';
    }
}