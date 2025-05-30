<?php
class EventSettings {
    
    public function __construct() {
        add_action('admin_menu', array($this, 'add_settings_page'));
        add_action('admin_init', array($this, 'init_settings'));
    }
    
    public function add_settings_page() {
        add_options_page(
            'Event Manager Settings',
            'Event Manager',
            'manage_options',
            'event-manager-settings',
            array($this, 'settings_page_callback')
        );
    }
    
    public function init_settings() {
        register_setting('sem_settings_group', 'sem_admin_email');
        
        add_settings_section(
            'sem_settings_section',
            'Email Settings',
            array($this, 'settings_section_callback'),
            'event-manager-settings'
        );
        
        add_settings_field(
            'sem_admin_email',
            'Admin Email',
            array($this, 'admin_email_callback'),
            'event-manager-settings',
            'sem_settings_section'
        );
    }
    
    public function settings_section_callback() {
        echo '<p>Configure email settings for event notifications.</p>';
    }
    
    public function admin_email_callback() {
        $admin_email = get_option('sem_admin_email', get_option('admin_email'));
        echo '<input type="email" name="sem_admin_email" value="' . esc_attr($admin_email) . '" class="regular-text" />';
        echo '<p class="description">Email address to receive event notifications.</p>';
    }
    
    public function settings_page_callback() {
        ?>
        <div class="wrap">
            <h1>Event Manager Settings</h1>
            <form method="post" action="options.php">
                <?php
                settings_fields('sem_settings_group');
                do_settings_sections('event-manager-settings');
                submit_button();
                ?>
            </form>
        </div>
        <?php
    }
}
?>