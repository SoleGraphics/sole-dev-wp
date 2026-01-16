<?php
/**
 * Link Confirmation
 * Shows confirmation dialog for links pointing to production site
 */

if (!defined('ABSPATH')) {
    exit;
}

class Sole_Dev_Link_Confirmation {
    
    private $production_url;
    
    public function __construct() {
        // Only initialize if proxy URL is defined
        if (!defined('SOLE_DEV_PROXY_URL') || !SOLE_DEV_PROXY_URL) {
            return;
        }
        
        $this->production_url = SOLE_DEV_PROXY_URL;
        $this->init();
    }
    
    private function init() {
        // Add JavaScript to admin footer
        add_action('admin_footer', [$this, 'add_script']);
        
        // Add JavaScript to frontend footer
        add_action('wp_footer', [$this, 'add_script']);
    }
    
    public function add_script() {
        $production_url = esc_js($this->production_url);
        $production_domain = esc_js(parse_url($this->production_url, PHP_URL_HOST));
        ?>
        <script>
        (function() {
            // Get production domain for comparison
            const productionDomain = '<?php echo $production_domain; ?>';
            const productionUrl = '<?php echo $production_url; ?>';
            const currentDomain = window.location.hostname;
            
            // Only run if we're not already on production
            if (currentDomain === productionDomain) {
                return;
            }
            
            // Function to check if a URL points to production
            function isProductionUrl(url) {
                if (!url) return false;
                
                try {
                    const linkUrl = new URL(url, window.location.origin);
                    return linkUrl.hostname === productionDomain;
                } catch (e) {
                    // If URL parsing fails, check string match
                    return url.includes(productionDomain) || url.startsWith(productionUrl);
                }
            }
            
            // Add click handler to all links
            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                
                if (!link || !link.href) {
                    return;
                }
                
                // Check if link points to production
                if (isProductionUrl(link.href)) {
                    const confirmed = confirm(
                        '⚠️ WARNING: This link points to the PRODUCTION site (' + productionDomain + ').\n\n' +
                        'Are you sure you want to leave the development environment?'
                    );
                    
                    if (!confirmed) {
                        e.preventDefault();
                        e.stopPropagation();
                        return false;
                    }
                }
            }, true); // Use capture phase to catch early
        })();
        </script>
        <?php
    }
}

