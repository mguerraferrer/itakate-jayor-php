<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Service for exporting dashboard product data to Excel format
 */
class DashboardProductExportService {

    use ExportTrait;

    /**
     * Generate XLSX file using Office Open XML format
     * 
     * @param array $products Product data
     * @param string $reportType Type of report ('general' or 'monthly')
     * @param string $monthYear Month and year in format mm/yyyy (for monthly report)
     * @return void
     */
    public function generateXlsxFile(array $products, string $reportType, string $monthYear): void {        
        $sheetName = 'Dashboard Producto';
        $xlsxData = $this->xlsxBuilder($sheetName);
        $tempDir = $xlsxData['tempDir'];
        $worksheet = $xlsxData['worksheetContent'];

        // Add title header (row 1)
        $headerTitle = $reportType === 'general' 
            ? 'Top 10 General' 
            : 'Top 10 Mensual: ' . $monthYear;
        
        $worksheet .= '<row r="1">';
        $worksheet .= '<c r="A1" t="inlineStr"><is><t>' . htmlspecialchars($headerTitle) . '</t></is></c>';
        $worksheet .= '<c r="B1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add empty row (row 2)
        $worksheet .= '<row r="2">';
        $worksheet .= '<c r="A2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="B2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add headers (row 3)
        $worksheet .= '<row r="3">';
        $worksheet .= '<c r="A3" t="inlineStr"><is><t>SKU</t></is></c>';
        $worksheet .= '<c r="B3" t="inlineStr"><is><t>Código</t></is></c>';
        $worksheet .= '<c r="C3" t="inlineStr"><is><t>Línea</t></is></c>';
        $worksheet .= '<c r="D3" t="inlineStr"><is><t>Marca</t></is></c>';
        $worksheet .= '<c r="E3" t="inlineStr"><is><t>Cantidad (piezas)</t></is></c>';
        $worksheet .= '</row>';

        // Add product data (starting from row 4)
        $rowNum = 4;
        foreach ($products as $product) {
            $sku = $product['sku'] ?? '';
            $code = $product['code'] ?? '';
            $lineName = $product['line_name'] ?? '';
            $brandName = $product['brand_name'] ?? '';
            $quantityTotal = $product['quantity_total'] ?? 0;
            
            $worksheet .= '<row r="' . $rowNum . '">';
            $worksheet .= '<c r="A' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($sku) . '</t></is></c>';
            $worksheet .= '<c r="B' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($code) . '</t></is></c>';
            $worksheet .= '<c r="C' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($lineName) . '</t></is></c>';
            $worksheet .= '<c r="D' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($brandName) . '</t></is></c>';
            $worksheet .= '<c r="E' . $rowNum . '"><v>' . $quantityTotal . '</v></c>';
            $worksheet .= '</row>';
            $rowNum++;
        }

        $worksheet .= '</sheetData>';
        
        // Add merged cells section for the header
        $worksheet .= '<mergeCells count="1">';
        $worksheet .= '<mergeCell ref="A1:E1"/>';
        $worksheet .= '</mergeCells>';
        
        $worksheet .= '</worksheet>';
        file_put_contents($tempDir . '/xl/worksheets/sheet1.xml', $worksheet);

        // Create ZIP file
        $suffix = $reportType === 'general' ? 'General-'  . $this->xlsxFileSuffix() : 'Mensual-' . $this->xlsxFileSuffix();
        $filename = 'Dashboard-Product-Top10-' . $suffix;
        $zip = new ZipArchive();
        $zipPath = sys_get_temp_dir() . '/' . $filename;
        
        if ($zip->open($zipPath, ZipArchive::CREATE) !== TRUE) {
            throw new Exception('No se puede crear el archivo ZIP');
        }

        // Add files to ZIP
        $this->addDirectoryToZip($tempDir, $zip, '');
        $zip->close();

        // Clean up temporary directory
        $this->deleteDirectory($tempDir);

        // Output file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Content-Length: ' . filesize($zipPath));
        
        readfile($zipPath);
        unlink($zipPath);
        exit;
    }

}