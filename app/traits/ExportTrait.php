<?php

/**
 * ExportTrait
 * Common functionality for export services
 */
trait ExportTrait {

    /**
     * Generate XLSX file suffix based on current date and time
     * 
     * @return string XLSX file suffix
     */
    protected function xlsxFileSuffix(): string {
        return DateTimeUtil::now()->format('YmdHi') . '.xlsx';
    }

    /**
     * Build XLSX file structure and return temporary directory and initial worksheet content
     * 
     * @param string $sheetName Name of the worksheet
     * @return array Array containing 'tempDir' and 'worksheetContent'
     */
    protected function xlsxBuilder(string $sheetName): array {
        // Create temporary directory
        $tempDir = sys_get_temp_dir() . '/' . uniqid('xlsx_');
        mkdir($tempDir);
        mkdir($tempDir . '/_rels');
        mkdir($tempDir . '/xl');
        mkdir($tempDir . '/xl/_rels');
        mkdir($tempDir . '/xl/worksheets');

        // Create [Content_Types].xml
        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">
                        <Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>
                        <Default Extension="xml" ContentType="application/xml"/>
                        <Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>
                        <Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>
                        </Types>';
        file_put_contents($tempDir . '/[Content_Types].xml', $contentTypes);

        // Create _rels/.rels
        $rels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>
                </Relationships>';
        file_put_contents($tempDir . '/_rels/.rels', $rels);

        // Create xl/workbook.xml
        $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                    <workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">
                    <sheets>
                    <sheet name="' . htmlspecialchars($sheetName) . '" sheetId="1" r:id="rId1"/>
                    </sheets>
                    </workbook>';
        file_put_contents($tempDir . '/xl/workbook.xml', $workbook);

        // Create xl/_rels/workbook.xml.rels
        $workbookRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                        <Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">
                        <Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>
                        </Relationships>';
        file_put_contents($tempDir . '/xl/_rels/workbook.xml.rels', $workbookRels);

        // Create worksheet content
        $worksheet = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>
                      <worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">
                      <sheetData>';

        return [
            'tempDir' => $tempDir,
            'worksheetContent' => $worksheet              
        ];
    }

    /**
     * Add directory contents to ZIP recursively
     * 
     * @param string $source Source directory
     * @param ZipArchive $zip ZIP archive
     * @param string $prefix Path prefix
     * @return void
     */
    protected function addDirectoryToZip(string $source, ZipArchive $zip, string $prefix): void {
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($source),
            RecursiveIteratorIterator::SELF_FIRST
        );

        foreach ($iterator as $file) {
            if ($file->isFile()) {
                $relativePath = $prefix . substr($file->getRealPath(), strlen($source) + 1);
                $relativePath = str_replace('\\', '/', $relativePath);
                $zip->addFile($file->getRealPath(), $relativePath);
            }
        }
    }

    /**
     * Delete directory recursively
     * 
     * @param string $dir Directory path
     * @return void
     */
    protected function deleteDirectory(string $dir): void {
        if (!is_dir($dir)) return;
        
        $files = array_diff(scandir($dir), ['.', '..']);
        foreach ($files as $file) {
            $path = $dir . '/' . $file;
            is_dir($path) ? $this->deleteDirectory($path) : unlink($path);
        }
        rmdir($dir);
    }
}