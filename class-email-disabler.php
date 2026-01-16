<?php
/**
 * Email Disabler
 * Prevents all outgoing emails in local development
 */

if (!defined('ABSPATH')) {
    exit;
}

class Sole_Dev_Email_Disabler {
    
    public function __construct() {
        $this->init();
    }
    
    private function init() {
        // Abort emails before they reach PHPMailer
        add_filter('wp_mail', [$this, 'disable_wp_mail'], 10, 1);
        
        // Clear all recipients from PHPMailer
        add_action('phpmailer_init', [$this, 'clear_phpmailer_recipients'], 10, 1);
    }
    
    public function disable_wp_mail($args) {
        // Prevent all outgoing emails
        return false;
    }
    
    public function clear_phpmailer_recipients($phpmailer) {
        // Prevent the message from having recipients
        $phpmailer->ClearAllRecipients();
    }
}

