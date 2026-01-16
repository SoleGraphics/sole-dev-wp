<?php
/**
 * Dev Environment Warning
 * Displays a sticky warning banner on admin and frontend
 */

if (!defined('ABSPATH')) {
    exit;
}

class Sole_Dev_Warning {
    
    public function __construct() {
        $this->init();
    }
    
    private function init() {
        // Add to admin footer
        add_action('admin_footer', [$this, 'render_warning']);
        
        // Add to frontend footer
        add_action('wp_footer', [$this, 'render_warning']);
        
        // Add inline styles
        add_action('admin_head', [$this, 'add_styles']);
        add_action('wp_head', [$this, 'add_styles']);
    }
    
    public function add_styles() {
        $bar_height = '34px'; // Fixed height for the warning bar
        ?>
        <style>
            .sole-dev-warning {
                position: fixed;
                bottom: 0;
                left: 0;
                right: 0;
                height: <?php echo $bar_height; ?>;
                background-color: #dc3232;
                color: #fff;
                text-align: center;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 14px;
                font-weight: bold;
                z-index: 999999;
                box-shadow: 0 -2px 5px rgba(0, 0, 0, 0.2);
            }
            
            body {
                margin-bottom: <?php echo $bar_height; ?> !important;
            }
        </style>
        <?php
    }
    
    public function render_warning() {
        ?>
        <div class="sole-dev-warning">⚠️ SOLE DEV ENVIRONMENT</div>
        <?php
    }
}

