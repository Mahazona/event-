<?php get_header(); ?>

<div class="container">
    <?php while (have_posts()) : the_post(); ?>
        <article class="event-single">
            <header class="event-header">
                <h1 class="event-title"><?php the_title(); ?></h1>
                
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
            </header>
            
            <div class="event-content">
                <?php the_content(); ?>
            </div>
            
            <?php if (has_post_thumbnail()): ?>
                <div class="event-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
        </article>
    <?php endwhile; ?>
</div>

<style>
.event-single {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
}

.event-header {
    margin-bottom: 30px;
    border-bottom: 1px solid #eee;
    padding-bottom: 20px;
}

.event-title {
    margin-bottom: 15px;
}

.event-meta {
    color: #666;
}

.event-meta > div {
    margin-bottom: 10px;
}

.event-content {
    line-height: 1.6;
    margin-bottom: 30px;
}

.event-image {
    text-align: center;
}
</style>

<?php get_footer(); ?>