<?php
class EventPostType {
    
    public function __construct() {
        add_action('init', array($this, 'register_post_type'));
        add_action('add_meta_boxes', array($this, 'add_meta_boxes'));
        add_action('save_post', array($this, 'save_meta_boxes'));
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_scripts'));
    }
    
    public function register_post_type() {
        $args = array(
            'labels' => array(
                'name' => 'Events',
                'singular_name' => 'Event',
                'add_new' => 'Add New Event',
                'add_new_item' => 'Add New Event',
                'edit_item' => 'Edit Event',
                'new_item' => 'New Event',
                'view_item' => 'View Event',
                'search_items' => 'Search Events',
                'not_found' => 'No events found',
                'not_found_in_trash' => 'No events found in Trash'
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail'),
            'menu_icon' => 'dashicons-calendar-alt',
            'rewrite' => array('slug' => 'events'),
            'show_in_rest' => true
        );
        
        register_post_type('event', $args);
    }
    
    public function add_meta_boxes() {
        add_meta_box(
            'event_details',
            'Event Details',
            array($this, 'event_details_callback'),
            'event',
            'normal',
            'high'
        );
    }
    
    public function event_details_callback($post) {
        wp_nonce_field('event_meta_box', 'event_meta_box_nonce');
        
        $event_date = get_post_meta($post->ID, '_event_date', true);
        $event_time = get_post_meta($post->ID, '_event_time', true);
        $event_location = get_post_meta($post->ID, '_event_location', true);
        
        echo '<table class="form-table">';
        echo '<tr>';
        echo '<th><label for="event_date">Event Date</label></th>';
        echo '<td><input type="date" id="event_date" name="event_date" value="' . esc_attr($event_date) . '" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th><label for="event_time">Event Time</label></th>';
        echo '<td><input type="time" id="event_time" name="event_time" value="' . esc_attr($event_time) . '" /></td>';
        echo '</tr>';
        echo '<tr>';
        echo '<th><label for="event_location">Location</label></th>';
        echo '<td><input type="text" id="event_location" name="event_location" value="' . esc_attr($event_location) . '" class="regular-text" /></td>';
        echo '</tr>';
        echo '</table>';
    }
    
    public function save_meta_boxes($post_id) {
        if (!isset($_POST['event_meta_box_nonce']) || !wp_verify_nonce($_POST['event_meta_box_nonce'], 'event_meta_box')) {
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
        if ('post.php' != $hook && 'post-new.php' != $hook) {
            return;
        }
        
        global $post_type;
        if ('event' != $post_type) {
            return;
        }
        
        wp_enqueue_style('sem-admin', SEM_PLUGIN_URL . 'assets/admin.css');
    }
}
?>