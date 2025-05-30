<?php
/**
 * Plugin Name:  Event Manager for dxdy
 * Description: A lightweight event management system for WordPress
 * Version: 1.0.0
 * Author: Kavindu Rajapaksha
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SEM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SEM_PLUGIN_PATH', plugin_dir_path(__FILE__));

// Main plugin class
class SimpleEventManager {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        $this->load_dependencies();
        
        // Initialize classes
        new EventPostType();
        new EventShortcode();
        new EventEmail();
        new EventSettings();
    }
    
    private function load_dependencies() {
        require_once SEM_PLUGIN_PATH . 'includes/class-event-post-type.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-event-shortcode.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-event-email.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-event-settings.php';
    }
    
    public function activate() {
        // Flush rewrite rules on activation
        flush_rewrite_rules();
    }
    
    public function deactivate() {
        // Flush rewrite rules on deactivation
        flush_rewrite_rules();
    }
}

// Initialize the plugin
new SimpleEventManager();
?>