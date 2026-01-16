<?php
/**
 * Media Proxy
 * Replaces local media URLs with production URLs
 */

if (!defined('ABSPATH')) {
    exit;
}

class Sole_Dev_Media_Proxy {
    
    private $production_url;
    
    public function __construct() {
        // Only initialize if proxy URL is defined and enabled
        if (!defined('SOLE_DEV_PROXY_URL') || !SOLE_DEV_PROXY_URL) {
            return;
        }
        
        if (!defined('SOLE_DEV_PROXY_ENABLED') || !SOLE_DEV_PROXY_ENABLED) {
            return;
        }
        
        $this->production_url = SOLE_DEV_PROXY_URL;
        $this->init();
    }
    
    private function init() {
        // Filter attachment URLs
        add_filter('wp_get_attachment_url', [$this, 'replace_url'], 10, 1);
        
        // Filter image sources
        add_filter('wp_get_attachment_image_src', [$this, 'replace_image_src'], 10, 1);
        
        // Filter content URLs
        add_filter('the_content', [$this, 'replace_content_urls'], 10, 1);
        
        // Filter responsive image srcsets
        add_filter('wp_calculate_image_srcset', [$this, 'replace_srcset_urls'], 10, 1);
    }
    
    public function replace_url($url) {
        if (empty($url)) {
            return $url;
        }
        
        return str_replace(home_url(), $this->production_url, $url);
    }
    
    public function replace_image_src($image) {
        if ($image && isset($image[0])) {
            $image[0] = $this->replace_url($image[0]);
        }
        return $image;
    }
    
    public function replace_content_urls($content) {
        return str_replace(home_url(), $this->production_url, $content);
    }
    
    public function replace_srcset_urls($sources) {
        if (is_array($sources)) {
            foreach ($sources as &$source) {
                if (isset($source['url'])) {
                    $source['url'] = $this->replace_url($source['url']);
                }
            }
        }
        return $sources;
    }
}

