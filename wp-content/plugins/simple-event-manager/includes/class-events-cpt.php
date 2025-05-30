<?php
class SEM_Events_CPT {
    
    public function __construct() {
        add_action('init', array($this, 'register_event_post_type'));
        add_action('add_meta_boxes', array($this, 'add_event_meta_boxes'));
        add_action('save_post', array($this, 'save_event_meta'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function register_event_post_type() {
        $args = array(
            'labels' => array(
                'name' => __('Events', 'simple-event-manager'),
                'singular_name' => __('Event', 'simple-event-manager'),
                'add_new' => __('Add New Event', 'simple-event-manager'),
                'add_new_item' => __('Add New Event', 'simple-event-manager'),
                'edit_item' => __('Edit Event', 'simple-event-manager'),
                'new_item' => __('New Event', 'simple-event-manager'),
                'view_item' => __('View Event', 'simple-event-manager'),
                'search_items' => __('Search Events', 'simple-event-manager'),
                'not_found' => __('No events found', 'simple-event-manager'),
                'not_found_in_trash' => __('No events found in trash', 'simple-event-manager')
            ),
            'public' => true,
            'has_archive' => true,
            'menu_icon' => 'dashicons-calendar-alt',
            'supports' => array('title', 'editor', 'thumbnail'),
            'rewrite' => array('slug' => 'events'),
            'show_in_rest' => true,
        );
        
        register_post_type('event', $args);
    }
    
    public function add_event_meta_boxes() {
        add_meta_box(
            'event_details',
            __('Event Details', 'simple-event-manager'),
            array($this, 'event_details_callback'),
            'event',
            'normal',
            'high'
        );
    }
    
    public function event_details_callback($post) {
        wp_nonce_field('save_event_details', 'event_details_nonce');
        
        $event_date = get_post_meta($post->ID, '_event_date', true);
        $event_time = get_post_meta($post->ID, '_event_time', true);
        $event_location = get_post_meta($post->ID, '_event_location', true);
        
        ?>
        <table class="form-table">
            <tr>
                <th><label for="event_date"><?php _e('Event Date', 'simple-event-manager'); ?></label></th>
                <td><input type="date" id="event_date" name="event_date" value="<?php echo esc_attr($event_date); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_time"><?php _e('Event Time', 'simple-event-manager'); ?></label></th>
                <td><input type="time" id="event_time" name="event_time" value="<?php echo esc_attr($event_time); ?>" /></td>
            </tr>
            <tr>
                <th><label for="event_location"><?php _e('Location', 'simple-event-manager'); ?></label></th>
                <td><input type="text" id="event_location" name="event_location" value="<?php echo esc_attr($event_location); ?>" class="regular-text" /></td>
            </tr>
        </table>
        <?php
    }
    
    public function save_event_meta($post_id) {
        if (!isset($_POST['event_details_nonce']) || !wp_verify_nonce($_POST['event_details_nonce'], 'save_event_details')) {
            return;
        }
        
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }
        
        if (!current_user_can('edit_post', $post_id)) {
            return;
        }
        
        if (isset($_POST['event_date'])) {
            update_post_meta($post_id, '_event_date', sanitize_text_field($_POST['event_date']));
        }
        
        if (isset($_POST['event_time'])) {
            update_post_meta($post_id, '_event_time', sanitize_text_field($_POST['event_time']));
        }
        
        if (isset($_POST['event_location'])) {
            update_post_meta($post_id, '_event_location', sanitize_text_field($_POST['event_location']));
        }
    }
    
    public function enqueue_admin_scripts($hook) {
        global $post_type;
        if ($post_type == 'event') {
            wp_enqueue_script('jquery-ui-datepicker');
            wp_enqueue_style('jquery-ui-datepicker-style', 'https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css');
        }
    }
}