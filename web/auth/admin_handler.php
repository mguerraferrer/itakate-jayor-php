<?php

/** 
 * Validate authentication and authorization for ADMIN users
 */
if ($_SESSION['userSession']['isAdmin'] !== true) {
    header('Location: ../auth/access_denied');
    exit;
}