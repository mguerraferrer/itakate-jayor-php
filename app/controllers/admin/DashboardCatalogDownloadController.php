<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Catalog Download Controller
 */
class DashboardCatalogDownloadController {

    use DashboardTrait;
    private DashboardCatalogDownloadService $dashboardCatalogDownloadService;

    public function __construct() {
        $this->dashboardCatalogDownloadService = new DashboardCatalogDownloadService();
    }

    /**
     * Save a catalog download to the database
     * 
     * @return void
     */
    public function saveCatalogDownload(): void {
        try {
            $this->dashboardCatalogDownloadService->saveCatalogDownload();
        } catch (Exception $e) {
            error_log('Error al guardar la descarga de catálogo: ' . $e->getMessage());
        }
    }

    /**
     * Get catalog downloads by month and year
     * 
     * @param string $monthYear Month and year (mm/yyyy)
     * @param int $initialLoad Flag indicating if it's the initial load
     * @return array Response with catalog download data or error message
     */
    public function getCatalogDownloadsByMonthYear(string $monthYear = '', int $initialLoad = 0): ?array {
        try {
            $monthCatalog = [];
            if ($initialLoad === 1) {
                $monthCatalog['catalog'] = $this->dashboardCatalogDownloadService->getHistoricalCount();
            }
            
            $catalogReports = $this->dashboardCatalogDownloadService->getCatalogDownloadsByMonthYear($monthYear);
            $catalogReports = $this->formatDates($catalogReports);
            return Response::listSource($catalogReports, $monthCatalog);
        } catch (Exception $e) {
            return Response::error('Error al obtener los reportes de descargas de catálogo: ' . $e->getMessage());
        }
    }
    
}