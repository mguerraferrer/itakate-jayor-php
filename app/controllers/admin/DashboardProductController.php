<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Product Dashboard Controller
 */
class DashboardProductController {

    use DashboardTrait;
    private DashboardProductService $dashboardProductService;
    private DashboardProductExportService $exportService;

    public function __construct() {
        $this->dashboardProductService = new DashboardProductService();
        $this->exportService = new DashboardProductExportService();
    }

    /**
     * Get top 10 products by month and year
     * 
     * @param string $monthYear Month and year in format mm/yyyy
     * @param int $initialLoad Flag indicating if it's the initial load
     * @return array Response with product reports data or error message
     */
    public function loadTop10(string $monthYear = '', int $initialLoad = 0): ?array {
        try {
            $topTen = [];
            if ($initialLoad === 1) {
                $topTen['general'] = $this->dashboardProductService->getTop10General();
            }
            
            $topTen['monthly'] = $this->dashboardProductService->getTop10ByMonthYear($monthYear);            
            return Response::listSource($topTen);
        } catch (Exception $e) {
            return Response::error('Error al obtener los reportes de productos: ' . $e->getMessage());
        }
    }

    /**
     * Export products to Excel (.xlsx format)
     * 
     * @param string $reportType Type of report ('general' or 'monthly')
     * @param string $monthYear Month and year in format mm/yyyy (for monthly report)
     * @return void Outputs XLSX file for download
     */
    public function exportToExcel(string $reportType = '', string $monthYear = ''): void {
        try {
            if ($reportType === 'general') {
                $data = $this->dashboardProductService->getTop10General();
            } else if ($reportType === 'monthly') {
                $data = $this->dashboardProductService->getTop10ByMonthYear($monthYear);
                if (!empty($monthYear)) {
                    [$month, $year] = explode('/', $monthYear);
                    $monthYear = DateTimeUtil::getMonthNameInSpanish((int)$month) . " " . $year;
                } else {
                    $monthYear = DateTimeUtil::getCurrentMonthNameInSpanish() . " " . DateTimeUtil::now()->format('Y');
                }                
            } else {
                throw new Exception('Tipo de reporte no válido');
            }

            if (empty($data)) {
                throw new Exception('No hay datos disponibles para exportar');
            }
            
            $this->exportService->generateXlsxFile($data, $reportType, $monthYear);
        } catch (Exception $e) {
            // Handle export errors (you can log the error or return a response)
            error_log('Error al exportar el reporte de productos: ' . $e->getMessage());
        }
    }
    
}