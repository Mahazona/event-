<?php
class EventShortcode {
    
    public function __construct() {
        add_shortcode('list_events', array($this, 'list_events_shortcode'));
    }
    
    public function list_events_shortcode($atts) {
        $atts = shortcode_atts(array(
            'limit' => 10,
            'category' => ''
        ), $atts);
        
        $args = array(
            'post_type' => 'event',
            'post_status' => 'publish',
            'posts_per_page' => intval($atts['limit']),
            'meta_key' => '_event_date',
            'orderby' => 'meta_value',
            'order' => 'ASC',
            'meta_query' => array(
                array(
                    'key' => '_event_date',
                    'value' => date('Y-m-d'),
                    'compare' => '>='
                )
            )
        );
        
        if (!empty($atts['category'])) {
            $args['meta_query'][] = array(
                'key' => '_event_category',
                'value' => sanitize_text_field($atts['category']),
                'compare' => '='
            );
        }
        
        $events = new WP_Query($args);
        
        if (!$events->have_posts()) {
            return '<p>No upcoming events found.</p>';
        }
        
        ob_start();
        echo '<div class="event-list">';
        
        while ($events->have_posts()) {
            $events->the_post();
            $event_date = get_post_meta(get_the_ID(), '_event_date', true);
            $event_time = get_post_meta(get_the_ID(), '_event_time', true);
            $event_location = get_post_meta(get_the_ID(), '_event_location', true);
            
            echo '<div class="event-item">';
            echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
            if ($event_date) {
                echo '<p class="event-date"><strong>Date:</strong> ' . date('F j, Y', strtotime($event_date));
                if ($event_time) {
                    echo ' at ' . date('g:i A', strtotime($event_time));
                }
                echo '</p>';
            }
            if ($event_location) {
                echo '<p class="event-location"><strong>Location:</strong> ' . esc_html($event_location) . '</p>';
            }
            echo '<div class="event-excerpt">' . get_the_excerpt() . '</div>';
            echo '<a href="' . get_permalink() . '" class="event-link">Read More</a>';
            echo '</div>';
        }
        
        echo '</div>';
        wp_reset_postdata();
        
        return ob_get_clean();
    }
}
?>