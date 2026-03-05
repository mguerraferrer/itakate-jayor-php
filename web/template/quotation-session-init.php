<?php
session_start();

require_once __DIR__ . '/../../autoload.php';
$quotationSession = new QuotationSession();
$quotationSessionCart = new QuotationSession();