<?php

/**
 * reCAPTCHA configuration
 */
class RecaptchaConfig {

    use ParamTrait;
    private ParamWebService $paramWebService;

    public function __construct() {
        $this->paramWebService = new ParamWebService();
    }

    public function getRecaptchaConfig():array {
        $codes = ["CAPTCHA_SITE_KEY", "CAPTCHA_SECRET_KEY"];
        $params = $this->paramWebService->getParamsByCode($codes) ?? [];
        $paramsMap = $this->mapParams($params);
        return [
            'site_key' => $paramsMap['CAPTCHA_SITE_KEY'] ?? '',
            'secret_key' => $paramsMap['CAPTCHA_SECRET_KEY'] ?? '',
            'version' => 'v2'
        ];
    }
}