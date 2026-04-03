<?php
/**
 * IMPORTANT NOTE: Include this file to handle authentication and logout functionality only for role-based user pages
 */

// Include authentication controller
require_once '../../app/controllers/admin/AuthController.php';

$auth = new AuthController();

// Verify if a user is logged in. If not, redirect to log in
if (!$auth->isLoggedIn()) {
    header('Location: ../auth/login');
    exit;
}

// Get current user data
$currentUser = $auth->getCurrentUser();

// Forced logout if for some reason the user couldn't be retrieved
if (!$currentUser) {
    $auth->logout();
    header('Location: ../auth/login');
    exit;
}

// Handle logout if a form is submitted or a link is accessed
if (isset($_GET['logout']) || isset($_POST['logout'])) {
    $auth->logout();
    header('Location: ../auth/login');
    exit;
}