<?php
/**
 * The template for displaying all single 'event' posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Event Manager Child
 */

get_header();
?>

	<main id="wp--skip-link--target" class="wp-block-group" tabindex="-1">
		<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50)">
			<div class="wp-block-group alignwide" style="padding-right:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50)">
				<?php
				/* Start the Loop */
				while ( have_posts() ) :
					the_post();
					?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<header class="entry-header alignwide">
							<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
							<?php
							// Optional: If you want to show post meta like date published or author,
							// you can adapt from the parent theme's single.php or content-single.php.
							// For events, the custom event meta is usually more important.
							// twenty_twenty_four_post_meta(); // Example if using TT4's meta function
							?>
						</header><div class="entry-content">
							<?php if ( has_post_thumbnail() ) : ?>
								<figure class="post-thumbnail alignwide">
									<?php the_post_thumbnail( 'large' ); // Or another appropriate size ?>
								</figure>
							<?php endif; ?>

							<div class="event-details-meta">
								<h2 class="screen-reader-text"><?php esc_html_e( 'Event Details', 'eventmanager-child' ); ?></h2>
								<?php
								if ( function_exists( 'eventmanager_child_display_event_meta' ) ) {
									// Pass true to show the "Description:" label before the content
									eventmanager_child_display_event_meta( get_the_ID(), true );
								}
								?>
							</div>

							<?php
							the_content(
								sprintf(
									wp_kses(
										/* translators: %s: Name of current post. Only visible to screen readers */
										__( 'Continue reading<span class="screen-reader-text"> "%s"</span>', 'eventmanager-child' ),
										array(
											'span' => array(
												'class' => array(),
											),
										)
									),
									get_the_title()
								)
							);

							wp_link_pages(
								array(
									'before' => '<div class="page-links">' . __( 'Pages:', 'eventmanager-child' ),
									'after'  => '</div>',
								)
							);
							?>
						</div><?php if ( get_edit_post_link() ) : ?>
							<footer class="entry-footer default-max-width">
								<?php
								edit_post_link(
									sprintf(
										/* translators: %s: Name of current post. Only visible to screen readers */
										esc_html__( 'Edit %s', 'eventmanager-child' ),
										'<span class="screen-reader-text">' . get_the_title() . '</span>'
									),
									'<span class="edit-link">',
									'</span>'
								);
								?>
							</footer><?php endif; ?>

						<?php
						// If comments are open or we have at least one comment, load up the comment template.
						if ( comments_open() || get_comments_number() ) {
							comments_template();
						}
						?>

					</article><?php
					// Previous/next post navigation.
					$twentytwentyfour_next = is_rtl() ? twenty_twenty_four_get_icon_svg( 'arrow_left', 24 ) : twenty_twenty_four_get_icon_svg( 'arrow_right', 24 );
					$twentytwentyfour_prev = is_rtl() ? twenty_twenty_four_get_icon_svg( 'arrow_right', 24 ) : twenty_twenty_four_get_icon_svg( 'arrow_left', 24 );

					$twentytwentyfour_next_label     = esc_html__( 'Next event', 'eventmanager-child' );
					$twentytwentyfour_previous_label = esc_html__( 'Previous event', 'eventmanager-child' );
                    
                    // Make sure to check if the function exists if copying from a parent theme
                    if (function_exists('twenty_twenty_four_get_icon_svg')) {
                        the_post_navigation(
                            array(
                                'next_text' => '<p class="meta-nav">' . $twentytwentyfour_next_label . $twentytwentyfour_next . '</p><p class="post-title">%title</p>',
                                'prev_text' => '<p class="meta-nav">' . $twentytwentyfour_prev . $twentytwentyfour_previous_label . '</p><p class="post-title">%title</p>',
                                'in_same_term' => false, // Set to true if you want to navigate within the same event_category
                                'taxonomy'     => 'event_category', // Specify taxonomy if in_same_term is true
                            )
                        );
                    } else {
                        // Fallback or simpler navigation if parent theme functions are not available
                        the_post_navigation(
                            array(
                                'next_text' => esc_html__( 'Next event: %title', 'eventmanager-child' ),
                                'prev_text' => esc_html__( 'Previous event: %title', 'eventmanager-child' ),
                            )
                        );
                    }
					?>

				<?php endwhile; // End of the loop. ?>
			</div>
		</div>
	</main><?php get_footer(); ?>
