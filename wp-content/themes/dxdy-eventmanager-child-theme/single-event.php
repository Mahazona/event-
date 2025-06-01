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

							<!-- RSVP FORM START -->
							<?php
							// Handle RSVP form submission
							if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['event_rsvp_nonce'])) {
								if (wp_verify_nonce($_POST['event_rsvp_nonce'], 'event_rsvp')) {
									$name  = sanitize_text_field($_POST['rsvp_name']);
									$email = sanitize_email($_POST['rsvp_email']);
									if ($name && $email) {
										$rsvps = get_post_meta(get_the_ID(), '_event_rsvps', true);
										if (!is_array($rsvps)) $rsvps = [];
										$rsvps[] = [
											'name'  => $name,
											'email' => $email,
											'date'  => current_time('mysql'),
										];
										update_post_meta(get_the_ID(), '_event_rsvps', $rsvps);

										// --- Send notification emails ---

										// Admin email
										$admin_email = get_option('sem_notification_admin_email', get_option('admin_email'));
										$event_title = get_the_title();
										$event_url   = get_permalink();
										$subject_admin = sprintf(__('New RSVP for: %s', 'simple-event-manager'), $event_title);
										$message_admin = sprintf(
											__("A new RSVP has been submitted for the event \"%s\":\n\nName: %s\nEmail: %s\nEvent link: %s", 'simple-event-manager'),
											$event_title, $name, $email, $event_url
										);
										wp_mail($admin_email, $subject_admin, $message_admin);

										// User confirmation email
										$subject_user = sprintf(__('Your RSVP for: %s', 'simple-event-manager'), $event_title);
										$message_user = sprintf(
											__("Thank you for registering for \"%s\"!\n\nEvent link: %s\n\nWe look forward to seeing you.", 'simple-event-manager'),
											$event_title, $event_url
										);
										wp_mail($email, $subject_user, $message_user);

										echo '<p style="color:green;">Thank you for your RSVP!</p>';
									} else {
										echo '<p style="color:red;">Please enter a valid name and email.</p>';
									}
								}
							}
							?>

							<form method="post" style="margin-top:2em; margin-bottom:2em; border:1px solid #eee; padding:1em; max-width:400px;">
								<h3>RSVP for this Event</h3>
								<p>
									<label for="rsvp_name">Name:</label><br>
									<input type="text" name="rsvp_name" id="rsvp_name" required>
								</p>
								<p>
									<label for="rsvp_email">Email:</label><br>
									<input type="email" name="rsvp_email" id="rsvp_email" required>
								</p>
								<?php wp_nonce_field('event_rsvp', 'event_rsvp_nonce'); ?>
								<p>
									<button type="submit">RSVP</button>
								</p>
							</form>

							<?php
							// Display RSVP list
							$rsvps = get_post_meta(get_the_ID(), '_event_rsvps', true);
							if (is_array($rsvps) && count($rsvps)) {
								echo '<h4>RSVP List:</h4><ul>';
								foreach ($rsvps as $rsvp) {
									echo '<li>' . esc_html($rsvp['name']) . ' (' . esc_html($rsvp['email']) . ')</li>';
								}
								echo '</ul>';
							}
							?>
							<!-- RSVP FORM END -->

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
					// Using simpler text-based navigation to avoid parent theme function dependency.
					$next_label     = esc_html__( 'Next event', 'eventmanager-child' );
					$previous_label = esc_html__( 'Previous event', 'eventmanager-child' );

					the_post_navigation(
						array(
							'next_text' => '<p class="meta-nav">' . $next_label . ' <span aria-hidden="true">&rarr;</span></p><p class="post-title">%title</p>',
							'prev_text' => '<p class="meta-nav"><span aria-hidden="true">&larr;</span> ' . $previous_label . '</p><p class="post-title">%title</p>',
							'in_same_term' => false, // Set to true if you want to navigate within the same event_category
							// 'taxonomy'     => 'event_category', // Specify taxonomy if in_same_term is true
						)
					);
					?>

				<?php endwhile; // End of the loop. ?>
			</div>
		</div>
	</main><?php get_footer(); ?>
