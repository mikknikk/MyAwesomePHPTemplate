<?php
/** main.php
 * This is the main PHP file which is required from all pages.
 */

// Start the session
session_start();

// Require the necessary files.
require_once('conf.php');
require_once('functions.php');
require_once('html.php');

// Logout logic
if (isset($_GET['logout'])) {
    logout();
}

// Generate CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    generateCsrfToken();
}

// Check for error messages
$error = $_GET['error'] ?? null;
