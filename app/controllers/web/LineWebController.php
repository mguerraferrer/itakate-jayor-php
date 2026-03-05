<?php
require_once __DIR__ . '/../../../autoload.php';

class LineWebController {

    private LineWebService $lineWebService;

    public function __construct() {
        $this->lineWebService = new LineWebService();
    }

    /**
     * Get all active lines
     *
     * @return array Array of active lines
     */
    public function getLines(): array {
        try {
            return $this->lineWebService->getLines() ?? [];
        } catch (Exception $e) {
            error_log("LineWebService::getLines - Exception: " . $e->getMessage());
            return [];
        }
    }

}