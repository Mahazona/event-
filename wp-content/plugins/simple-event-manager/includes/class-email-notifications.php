<?php
class SEM_Email_Notifications {
    
    public function __construct() {
        add_action('transition_post_status', array($this, 'send_event_notification'), 10, 3);
    }
    
    public function send_event_notification($new_status, $old_status, $post) {
        if ($post->post_type !== 'event') {
            return;
        }
        
        if ($new_status !== 'publish' || $old_status === 'publish') {
            return;
        }
        
        $admin_email = get_option('sem_admin_email', get_option('admin_email'));
        $event_date = get_post_meta($post->ID, '_event_date', true);
        $event_time = get_post_meta($post->ID, '_event_time', true);
        $event_location = get_post_meta($post->ID, '_event_location', true);
        
        $subject = sprintf(__('New Event Published: %s', 'simple-event-manager'), $post->post_title);
        
        $message = sprintf(
            __("A new event has been published:\n\nTitle: %s\nDate: %s\nTime: %s\nLocation: %s\n\nView Event: %s", 'simple-event-manager'),
            $post->post_title,
            $event_date ? date('F j, Y', strtotime($event_date)) : __('Not set', 'simple-event-manager'),
            $event_time ? date('g:i A', strtotime($event_time)) : __('Not set', 'simple-event-manager'),
            $event_location ?: __('Not set', 'simple-event-manager'),
            get_permalink($post->ID)
        );
        
        wp_mail($admin_email, $subject, $message);
    }
}