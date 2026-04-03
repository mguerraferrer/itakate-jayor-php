<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Pharmacovigilance Controller
 */
class DashboardPharmaController {

    use DashboardTrait;
    private DashboardPharmaService $dashboardPharmaService;

    public function __construct() {
        $this->dashboardPharmaService = new DashboardPharmaService();
    }

    /**
     * Get pharmacovigilance reports by month/year
     * 
     * @param string $monthYear Month/Year (mm/yyyy)
     * @param int $initialLoad Initial load flag
     * @return array Response with pharmacovigilance reports data or error message
     */
    public function getPharmaList(string $monthYear = '', int $initialLoad = 0): ?array {
        try {
            $monthPharma = [];
            if ($initialLoad === 1) {
                $currentMonthPharma = $this->dashboardPharmaService->getCountByCurrentMonth();
                $monthPharma['month'] = DateTimeUtil::getCurrentMonthNameInSpanish();
                $monthPharma['totalMonth'] = $currentMonthPharma;
            }
            
            $pharmaReports = $this->dashboardPharmaService->getPharmaByMonthYear($monthYear);
            $pharmaReports = $this->formatDates($pharmaReports);
            return Response::listSource($pharmaReports, $monthPharma);
        } catch (Exception $e) {
            return Response::error('Error al obtener los reportes de farmacovigilancia: ' . $e->getMessage());
        }
    }
    
}