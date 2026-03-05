<?php

/**
 * Mail configuration
 */
class MailConfig {

    use ParamTrait;
    private ParamWebService $paramWebService;

    public function __construct() {
        $this->paramWebService = new ParamWebService();
    }

    public function getMailConfig():array {
        $codes = [
            "MAIL_HOST", "MAIL_PORT", "MAIL_PROTOCOL", "MAIL_USERNAME", "MAIL_PASSWORD",
            "EMAIL_PHARMA_RECIPIENT", "EMAIL_SALES_RECIPIENT", "EMAIL_VACANCY_RECIPIENT",
            "MAIL_FROM_NAME"
        ];
        $params = $this->paramWebService->getParamsByCode($codes) ?? [];
        $paramsMap = $this->mapParams($params);
        return [
            'host' => $paramsMap['MAIL_HOST'],
            'port' => (int)$paramsMap['MAIL_PORT'],
            'username' => $paramsMap['MAIL_USERNAME'],
            'password' => $paramsMap['MAIL_PASSWORD'],
            'fromEmail' => $paramsMap['MAIL_USERNAME'],
            'fromName' => $paramsMap['MAIL_FROM_NAME'],
            'pharmaRecipient' => $paramsMap['EMAIL_PHARMA_RECIPIENT'],
            'salesRecipient' => $paramsMap['EMAIL_SALES_RECIPIENT'],
            'vacancyRecipient' => $paramsMap['EMAIL_VACANCY_RECIPIENT']
        ];
    }
}