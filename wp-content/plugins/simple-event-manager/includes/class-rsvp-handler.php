<?php
class SEM_RSVP_Handler {
    
    public function __construct() {
        add_action('wp_ajax_sem_rsvp', array($this, 'handle_rsvp'));
        add_action('wp_ajax_nopriv_sem_rsvp', array($this, 'handle_rsvp'));
        add_action('add_meta_boxes', array($this, 'add_rsvp_meta_box'));
    }
    
    public function handle_rsvp() {
        if (!wp_verify_nonce($_POST['nonce'], 'sem_rsvp_nonce')) {
            wp_die(__('Security check failed', 'simple-event-manager'));
        }
        
        $event_id = intval($_POST['event_id']);
        $name = sanitize_text_field($_POST['name']);
        $email = sanitize_email($_POST['email']);
        
        if (empty($name) || empty($email) || !is_email($email)) {
            wp_send_json_error(__('Please provide valid name and email', 'simple-event-manager'));
        }
        
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_rsvps';
        
        // Check if already RSVP'd
        $existing = $wpdb->get_var($wpdb->prepare(
            "SELECT id FROM $table_name WHERE event_id = %d AND email = %s",
            $event_id, $email
        ));
        
        if ($existing) {
            wp_send_json_error(__('You have already RSVP\'d for this event', 'simple-event-manager'));
        }
        
        $result = $wpdb->insert(
            $table_name,
            array(
                'event_id' => $event_id,
                'name' => $name,
                'email' => $email
            ),
            array('%d', '%s', '%s')
        );
        
        if ($result !== false) {
            // Send confirmation email
            $this->send_rsvp_confirmation($event_id, $name, $email);
            wp_send_json_success(__('RSVP successful! Confirmation email sent.', 'simple-event-manager'));
        } else {
            wp_send_json_error(__('Failed to save RSVP', 'simple-event-manager'));
        }
    }
    
    private function send_rsvp_confirmation($event_id, $name, $email) {
        $event = get_post($event_id);
        $event_date = get_post_meta($event_id, '_event_date', true);
        $event_time = get_post_meta($event_id, '_event_time', true);
        $event_location = get_post_meta($event_id, '_event_location', true);
        
        $subject = sprintf(__('RSVP Confirmation: %s', 'simple-event-manager'), $event->post_title);
        
        $message = sprintf(
            __("Hi %s,\n\nThank you for your RSVP!\n\nEvent: %s\nDate: %s\nTime: %s\nLocation: %s\n\nWe look forward to seeing you there!\n\nView Event: %s", 'simple-event-manager'),
            $name,
            $event->post_title,
            $event_date ? date('F j, Y', strtotime($event_date)) : __('TBD', 'simple-event-manager'),
            $event_time ? date('g:i A', strtotime($event_time)) : __('TBD', 'simple-event-manager'),
            $event_location ?: __('TBD', 'simple-event-manager'),
            get_permalink($event_id)
        );
        
        wp_mail($email, $subject, $message);
    }
    
    public function add_rsvp_meta_box() {
        add_meta_box(
            'event_rsvps',
            __('RSVPs', 'simple-event-manager'),
            array($this, 'rsvp_meta_box_callback'),
            'event',
            'side',
            'default'
        );
    }
    
    public function rsvp_meta_box_callback($post) {
        global $wpdb;
        $table_name = $wpdb->prefix . 'event_rsvps';
        
        $rsvps = $wpdb->get_results($wpdb->prepare(
            "SELECT * FROM $table_name WHERE event_id = %d ORDER BY rsvp_date DESC",
            $post->ID
        ));
        
        if (empty($rsvps)) {
            echo '<p>' . __('No RSVPs yet.', 'simple-event-manager') . '</p>';
            return;
        }
        
        echo '<div class="sem-rsvp-list">';
        foreach ($rsvps as $rsvp) {
            echo '<div class="sem-rsvp-item">';
            echo '<strong>' . esc_html($rsvp->name) . '</strong><br>';
            echo '<small>' . esc_html($rsvp->email) . '</small><br>';
            echo '<small>' . date('M j, Y g:i A', strtotime($rsvp->rsvp_date)) . '</small>';
            echo '</div>';
        }
        echo '</div>';
    }
}