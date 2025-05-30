<?php get_header(); ?>

<div class="container">
    <?php while (have_posts()): the_post(); ?>
        <article class="single-page">
            <header class="page-header">
                <h1 class="page-title"><?php the_title(); ?></h1>
            </header>
            
            <?php if (has_post_thumbnail()): ?>
                <div class="page-featured-image">
                    <?php the_post_thumbnail('large'); ?>
                </div>
            <?php endif; ?>
            
            <div class="page-content">
                <?php the_content(); ?>
            </div>
        </article>
    <?php endwhile; ?>
</div>

<style>
.single-page {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.page-header {
    margin-bottom: 2rem;
    text-align: center;
    border-bottom: 1px solid #eee;
    padding-bottom: 1rem;
}

.page-title {
    font-size: 2.5rem;
}

.page-featured-image {
    margin-bottom: 2rem;
    text-align: center;
}

.page-content {
    font-size: 1.1rem;
    line-height: 1.8;
}
</style>

<?php get_footer(); ?>