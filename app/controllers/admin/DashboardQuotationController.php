<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Quotation Controller
 */
class DashboardQuotationController {

    use DashboardTrait;
    private DashboardQuotationService $dashboardQuotationService;
    private DashboardQuotationItemService $dashboardQuotationItemService;
    private DashboardQuotationExportService $exportService;

    public function __construct() {
        $this->dashboardQuotationService = new DashboardQuotationService();
        $this->dashboardQuotationItemService = new DashboardQuotationItemService();
        $this->exportService = new DashboardQuotationExportService();
    }

    /**
     * Get quotations by current month
     * 
     * @return array Response with quotations data or error message
     */
    public function getQuotations(): ?array {
        try {
            // Get current month name in Spanish
            $month['currentMonth'] = DateTimeUtil::getCurrentMonthNameInSpanish();
            
            // Get user quotations
            $userQuotations = $this->dashboardQuotationService->getQuotationByDateRange();
            $quotation['users'] = $this->formatDates($userQuotations);

            // Get product quotations
            $productQuotations = $this->dashboardQuotationItemService->getQuotationItemsByDateRange();
            $quotation['products'] = $this->formatDates($productQuotations);

            return Response::listSource($quotation, $month);
        } catch (Exception $e) {
            return Response::error('Error al obtener las cotizaciones: ' . $e->getMessage());
        }    
    }

    /**
     * Get user quotations by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array Response with quotations data or error message
     */
    public function getUserQuotations(string $startDate = '', string $endDate = ''): ?array {
        try {            
            $quotations = $this->dashboardQuotationService->getQuotationByDateRange($startDate, $endDate);
            $quotations = $this->formatDates($quotations);
            return Response::listSource($quotations);
        } catch (Exception $e) {
            return Response::error('Error al obtener las cotizaciones de usuarios: ' . $e->getMessage());
        }    
    }

    /**
     * Get product quotations by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array Response with quotations data or error message
     */
    public function getProductQuotations(string $startDate = '', string $endDate = ''): ?array {
        try {
            $quotations = $this->dashboardQuotationItemService->getQuotationItemsByDateRange($startDate, $endDate);
            $quotations = $this->formatDates($quotations);
            return Response::listSource($quotations);
        } catch (Exception $e) {
            return Response::error('Error al obtener las cotizaciones de productos: ' . $e->getMessage());
        }    
    }

    /**
     * Export contacts to Excel (.xlsx format)
     * 
     * @param string $reportType Report type ('user' or 'product')
     * @param string $startDate Start date (Y-m-d) 
     * @param string $endDate End date (Y-m-d)
     * @return void Outputs XLSX file for download
     */
    public function exportToExcel(string $reportType = '', string $startDate = '', string $endDate = ''): void {
        try {
            if ($reportType === 'user') {
                $quotations = $this->dashboardQuotationService->getQuotationReportData($startDate, $endDate);
            } else if ($reportType === 'product'){
                $quotations = $this->dashboardQuotationItemService->getQuotationItemsReportData($startDate, $endDate);
            } else {
                throw new Exception('Tipo de reporte no válido');
            }

            $quotations = $this->formatDates($quotations);
            
            // Determine date range text
            $range = "Mes: " . DateTimeUtil::getCurrentMonthNameInSpanish() . " " . DateTimeUtil::now()->format('Y');
            if (!empty($startDate) && !empty($endDate)) {
                $range = "Rango de fechas: " . DateTimeUtil::formatDate($startDate, 'd/m/Y') . " - " . DateTimeUtil::formatDate($endDate, 'd/m/Y');
            }

            // Generate XLSX content using export service
            if ($reportType === 'user') {
                $this->exportService->generateQuotationUserXlsxFile($quotations, $range);
            } else if ($reportType === 'product') {
                $this->exportService->generateQuotationProductXlsxFile($quotations, $range);
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Error al generar el reporte: ' . $e->getMessage();
            exit;
        }
    }
    
}