<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Social Network Controller
 */
class DashboardSocialController {

    use DashboardTrait;
    private DashboardSocialService $dashboardSocialService;

    public function __construct() {
        $this->dashboardSocialService = new DashboardSocialService();
    }

    /**
     * Save a social network interaction to the database
     * 
     * @param string $social Social network identifier (F, Y, L, W)
     * @return void
     */
    public function saveSocial(string $social): void {
        try {
            $this->dashboardSocialService->saveSocial($social);
        } catch (Exception $e) {
            // Log the error or handle it as needed
            error_log('Error al guardar la interacción social: ' . $e->getMessage());
        }
    }

    /**
     * Get social network interactions by month and year
     * 
     * @param string $monthYear Month and year (mm/yyyy)
     * @param int $initialLoad Flag indicating if it's the initial load
     * @return array Response with social network reports data or error message
     */
    public function getSocialNetworksCounts(string $monthYear = '', int $initialLoad = 0): ?array {
        try {
            $monthSocial = [];
            if ($initialLoad === 1) {
                $monthSocial['facebook'] = $this->dashboardSocialService->getHistoricalCount('f');
                $monthSocial['whatsapp'] = $this->dashboardSocialService->getHistoricalCount('w');
                $monthSocial['linkedin'] = $this->dashboardSocialService->getHistoricalCount('l');
                $monthSocial['youtube'] = $this->dashboardSocialService->getHistoricalCount('y');
            }
            
            $socialReports = $this->dashboardSocialService->getSocialByMonthYear($monthYear);
            $socialReports = $this->formatDates($socialReports);
            return Response::listSource($socialReports, $monthSocial);
        } catch (Exception $e) {
            return Response::error('Error al obtener los reportes de redes sociales: ' . $e->getMessage());
        }
    }
    
}