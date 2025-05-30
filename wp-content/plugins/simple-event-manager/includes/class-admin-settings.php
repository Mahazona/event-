<?php
class SEM_Admin_Settings {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_admin_menu'));
        add_action('admin_init', array($this, 'init_settings'));
    }
    
    public function add_admin_menu() {
        add_submenu_page(
            'edit.php?post_type=event',
            __('Event Settings', 'simple-event-manager'),
            __('Settings', 'simple-event-manager'),
            'manage_options',
            'event-settings',
            array($this, 'settings_page')
        );
    }
    
    public function init_settings() {
        register_setting('sem_settings', 'sem_admin_email');
        
        add_settings_section(
            'sem_email_section',
            __('Email Settings', 'simple-event-manager'),
            array($this, 'email_section_callback'),
            'sem_settings'
        );
        
        add_settings_field(
            'sem_admin_email',
            __('Admin Email', 'simple-event-manager'),
            array($this, 'admin_email_callback'),
            'sem_settings',
            'sem_email_section'
        );
    }
    
    public function email_section_callback() {
        echo '<p>' . __('Configure email settings for event notifications.', 'simple-event-manager') . '</p>';
    }
    
    public function admin_email_callback() {
        $admin_email = get_option('sem_admin_email', get_option('admin_email'));
        echo '<input type="email" name="sem_admin_email" value="' . esc_attr($admin_email) . '" class="regular-text" />';
        echo '<p class="description">' . __('Email address to receive event notifications.', 'simple-event-manager') . '</p>';
    }
    
    public function settings_page() {
        ?>
        <div class="wrap">
            <h1><?php _e('Event Settings', 'simple-event-manager'); ?></h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('sem_settings');
                do_settings_sections('sem_settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}