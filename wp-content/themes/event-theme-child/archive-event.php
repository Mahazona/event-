<?php get_header(); ?>

<div class="container">
    <header class="archive-header">
        <h1>Upcoming Events</h1>
    </header>
    
    <div class="events-archive">
        <?php if (have_posts()): ?>
            <?php while (have_posts()): the_post(); ?>
                <article class="event-archive-item">
                    <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                    
                    <div class="event-meta">
                        <?php
                        $event_date = get_post_meta(get_the_ID(), '_event_date', true);
                        $event_time = get_post_meta(get_the_ID(), '_event_time', true);
                        $event_location = get_post_meta(get_the_ID(), '_event_location', true);
                        ?>
                        
                        <?php if ($event_date): ?>
                            <div class="event-date">
                                <strong>Date:</strong> <?php echo date('F j, Y', strtotime($event_date)); ?>
                                <?php if ($event_time): ?>
                                    at <?php echo date('g:i A', strtotime($event_time)); ?>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($event_location): ?>
                            <div class="event-location">
                                <strong>Location:</strong> <?php echo esc_html($event_location); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="event-excerpt">
                        <?php the_excerpt(); ?>
                    </div>
                    
                    <a href="<?php the_permalink(); ?>" class="read-more">Read More</a>
                </article>
            <?php endwhile; ?>
            
            <div class="pagination">
                <?php the_posts_pagination(); ?>
            </div>
            
        <?php else: ?>
            <p>No events found.</p>
        <?php endif; ?>
    </div>
</div>

<style>
.events-archive {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.archive-header {
    text-align: center;
    margin-bottom: 40px;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.event-archive-item {
    border: 1px solid #ddd;
    padding: 20px;
    margin-bottom: 20px;
    border-radius: 5px;
}

.event-archive-item h2 {
    margin-top: 0;
    margin-bottom: 15px;
}

.event-archive-item h2 a {
    color: #333;
    text-decoration: none;
}

.event-archive-item h2 a:hover {
    color: #0073aa;
}

.event-meta {
    color: #666;
    margin-bottom: 15px;
}

.event-meta > div {
    margin-bottom: 5px;
}

.event-excerpt {
    margin-bottom: 15px;
    line-height: 1.6;
}

.read-more {
    display: inline-block;
    padding: 8px 15px;
    background: #0073aa;
    color: white;
    text-decoration: none;
    border-radius: 3px;
}

.read-more:hover {
    background: #005a87;
    color: white;
}
</style>

<?php get_footer(); ?>