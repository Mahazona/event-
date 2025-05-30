<?php
get_header();
?>

<div class="container">
    <header class="page-header">
        <h1 class="page-title"><?php _e('Upcoming Events', 'simple-event-manager'); ?></h1>
    </header>
    
    <div class="sem-events-archive">
        <?php if (have_posts()) : ?>
            <div class="sem-events-list">
                <?php while (have_posts()) : the_post();
                    $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                    $event_time = get_post_meta(get_the_ID(), '_event_time', true);
                    $event_location = get_post_meta(get_the_ID(), '_event_location', true);
                    ?>
                    
                    <article class="sem-event-item">
                        <?php if (has_post_thumbnail()): ?>
                            <div class="sem-event-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('medium'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        
                        <div class="sem-event-content">
                            <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                            
                            <div class="sem-event-meta">
                                <?php if ($event_date): ?>
                                    <span class="sem-event-date">
                                        <strong><?php _e('Date:', 'simple-event-manager'); ?></strong>
                                        <?php echo date('F j, Y', strtotime($event_date)); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($event_time): ?>
                                    <span class="sem-event-time">
                                        <strong><?php _e('Time:', 'simple-event-manager'); ?></strong>
                                        <?php echo date('g:i A', strtotime($event_time)); ?>
                                    </span>
                                <?php endif; ?>
                                
                                <?php if ($event_location): ?>
                                    <span class="sem-event-location">
                                        <strong><?php _e('Location:', 'simple-event-manager'); ?></strong>
                                        <?php echo esc_html($event_location); ?>
                                    </span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="sem-event-excerpt">
                                <?php the_excerpt(); ?>
                            </div>
                            
                            <div class="sem-event-actions">
                                <a href="<?php the_permalink(); ?>" class="sem-btn sem-btn-primary">
                                    <?php _e('View Details & RSVP', 'simple-event-manager'); ?>
                                </a>
                            </div>
                        </div>
                    </article>
                    
                <?php endwhile; ?>
            </div>
            
            <div class="pagination">
                <?php
                the_posts_pagination(array(
                    'prev_text' => __('Previous', 'simple-event-manager'),
                    'next_text' => __('Next', 'simple-event-manager'),
                ));
                ?>
            </div>
            
        <?php else : ?>
            <p><?php _e('No events found.', 'simple-event-manager'); ?></p>
        <?php endif; ?>
    </div>
</div>

<?php get_footer(); ?>