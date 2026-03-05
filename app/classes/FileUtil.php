<?php

/**
 * Utility class for handling file uploads
 */
class FileUtil {

    const ALLOWED_DOC_TYPES = [
        'application/pdf',
        'application/msword',  // .doc
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'  // .docx
    ];
    const MAX_FILE_SIZE_DEFAULT = 1024 * 1024; // 1MB

    /**
     * Uploads a file and returns the relative path
     *
     * @param array $file Array from $_FILES (e.g., $_FILES['logo'])
     * @param int $maxSize Maximum size in bytes (default 1MB)
     * @param array $allowedTypes Allowed MIME types (default image types)
     * @return array Relative path or null on failure
     */
    public static function uploadFile(
        array $file,
        int $maxSize = self::MAX_FILE_SIZE_DEFAULT,
        array $allowedTypes = self::ALLOWED_DOC_TYPES
    ): array {
        // Basic validations
        if (empty($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return [
                'success' => false,
                'message' => 'Error al subir el archivo. Asegúrate de seleccionar un archivo válido.'
            ];
        }

        // Allowed file types
        if (!in_array($file['type'], $allowedTypes)) {
            return [
                'success' => false,
                'message' => 'Tipo de archivo no permitido'
            ];
        }

        // Maximum size
        if ($file['size'] > $maxSize) {
            return [
                'success' => false,
                'message' => 'El archivo excede el tamaño permitido'
            ];
        }

        // Absolute upload path
        $basePath = 'uploads/';
        $uploadDir = __DIR__ . '/../../' . $basePath;
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        // Get extension
        $fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        // Generate filename
        $fileName = 'jayor_' . time() . '_' . uniqid() . '.' . $fileExtension;
        $uploadFilePath = $uploadDir . $fileName;
        $filePath = $basePath . $fileName;

        // Move file
        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            return [
                'success' => false,
                'message' => 'Error al procesar el archivo'
            ];
        }

        return [
            'success' => true,
            'uploadFilePath' => $uploadFilePath,
            'filePath' => $filePath,
            'fileName' => $fileName,
            'originalName' => $file['name']
        ];
    }
}