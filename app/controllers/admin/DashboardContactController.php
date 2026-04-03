<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Contact Controller
 */
class DashboardContactController {

    use DashboardTrait;
    private DashboardContactService $dashboardContactService;
    private DashboardContactExportService $exportService;

    public function __construct() {
        $this->dashboardContactService = new DashboardContactService();
        $this->exportService = new DashboardContactExportService();
    }

    /**
     * Get contacts by date range
     * 
     * @param string $startDate Start date (Y-m-d)
     * @param string $endDate End date (Y-m-d)
     * @return array Response with contacts data or error message
     */
    public function getContacts(string $startDate = '', string $endDate = '', int $initialLoad = 0): ?array {
        try {
            $monthContacts = [];
            if ($initialLoad === 1) {
                $currentMonthContacts = $this->dashboardContactService->getCountContactsByCurrentMonth();
                $monthContacts['month'] = DateTimeUtil::getCurrentMonthNameInSpanish();
                $monthContacts['totalMonth'] = $currentMonthContacts;
            }
            
            $contacts = $this->dashboardContactService->getContactsByDateRange($startDate, $endDate);
            $contacts = $this->formatDates($contacts);
            return Response::listSource($contacts, $monthContacts);
        } catch (Exception $e) {
            return Response::error('Error al obtener los contactos: ' . $e->getMessage());
        }
    }

    /**
     * Export contacts to Excel (.xlsx format)
     * 
     * @param string $startDate Start date (Y-m-d) 
     * @param string $endDate End date (Y-m-d)
     * @return void Outputs XLSX file for download
     */
    public function exportToExcel(string $startDate = '', string $endDate = ''): void {
        try {
            // Get contacts data
            $contacts = $this->dashboardContactService->getContactsByDateRange($startDate, $endDate);
            $contacts = $this->formatDates($contacts);
            
            // Determine date range text
            $range = "Mes: " . DateTimeUtil::getCurrentMonthNameInSpanish() . " " . DateTimeUtil::now()->format('Y');            
            if (!empty($startDate) && !empty($endDate)) {
                $range = "Rango de fechas: " . DateTimeUtil::formatDate($startDate, 'd/m/Y') . " - " . DateTimeUtil::formatDate($endDate, 'd/m/Y');
            }

            // Generate XLSX content using export service
            $this->exportService->generateXlsxFile($contacts, $range);            
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Error al generar el reporte: ' . $e->getMessage();
            exit;
        }
    }
    
}