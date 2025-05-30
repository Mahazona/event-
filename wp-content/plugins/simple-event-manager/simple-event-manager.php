<?php
/**
 * Plugin Name: Simple Event Manager
 * Plugin URI: https://example.com
 * Description: A lightweight event management system for WordPress
 * Version: 1.0.0
 * Author: Your Name
 * License: GPL v2 or later
 * Text Domain: simple-event-manager
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SEM_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SEM_PLUGIN_PATH', plugin_dir_path(__FILE__));
define('SEM_VERSION', '1.0.0');

// Main plugin class
class SimpleEventManager {
    
    public function __construct() {
        add_action('init', array($this, 'init'));
        add_action('plugins_loaded', array($this, 'load_textdomain'));
        register_activation_hook(__FILE__, array($this, 'activate'));
        register_deactivation_hook(__FILE__, array($this, 'deactivate'));
    }
    
    public function init() {
        $this->load_dependencies();
        $this->init_hooks();
    }
    
    private function load_dependencies() {
        require_once SEM_PLUGIN_PATH . 'includes/class-events-cpt.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-email-notifications.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-rsvp-handler.php';
        require_once SEM_PLUGIN_PATH . 'includes/class-admin-settings.php';
    }
    
    private function init_hooks() {
        new SEM_Events_CPT();
        new SEM_Email_Notifications();
        new SEM_RSVP_Handler();
        new SEM_Admin_Settings();
        
        add_shortcode('list_events', array($this, 'list_events_shortcode'));
        add_action('wp_enqueue_scripts', array($this, 'enqueue_frontend_scripts'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function list_events_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 10,
            'category' => ''
        ), $atts);
        
        ob_start();
        include SEM_PLUGIN_PATH . 'templates/event-list-shortcode.php';
        return ob_get_clean();
    }
    
    public function enqueue_frontend_scripts() {
        wp_enqueue_style('sem-frontend', SEM_PLUGIN_URL . 'assets/css/frontend.css', array(), SEM_VERSION);
        wp_enqueue_script('sem-frontend', SEM_PLUGIN_URL . 'assets/js/frontend.js', array('jquery'), SEM_VERSION, true);
        wp_localize_script('sem-frontend', 'sem_ajax', array(
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('sem_rsvp_nonce')
        ));
    }
    
    public function enqueue_admin_scripts() {
        wp_enqueue_style('sem-admin', SEM_PLUGIN_URL . 'assets/css/admin.css', array(), SEM_VERSION);
        wp_enqueue_script('sem-admin', SEM_PLUGIN_URL . 'assets/js/admin.js', array('jquery'), SEM_VERSION, true);
    }
    
    public function activate() {
        // Create RSVP table
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_rsvps';
        
        $charset_collate = $wpdb->get_charset_collate();
        
        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            event_id bigint(20) NOT NULL,
            name tinytext NOT NULL,
            email varchar(100) NOT NULL,
            rsvp_date datetime DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (id)
        ) $charset_collate;";
        
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
        
        // Set default options
        add_option('sem_admin_email', get_option('admin_email'));
        
        // Flush rewrite rules
        flush_rewrite_rules();
    }
    
    public function deactivate() {
        flush_rewrite_rules();
    }
    
    public function load_textdomain() {
        load_plugin_textdomain('simple-event-manager', false, dirname(plugin_basename(__FILE__)) . '/languages/');
    }
}

// Initialize the plugin
new SimpleEventManager();