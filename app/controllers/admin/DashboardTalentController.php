<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Talent Dashboard Controller
 */
class DashboardTalentController {

    use DashboardTrait;
    private DashboardTalentService $dashboardTalentService;

    public function __construct() {
        $this->dashboardTalentService = new DashboardTalentService();
    }

    /**
     * Save talent data to the database
     * 
     * @return void
     */
    public function saveTalentEntry(): void {
        try {
            $this->dashboardTalentService->saveTalentEntry();
        } catch (Exception $e) {
            error_log('Error al guardar los datos de talento: ' . $e->getMessage());
        }
    }

    /**
     * Get talent data by month and year
     * 
     * @param string $monthYear Month and year (mm/yyyy)
     * @param int $initialLoad Flag indicating if it's the initial load
     * @return array Response with talent data or error message
     */
    public function getTalentDataByMonthYear(string $monthYear = '', int $initialLoad = 0): ?array {
        try {
            $monthTalent = [];
            if ($initialLoad === 1) {
                $monthTalent['talent'] = $this->dashboardTalentService->getHistoricalCount();
            }
            
            $talentReports = $this->dashboardTalentService->getTalentEntriesByMonthYear($monthYear);
            $talentReports = $this->formatDates($talentReports);
            return Response::listSource($talentReports, $monthTalent);
        } catch (Exception $e) {
            return Response::error('Error al obtener los reportes de datos de talento: ' . $e->getMessage());
        }
    }
    
}