<?php
$args = array(
    'post_type' => 'event',
    'posts_per_page' => intval($atts['limit']),
    'post_status' => 'publish',
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
    $args['tax_query'] = array(
        array(
            'taxonomy' => 'event_category',
            'field' => 'slug',
            'terms' => $atts['category']
        )
    );
}

$events = new WP_Query($args);

if ($events->have_posts()) :
    echo '<div class="sem-events-list">';
    
    while ($events->have_posts()) : $events->the_post();
        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
        $event_time = get_post_meta(get_the_ID(), '_event_time', true);
        $event_location = get_post_meta(get_the_ID(), '_event_location', true);
        ?>
        
        <div class="sem-event-item">
            <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
            
            <div class="sem-event-meta">
                <?php if ($event_date): ?>
                    <div class="sem-meta-item">
                        <strong><?php _e('Date:', 'simple-event-manager'); ?></strong>
                        <span><?php echo date('F j, Y', strtotime($event_date)); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($event_time): ?>
                    <div class="sem-meta-item">
                        <strong><?php _e('Time:', 'simple-event-manager'); ?></strong>
                        <span><?php echo date('g:i A', strtotime($event_time)); ?></span>
                    </div>
                <?php endif; ?>
                
                <?php if ($event_location): ?>
                    <div class="sem-meta-item">
                        <strong><?php _e('Location:', 'simple-event-manager'); ?></strong>
                        <span><?php echo esc_html($event_location); ?></span>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
            
            <!-- RSVP Form -->
            <div class="sem-rsvp-form">
                <h3><?php _e('RSVP for this Event', 'simple-event-manager'); ?></h3>
                <div id="sem-rsvp-message"></div>
                
                <form id="sem-rsvp-form" method="post">
                    <div class="sem-form-group">
                        <label for="rsvp_name"><?php _e('Your Name', 'simple-event-manager'); ?></label>
                        <input type="text" id="rsvp_name" name="rsvp_name" required>
                    </div>
                    
                    <div class="sem-form-group">
                        <label for="rsvp_email"><?php _e('Your Email', 'simple-event-manager'); ?></label>
                        <input type="email" id="rsvp_email" name="rsvp_email" required>
                    </div>
                    
                    <button type="submit" class="sem-btn sem-btn-primary">
                        <?php _e('RSVP Now', 'simple-event-manager'); ?>
                    </button>
                    
                    <input type="hidden" name="event_id" value="<?php echo get_the_ID(); ?>">
                </form>
            </div>
            
        </article>
    </div>
    
    <?php
endwhile;

get_footer();
?>