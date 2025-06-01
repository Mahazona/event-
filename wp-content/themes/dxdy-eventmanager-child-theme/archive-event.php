<?php
/**
 * The template for displaying archive pages for the 'event' CPT.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Event Manager Child
 */

get_header(); ?>

	<main id="wp--skip-link--target" class="wp-block-group" tabindex="-1">
		<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
			<div class="wp-block-group alignwide" style="padding-right:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
				
				<?php if ( have_posts() ) : ?>
					<header class="page-header alignwide">
						<?php
						// Use post_type_archive_title() for CPT archives
						post_type_archive_title( '<h1 class="page-title">', '</h1>' );
						// You can also add a description if your CPT supports it or add custom text
						// the_archive_description( '<div class="archive-description">', '</div>' );
						?>
					</header><div class="sem-event-list">
						<?php
						/* Start the Loop */
						while ( have_posts() ) :
							the_post();
							?>
							<article id="post-<?php the_ID(); ?>" <?php post_class('sem-event-item'); ?>>
								<header class="entry-header">
									<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>
								</header><?php if ( function_exists( 'eventmanager_child_display_event_meta' ) ) : ?>
									<div class="event-meta">
										<?php eventmanager_child_display_event_meta(); ?>
									</div>
								<?php endif; ?>
								
								<div class="entry-summary">
									<?php the_excerpt(); ?>
								</div><footer class="entry-footer">
									<a href="<?php echo esc_url( get_permalink() ); ?>" class="read-more-link">
										<?php esc_html_e( 'View Event Details &rarr;', 'eventmanager-child' ); ?>
									</a>
								</footer></article><?php
						endwhile;
						?>
					</div><?php
					// Previous/next page navigation.
					// Using the_posts_pagination for archive pages.
					the_posts_pagination(
						array(
							'prev_text'          => esc_html__( 'Previous', 'eventmanager-child' ),
							'next_text'          => esc_html__( 'Next', 'eventmanager-child' ),
							'before_page_number' => '<span class="meta-nav screen-reader-text">' . esc_html__( 'Page', 'eventmanager-child' ) . ' </span>',
						)
					);

				else :
					// If no content, include the "No posts found" template.
					// You might want to create a content-none.php or similar in your child theme
					// or adapt from the parent. For simplicity, a direct message:
					?>
					<section class="no-results not-found">
						<header class="page-header">
							<h1 class="page-title"><?php esc_html_e( 'No Events Found', 'eventmanager-child' ); ?></h1>
						</header><div class="page-content">
							<p><?php esc_html_e( 'It seems we can&rsquo;t find any upcoming events. Perhaps try a different search?', 'eventmanager-child' ); ?></p>
							<?php // get_search_form(); // Optional: include a search form ?>
						</div></section><?php
				endif;
				?>
			</div>
		</div>
	</main><?php get_footer(); ?>
