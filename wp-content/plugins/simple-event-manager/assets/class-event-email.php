<?php
class EventEmail {
    
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
        
        $subject = 'New Event Published: ' . $post->post_title;
        
        $message = "A new event has been published:\n\n";
        $message .= "Title: " . $post->post_title . "\n";
        $message .= "Date: " . ($event_date ? date('F j, Y', strtotime($event_date)) : 'Not set') . "\n";
        $message .= "Time: " . ($event_time ? date('g:i A', strtotime($event_time)) : 'Not set') . "\n";
        $message .= "Location: " . ($event_location ? $event_location : 'Not set') . "\n";
        $message .= "Description: " . strip_tags($post->post_content) . "\n\n";
        $message .= "View Event: " . get_permalink($post->ID);
        
        wp_mail($admin_email, $subject, $message);
    }
}
?>