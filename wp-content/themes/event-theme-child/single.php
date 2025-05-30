<?php get_header(); ?>

<div class="container">
    <?php while (have_posts()): the_post(); ?>
        <article class="single-post">
            <header class="post-header">
                <h1 class="post-title"><?php the_title(); ?></h1>
                <div class="post-meta">
                    <span class="post-date"><?php echo get_the_date(); ?></span>
                    <span class="post-author">by <?php the_author(); ?></span>
                </div>
            </header>
            
            <?php if (has_post_thumbnail()): ?>
                <div class="post-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            
            <div class="post-content">
                <?php the_content(); ?>
            </div>
            
            <footer class="post-footer">
                <?php
                the_post_navigation(array(
                    'prev_text' => '← Previous Post',
                    'next_text' => 'Next Post →'
                ));
                ?>
            </footer>
        </article>
    <?php endwhile; ?>
</div>

<style>
.single-post {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.post-header {
    margin-bottom: 2rem;
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 1rem;
}

.post-title {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.post-meta {
    color: #666;
    font-size: 0.9rem;
}

.post-featured-image {
    margin-bottom: 2rem;
    text-align: center;
}

.post-featured-image img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
}

.post-content {
    font-size: 1.1rem;
    line-height: 1.8;
    margin-bottom: 2rem;
}

.post-content h2,
.post-content h3 {
    margin-top: 2rem;
    margin-bottom: 1rem;
}

.post-footer {
    border-top: 1px solid #eee;
    padding-top: 2rem;
}
</style>

<?php get_footer(); ?>