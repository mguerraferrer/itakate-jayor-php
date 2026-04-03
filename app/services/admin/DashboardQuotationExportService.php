<?php
require_once __DIR__ . '/../../../autoload.php';

/**
 * Service for exporting dashboard quotation data to Excel format
 */
class DashboardQuotationExportService {

    use ExportTrait;

    /**
     * Generate XLSX file for user quotations using Office Open XML format
     * 
     * @param array $quotations Quotation data
     * @param string $range Date range text
     * @return void
     */
    public function generateQuotationUserXlsxFile(array $quotations, string $range): void {
        $sheetName = 'Cotizaciones Usuarios';
        $xlsxData = $this->xlsxBuilder($sheetName);
        $tempDir = $xlsxData['tempDir'];
        $worksheet = $xlsxData['worksheetContent'];              

        // Add range header (row 1)
        $worksheet .= '<row r="1">';
        $worksheet .= '<c r="A1" t="inlineStr"><is><t>' . htmlspecialchars($range) . '</t></is></c>';
        $worksheet .= '<c r="B1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="F1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="G1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="H1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="I1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="J1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="K1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="L1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="M1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="N1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="O1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="P1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="Q1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add empty row (row 2)
        $worksheet .= '<row r="2">';
        $worksheet .= '<c r="A2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="B2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="F2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="G2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="H2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="I2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="J2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="K2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="L2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="M2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="N2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="O2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="P2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="Q2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add headers (row 3)
        $worksheet .= '<row r="3">';
        $worksheet .= '<c r="A3" t="inlineStr"><is><t>Fecha</t></is></c>';
        $worksheet .= '<c r="B3" t="inlineStr"><is><t>Nombre</t></is></c>';
        $worksheet .= '<c r="C3" t="inlineStr"><is><t>Razón Social</t></is></c>';
        $worksheet .= '<c r="D3" t="inlineStr"><is><t>Correo electrónico</t></is></c>';
        $worksheet .= '<c r="E3" t="inlineStr"><is><t>RFC</t></is></c>';
        $worksheet .= '<c r="F3" t="inlineStr"><is><t>Celular</t></is></c>';
        $worksheet .= '<c r="G3" t="inlineStr"><is><t>Teléfono</t></is></c>';
        $worksheet .= '<c r="H3" t="inlineStr"><is><t>Uso</t></is></c>';
        $worksheet .= '<c r="I3" t="inlineStr"><is><t>Folio</t></is></c>';
        $worksheet .= '<c r="J3" t="inlineStr"><is><t>Calle</t></is></c>';
        $worksheet .= '<c r="K3" t="inlineStr"><is><t>No. Exterior</t></is></c>';
        $worksheet .= '<c r="L3" t="inlineStr"><is><t>No. Interior</t></is></c>';
        $worksheet .= '<c r="M3" t="inlineStr"><is><t>Colonia</t></is></c>';
        $worksheet .= '<c r="N3" t="inlineStr"><is><t>Estado</t></is></c>';
        $worksheet .= '<c r="O3" t="inlineStr"><is><t>País</t></is></c>';
        $worksheet .= '<c r="P3" t="inlineStr"><is><t>C.P</t></is></c>';
        $worksheet .= '<c r="Q3" t="inlineStr"><is><t>Comentarios</t></is></c>';
        $worksheet .= '</row>';

        // Add quotation data (starting from row 4)
        $rowNum = 4;
        foreach ($quotations as $quotation) {
            $date = $quotation['date'] ?? '';
            $name = $quotation['name'] ?? '';
            $businessName = $quotation['business_name'] ?? '';
            $email = $quotation['email'] ?? '';
            $rfc = $quotation['rfc'] ?? '';
            $mobile = $quotation['mobile'] ?? '';
            $phone = $quotation['phone'] ?? '';
            $usage = $quotation['usage'] ?? '';
            $folio = $quotation['folio'] ?? '';
            $street = $quotation['street'] ?? '';
            $exteriorNumber = $quotation['exterior_number'] ?? '';
            $interiorNumber = $quotation['interior_number'] ?? '';
            $neighborhood = $quotation['neighborhood'] ?? '';
            $state = $quotation['state'] ?? '';
            $country = $quotation['country'] ?? '';
            $postalCode = $quotation['postal_code'] ?? '';
            $comments = $quotation['comments'] ?? '';
            
            $worksheet .= '<row r="' . $rowNum . '">';
            $worksheet .= '<c r="A' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($date) . '</t></is></c>';
            $worksheet .= '<c r="B' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($name) . '</t></is></c>';
            $worksheet .= '<c r="C' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($businessName) . '</t></is></c>';
            $worksheet .= '<c r="D' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($email) . '</t></is></c>';
            $worksheet .= '<c r="E' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($rfc) . '</t></is></c>';
            $worksheet .= '<c r="F' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($mobile) . '</t></is></c>';
            $worksheet .= '<c r="G' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($phone) . '</t></is></c>';
            $worksheet .= '<c r="H' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($usage) . '</t></is></c>';
            $worksheet .= '<c r="I' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($folio) . '</t></is></c>';
            $worksheet .= '<c r="J' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($street) . '</t></is></c>';
            $worksheet .= '<c r="K' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($exteriorNumber) . '</t></is></c>';
            $worksheet .= '<c r="L' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($interiorNumber) . '</t></is></c>';
            $worksheet .= '<c r="M' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($neighborhood) . '</t></is></c>';
            $worksheet .= '<c r="N' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($state) . '</t></is></c>';
            $worksheet .= '<c r="O' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($country) . '</t></is></c>';
            $worksheet .= '<c r="P' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($postalCode) . '</t></is></c>';
            $worksheet .= '<c r="Q' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($comments) . '</t></is></c>';
            $worksheet .= '</row>';
            $rowNum++;
        }

        $worksheet .= '</sheetData>';
        
        // Add merged cells section for the header
        $worksheet .= '<mergeCells count="1">';
        $worksheet .= '<mergeCell ref="A1:Q1"/>';
        $worksheet .= '</mergeCells>';
        
        $worksheet .= '</worksheet>';
        file_put_contents($tempDir . '/xl/worksheets/sheet1.xml', $worksheet);

        // Create ZIP file
        $filename = 'Dashboard-Cotizacion-Usuario-' . $this->xlsxFileSuffix();
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

    /**
    * Generate XLSX file for product quotations using Office Open XML format
    * 
    * @param array $quotations Quotation item data
    * @param string $range Date range text
    * @return void
    */
    public function generateQuotationProductXlsxFile(array $quotations, string $range): void {
        $sheetName = 'Cotizaciones Productos';
        $xlsxData = $this->xlsxBuilder($sheetName);
        $tempDir = $xlsxData['tempDir'];
        $worksheet = $xlsxData['worksheetContent'];              

        // Add range header (row 1)
        $worksheet .= '<row r="1">';
        $worksheet .= '<c r="A1" t="inlineStr"><is><t>' . htmlspecialchars($range) . '</t></is></c>';
        $worksheet .= '<c r="B1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="F1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="G1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="H1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="I1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="J1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="K1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="L1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="M1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="N1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="O1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="P1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="Q1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="R1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="S1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="T1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="U1" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add empty row (row 2)
        $worksheet .= '<row r="2">';
        $worksheet .= '<c r="A2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="B2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="C2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="D2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="E2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="F2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="G2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="H2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="I2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="J2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="K2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="L2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="M2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="N2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="O2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="P2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="Q2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="R2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="S2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="T2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '<c r="U2" t="inlineStr"><is><t></t></is></c>';
        $worksheet .= '</row>';

        // Add headers (row 3)
        $worksheet .= '<row r="3">';
        $worksheet .= '<c r="A3" t="inlineStr"><is><t>Fecha</t></is></c>';
        $worksheet .= '<c r="B3" t="inlineStr"><is><t>Folio</t></is></c>';
        $worksheet .= '<c r="C3" t="inlineStr"><is><t>SKU</t></is></c>';
        $worksheet .= '<c r="D3" t="inlineStr"><is><t>Código</t></is></c>';
        $worksheet .= '<c r="E3" t="inlineStr"><is><t>Clave CB</t></is></c>';
        $worksheet .= '<c r="F3" t="inlineStr"><is><t>Factor Venta</t></is></c>';
        $worksheet .= '<c r="G3" t="inlineStr"><is><t>Registro Sanitario</t></is></c>';
        $worksheet .= '<c r="H3" t="inlineStr"><is><t>Color</t></is></c>';
        $worksheet .= '<c r="I3" t="inlineStr"><is><t>Presentación</t></is></c>';
        $worksheet .= '<c r="J3" t="inlineStr"><is><t>Capacidad</t></is></c>';
        $worksheet .= '<c r="K3" t="inlineStr"><is><t>Calibre</t></is></c>';
        $worksheet .= '<c r="L3" t="inlineStr"><is><t>Medida</t></is></c>';
        $worksheet .= '<c r="M3" t="inlineStr"><is><t>Tamaño</t></is></c>';
        $worksheet .= '<c r="N3" t="inlineStr"><is><t>Longitud</t></is></c>';
        $worksheet .= '<c r="O3" t="inlineStr"><is><t>Volumen</t></is></c>';
        $worksheet .= '<c r="P3" t="inlineStr"><is><t>Aguja</t></is></c>';
        $worksheet .= '<c r="Q3" t="inlineStr"><is><t>Dimensiones Bolsa</t></is></c>';
        $worksheet .= '<c r="R3" t="inlineStr"><is><t>Dimensiones Cuello</t></is></c>';
        $worksheet .= '<c r="S3" t="inlineStr"><is><t>Diámetro Guía</t></is></c>';
        $worksheet .= '<c r="T3" t="inlineStr"><is><t>Peso</t></is></c>';
        $worksheet .= '<c r="U3" t="inlineStr"><is><t>Cantidad</t></is></c>';
        $worksheet .= '</row>';

        // Add quotation product data (starting from row 4)
        $rowNum = 4;
        foreach ($quotations as $quotation) {
            $date = $quotation['date'] ?? '';
            $folio = $quotation['folio'] ?? '';
            $sku = $quotation['sku'] ?? '';
            $code = $quotation['code'] ?? '';
            $cbKey = $quotation['cb_key'] ?? '';
            $salesFactor = $quotation['sales_factor'] ?? '';
            $healthRegister = $quotation['health_register'] ?? '';
            $color = $quotation['color'] ?? '';
            $presentation = $quotation['presentation'] ?? '';
            $capacity = $quotation['capacity'] ?? '';
            $caliber = $quotation['caliber'] ?? '';
            $measure = $quotation['measure'] ?? '';
            $size = $quotation['size'] ?? '';
            $length = $quotation['length'] ?? '';
            $volume = $quotation['volume'] ?? '';
            $needle = $quotation['needle'] ?? '';
            $bagDimensions = $quotation['bag_dimensions'] ?? '';
            $neckDimensions = $quotation['neck_dimensions'] ?? '';
            $guideDiameter = $quotation['guide_diameter'] ?? '';
            $weight = $quotation['weight'] ?? '';
            $quantity = $quotation['quantity'] ?? 0;
            
            $worksheet .= '<row r="' . $rowNum . '">';
            $worksheet .= '<c r="A' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($date) . '</t></is></c>';
            $worksheet .= '<c r="B' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($folio) . '</t></is></c>';
            $worksheet .= '<c r="C' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($sku) . '</t></is></c>';
            $worksheet .= '<c r="D' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($code) . '</t></is></c>';
            $worksheet .= '<c r="E' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($cbKey) . '</t></is></c>';
            $worksheet .= '<c r="F' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($salesFactor) . '</t></is></c>';
            $worksheet .= '<c r="G' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($healthRegister) . '</t></is></c>';
            $worksheet .= '<c r="H' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($color) . '</t></is></c>';
            $worksheet .= '<c r="I' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($presentation) . '</t></is></c>';
            $worksheet .= '<c r="J' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($capacity) . '</t></is></c>';
            $worksheet .= '<c r="K' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($caliber) . '</t></is></c>';
            $worksheet .= '<c r="L' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($measure) . '</t></is></c>';
            $worksheet .= '<c r="M' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($size) . '</t></is></c>';
            $worksheet .= '<c r="N' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($length) . '</t></is></c>';
            $worksheet .= '<c r="O' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($volume) . '</t></is></c>';
            $worksheet .= '<c r="P' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($needle) . '</t></is></c>';
            $worksheet .= '<c r="Q' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($bagDimensions) . '</t></is></c>';
            $worksheet .= '<c r="R' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($neckDimensions) . '</t></is></c>';
            $worksheet .= '<c r="S' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($guideDiameter) . '</t></is></c>';
            $worksheet .= '<c r="T' . $rowNum . '" t="inlineStr"><is><t>' . htmlspecialchars($weight) . '</t></is></c>';
            $worksheet .= '<c r="U' . $rowNum . '"><v>' . $quantity . '</v></c>';
            $worksheet .= '</row>';
            $rowNum++;
        }

        $worksheet .= '</sheetData>';
        
        // Add merged cells section for the header
        $worksheet .= '<mergeCells count="1">';
        $worksheet .= '<mergeCell ref="A1:U1"/>';
        $worksheet .= '</mergeCells>';
        
        $worksheet .= '</worksheet>';
        file_put_contents($tempDir . '/xl/worksheets/sheet1.xml', $worksheet);

        // Create ZIP file
        $filename = 'Dashboard-Cotizacion-Producto-' . $this->xlsxFileSuffix();
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