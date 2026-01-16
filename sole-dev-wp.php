<?php
/**
 * Plugin Name: SOLE Dev (Wordpress)
 * Description: Help prevent common mistakes in local WordPress development. Has no impact on production sites.
 * Version: 1.0.0
 */

// Only run on local .test environments or when SOLE_DEV_ENVIRONMENT is defined and true
if (strpos($_SERVER['HTTP_HOST'] ?? '', '.test') === false && (!defined('SOLE_DEV_ENVIRONMENT') || !SOLE_DEV_ENVIRONMENT)) {
    return;
}

// Define plugin directory
define('SOLE_DEV_DIR', __DIR__);

// Load class files
require_once SOLE_DEV_DIR . '/class-email-disabler.php';
require_once SOLE_DEV_DIR . '/class-media-proxy.php';
require_once SOLE_DEV_DIR . '/class-dev-warning.php';
require_once SOLE_DEV_DIR . '/class-link-confirmation.php';

// Initialize modules
new Sole_Dev_Email_Disabler();
new Sole_Dev_Media_Proxy();
new Sole_Dev_Warning();
new Sole_Dev_Link_Confirmation();

