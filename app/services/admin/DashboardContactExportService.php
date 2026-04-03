<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Service for exporting dashboard contact data to Excel format
 */
class DashboardContactExportService {

    use ExportTrait;

    /**
     * Generate XLSX file using Office Open XML format
     * 
     * @param array $contacts Contact data
     * @param string $range Date range text
     * @return void
     */
    public function generateXlsxFile(array $contacts, string $range): void {        
        $sheetName = 'Dashboard Contacto';
        $xlsxData = $this->xlsxBuilder($sheetName);
        $tempDir = $xlsxData['tempDir'];
        $worksheet = $xlsxData['worksheetContent'];              

        // Add range header (row 1)
        $worksheet .= '<row r="1">';
        $worksheet .= '<c r="A1" t="inlineStr"><is><t>' . htmlspecialchars($range) . '</t></is></c>';
        $worksheet .= '<c r="B1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add empty row (row 2)
        $worksheet .= '<row r="2">';
        $worksheet .= '<c r="A2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="B2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add headers (row 3)
        $worksheet .= '<row r="3">';
        $worksheet .= '<c r="A3" t="inlineStr"><is><t>Fecha</t></is></c>';
        $worksheet .= '<c r="B3" t="inlineStr"><is><t>Nombre</t></is></c>';
        $worksheet .= '<c r="C3" t="inlineStr"><is><t>Correo electrónico</t></is></c>';
        $worksheet .= '</row>';

        // Add contact data (starting from row 4)
        $rowNum = 4;
        foreach ($contacts as $contact) {
            $date = DateTimeUtil::formatDate($contact['date'] ?? '', 'd/m/Y');
            $name = $contact['name'] ?? '';
            $email = $contact['email'] ?? '';
            
            $worksheet .= '<row r="' . $rowNum . '">';
            $worksheet .= '<c r="A' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($date) . '</t></is></c>';
            $worksheet .= '<c r="B' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($name) . '</t></is></c>';
            $worksheet .= '<c r="C' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($email) . '</t></is></c>';
            $worksheet .= '</row>';
            $rowNum++;
        }

        $worksheet .= '</sheetData>';
        
        // Add merged cells section for the header
        $worksheet .= '<mergeCells count="1">';
        $worksheet .= '<mergeCell ref="A1:C1"/>';
        $worksheet .= '</mergeCells>';
        
        $worksheet .= '</worksheet>';
        file_put_contents($tempDir . '/xl/worksheets/sheet1.xml', $worksheet);

        // Create ZIP file
        $filename = 'Dashboard-Contacto-' . $this->xlsxFileSuffix();
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