<?php

class MailTemplateWebService {

    const TEMPLATE_PATH = __DIR__ . '/../../mail/templates/';

    /**
     * @throws Exception
     */
    public function getContactTemplate(array $data): string {
        $templatePath = self::TEMPLATE_PATH . 'contact-us-template.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Email template not found: {$templatePath}");
        }

        $html = file_get_contents($templatePath);

        // Replace template variables
        $html = str_replace('{{name}}', htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{email}}', htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{subject}}', htmlspecialchars($data['subject'], ENT_QUOTES, 'UTF-8'), $html);
        return str_replace('{{comments}}', htmlspecialchars($data['comments'], ENT_QUOTES, 'UTF-8'), $html);
    }

    /**
     * Generate a plain text version of the contact template
     *
     * @param array $data
     * @return string Plain text version
     */
    public function getContactTemplatePlainText(array $data): string {
        return <<<TEXT
        ¡Contacto Jayor!
        
        Nombre: {$data['name']}
        E-mail: {$data['email']}
        Asunto: {$data['subject']}
        Comentarios:
        {$data['comments']}

        TEXT;
    }

    /**
     * @throws Exception
     */
    public function getVacancyTemplate(array $data): string {
        $templatePath = self::TEMPLATE_PATH . 'vacancy-request-template.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Email template not found: {$templatePath}");
        }

        $html = file_get_contents($templatePath);

        // Replace template variables
        $html = str_replace('{{name}}', htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{email}}', htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{phone}}', htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{address}}', htmlspecialchars($data['address'], ENT_QUOTES, 'UTF-8'), $html);
        return str_replace('{{area}}', htmlspecialchars($data['area'], ENT_QUOTES, 'UTF-8'), $html);
    }

    public function getVacancyTemplatePlainText(array $data): string {
        return <<<TEXT
        Solicitud de vacante
        
        Nombre: {$data['name']}
        E-mail: {$data['email']}
        Teléfono/WhatsApp: {$data['phone']}
        Alcaldía o Municipio: {$data['address']}
        Área de interés: {$data['area']}

        TEXT;
    }

    /**
     * @throws Exception
     */
    public function getPharmaTemplate(array $data): string {
        $templatePath = self::TEMPLATE_PATH . 'pharmaco-vigilance-template.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Email template not found: {$templatePath}");
        }

        $html = file_get_contents($templatePath);

        // Replace template variables
        $display = $data['pregnancy'] === 'Sí' ? 'block' : 'none';
        $html = str_replace('{{display}}', htmlspecialchars($display, ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{name}}', htmlspecialchars($data['name'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{plName}}', htmlspecialchars($data['plName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{mlName}}', htmlspecialchars($data['mlName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{phone}}', htmlspecialchars($data['phone'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{email}}', htmlspecialchars($data['email'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{personType}}', htmlspecialchars($data['personType'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{product}}', htmlspecialchars($data['product'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{lote}}', htmlspecialchars($data['lote'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{dueDate}}', htmlspecialchars($data['dueDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{genericName}}', htmlspecialchars($data['genericName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{dose}}', htmlspecialchars($data['dose'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{admWay}}', htmlspecialchars($data['admWay'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{brand}}', htmlspecialchars($data['brand'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{healthRegister}}', htmlspecialchars($data['healthRegister'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{productUse}}', htmlspecialchars($data['productUse'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{startDate}}', htmlspecialchars($data['startDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{endDate}}', htmlspecialchars($data['endDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{reasonUse}}', htmlspecialchars($data['reasonUse'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{otherDrug}}', htmlspecialchars($data['otherDrug'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{eventHappened}}', htmlspecialchars($data['eventHappened'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{eventStartDate}}', htmlspecialchars($data['eventStartDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{eventEndDate}}', htmlspecialchars($data['eventEndDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{eventUse}}', htmlspecialchars($data['eventUse'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{eventType}}', htmlspecialchars($data['eventType'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{patName}}', htmlspecialchars($data['patName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{patPlName}}', htmlspecialchars($data['patPlName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{patMlName}}', htmlspecialchars($data['patMlName'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{gender}}', htmlspecialchars($data['gender'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{birthDate}}', htmlspecialchars($data['birthDate'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{pregnancy}}', htmlspecialchars($data['pregnancy'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{height}}', htmlspecialchars($data['height'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{weight}}', htmlspecialchars($data['weight'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{doctorPrescribe}}', htmlspecialchars($data['doctorPrescribe'], ENT_QUOTES, 'UTF-8'), $html);
        $html = str_replace('{{patPhone}}', htmlspecialchars($data['patPhone'], ENT_QUOTES, 'UTF-8'), $html);
        return str_replace('{{patEmail}}', htmlspecialchars($data['patEmail'], ENT_QUOTES, 'UTF-8'), $html);
    }

    public function getPharmaTemplatePlainText(array $data): string {
        // Build priority alert if pregnancy is indicated
        $priorityAlert = '';
        if (!empty($data['pregnancy']) && $data['pregnancy'] === 'Sí') {
            $priorityAlert = "*** ¡ALTA PRIORIDAD! ***\n\n";
        }

        return <<<TEXT
        REPORTE DE FARMACOVIGILANCIA
        
        {$priorityAlert}
        ========================================
        DATOS PERSONALES
        ========================================
        
        Nombre: {$data['name']}
        Apellido Paterno: {$data['plName']}
        Apellido Materno: {$data['mlName']}
        Teléfono: {$data['phone']}
        Correo: {$data['email']}
        Tipo de persona: {$data['personType']}
        
        ========================================
        DATOS DEL PRODUCTO
        ========================================
        
        Producto: {$data['product']}
        Caducidad: {$data['dueDate']}
        Lote No.: {$data['lote']}
        Nombre genérico: {$data['genericName']}
        Dosis: {$data['dose']}
        Vía de administración: {$data['admWay']}
        Marca: {$data['brand']}
        Registro Sanitario: {$data['healthRegister']}
        Continúa usando el producto: {$data['productUse']}
        Fecha Inicio de uso: {$data['startDate']}
        Fecha Término: {$data['endDate']}
        
        Razones por las que usa este producto:
        {$data['reasonUse']}
        
        Se encuentra utilizando algún otro medicamento y/o dispositivo médico:
        {$data['otherDrug']}
        
        ========================================
        DESCRIPCIÓN DEL EVENTO
        ========================================
        
        Qué le ocurrió cuando uso el producto:
        {$data['eventHappened']}
        
        Fecha Inicio del evento: {$data['eventStartDate']}
        Fecha Término: {$data['eventEndDate']}
        Continúa usando el producto: {$data['eventUse']}
        Tipo de evento: {$data['eventType']}
        
        ========================================
        DATOS DEL PACIENTE
        ========================================
        
        Nombre: {$data['patName']}
        Apellido Paterno: {$data['patPlName']}
        Apellido Materno: {$data['patMlName']}
        Género: {$data['gender']}
        Fecha de Nacimiento: {$data['birthDate']}
        Embarazo: {$data['pregnancy']}
        Estatura: {$data['height']}
        Peso: {$data['weight']}
        Recetado por el médico: {$data['doctorPrescribe']}
        Teléfono: {$data['patPhone']}
        Correo: {$data['patEmail']}
        
        TEXT;
    }

    /**
     * @throws Exception
     */
    public function getQuotationTemplate(array $products, array $data, $display = false): string {
        $templatePath = self::TEMPLATE_PATH . 'quotation-template.html';
        if (!file_exists($templatePath)) {
            throw new Exception("Email template not found: {$templatePath}");
        }

        $html = file_get_contents($templatePath);

        // Build products block
        $productsHtml = '';
        foreach ($products as $itemInfo) {
            if (!$itemInfo instanceof QuotationItemInfo) {
                continue;
            }

            $itemArray = $itemInfo->toArray();
            $item = $itemArray['item'] ?? [];
            $quantity = (int)($itemArray['quantity'] ?? 0);

            $productsHtml .= '<ul style="padding-bottom: 15px; list-style: none !important;">';
            $productsHtml .= '<li style="list-style: none !important; list-style-type: none !important;"><span><b>Nombre:</b></span> <span>' . htmlspecialchars($item['sku'] ?? '', ENT_QUOTES, 'UTF-8') . '</span></li>';

            $optionalFields = [
                'brandName' => 'Marca',
                'code' => 'Código',
                'measure' => 'Medida',
                'presentation' => 'Presentación',
                'bagDimensions' => 'Dimensiones (bolsa)',
                'neckDimensions' => 'Dimensiones (cuello)',
                'caliber' => 'Calibre',
                'length' => 'Longitud',
                'capacity' => 'Capacidad',
                'cbKey' => 'Clave C.B',
                'salesFactor' => 'Factor de venta',
                'healthRegister' => 'Registro Sanitario',
                'size' => 'Tamaño',
                'guideDiameter' => 'Diámetro guía',
                'color' => 'Color',
                'weight' => 'Peso',
                'volume' => 'Volumen',
                'needle' => 'Aguja'
            ];

            foreach ($optionalFields as $key => $label) {
                if (!empty($item[$key])) {
                    $productsHtml .= '<li><span><b>' . $label . ':</b></span> <span>' . htmlspecialchars((string)$item[$key], ENT_QUOTES, 'UTF-8') . '</span></li>';
                }
            }

            $productsHtml .= '<li><span><b>Cantidad:</b></span> <b><span style="color: #dc3545;">' . $quantity . '</span></b></li>';
            $productsHtml .= '</ul>';
        }

        $show = $display ? 'block' : 'none';
        $replacements = [
            '{{display}}' => htmlspecialchars((string)($show), ENT_QUOTES, 'UTF-8'),
            '{{folio}}' => htmlspecialchars((string)($data['folio'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{name}}' => htmlspecialchars((string)($data['name'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{businessName}}' => htmlspecialchars((string)($data['business_name'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{rfc}}' => htmlspecialchars((string)($data['rfc'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{productUse}}' => htmlspecialchars((string)($data['product_use'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{street}}' => htmlspecialchars((string)($data['street'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{outsideNumber}}' => htmlspecialchars((string)($data['outside_number'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{insideNumber}}' => htmlspecialchars((string)($data['inside_number'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{colony}}' => htmlspecialchars((string)($data['colony'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{state}}' => htmlspecialchars((string)($data['state'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{country}}' => htmlspecialchars((string)($data['country'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{zipcode}}' => htmlspecialchars((string)($data['zip_code'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{email}}' => htmlspecialchars((string)($data['email'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{phone}}' => htmlspecialchars((string)($data['phone'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{cell}}' => htmlspecialchars((string)($data['cell'] ?? ''), ENT_QUOTES, 'UTF-8'),
            '{{comments}}' => nl2br(htmlspecialchars((string)($data['comments'] ?? ''), ENT_QUOTES, 'UTF-8')),
            '{{products_html}}' => $productsHtml
        ];

        return str_replace(array_keys($replacements), array_values($replacements), $html);
    }

    /**
     * Generate plain text version of quotation email
     *
     * @param array $products Array of QuotationItemInfo objects
     * @param array $data Quotation data
     * @return string Plain text version
     */
    public function getQuotationTemplatePlainText(array $products, array $data): string {
        $lines = [];

        $lines[] = 'JAYOR - SOLICITUD DE COTIZACION';
        $lines[] = 'Gracias por tu solicitud. En breve te daremos respuesta.';
        $lines[] = '';
        $lines[] = '========================================';
        $lines[] = 'DETALLES DE LA COTIZACION';
        $lines[] = '========================================';
        $lines[] = 'Folio: ' . ($data['folio'] ?? '');
        $lines[] = '';
        $lines[] = '========================================';
        $lines[] = 'DATOS PERSONALES';
        $lines[] = '========================================';
        $lines[] = 'Nombre: ' . ($data['name'] ?? '');
        $lines[] = 'Razon social: ' . ($data['business_name'] ?? '');
        $lines[] = 'RFC: ' . ($data['rfc'] ?? '');
        $lines[] = 'Tipo de uso: ' . ($data['product_use'] ?? '');
        $lines[] = 'Calle: ' . ($data['street'] ?? '');
        $lines[] = 'No. exterior: ' . ($data['outside_number'] ?? '');
        $lines[] = 'No. interior: ' . ($data['inside_number'] ?? '');
        $lines[] = 'Colonia: ' . ($data['colony'] ?? '');
        $lines[] = 'Estado: ' . ($data['state'] ?? '');
        $lines[] = 'Pais: ' . ($data['country'] ?? '');
        $lines[] = 'C.P.: ' . ($data['zip_code'] ?? '');
        $lines[] = 'E-mail: ' . ($data['email'] ?? '');
        $lines[] = 'Telefono: ' . ($data['phone'] ?? '');
        $lines[] = 'Celular: ' . ($data['cell'] ?? '');
        $lines[] = 'Comentarios: ' . ($data['comments'] ?? '');
        $lines[] = '';
        $lines[] = '========================================';
        $lines[] = 'PRODUCTOS';
        $lines[] = '========================================';

        foreach ($products as $index => $itemInfo) {
            if (!$itemInfo instanceof QuotationItemInfo) {
                continue;
            }

            $itemArray = $itemInfo->toArray();
            $item = $itemArray['item'] ?? [];
            $quantity = (int)($itemArray['quantity'] ?? 0);

            $lines[] = '';
            $lines[] = 'Producto #' . ($index + 1);
            $lines[] = 'Nombre: ' . ($item['sku'] ?? '');

            $optionalFields = [
                'brandName' => 'Marca',
                'code' => 'Código',
                'measure' => 'Medida',
                'presentation' => 'Presentacion',
                'bagDimensions' => 'Dimensiones (bolsa)',
                'neckDimensions' => 'Dimensiones (cuello)',
                'caliber' => 'Calibre',
                'length' => 'Longitud',
                'capacity' => 'Capacidad',
                'cbKey' => 'Clave C.B',
                'salesFactor' => 'Factor de venta',
                'healthRegister' => 'Registro Sanitario',
                'size' => 'Tamaño',
                'guideDiameter' => 'Diámetro guia',
                'color' => 'Color',
                'weight' => 'Peso',
                'volume' => 'Volumen',
                'needle' => 'Aguja'
            ];

            foreach ($optionalFields as $key => $label) {
                if (!empty($item[$key])) {
                    $lines[] = $label . ': ' . $item[$key];
                }
            }

            $lines[] = 'Cantidad: ' . $quantity;
        }

        $lines[] = '';
        $lines[] = '========================================';

        return implode(PHP_EOL, $lines);
    }

}