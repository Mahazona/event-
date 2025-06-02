<?php
/**
 * Event Manager Child Theme functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package Event Manager Child
 */

/**
 * Enqueue scripts and styles.
 */
function eventmanager_child_enqueue_styles() {
	// Enqueue parent theme stylesheet.
	wp_enqueue_style(
		'twentytwentyfour-style', // Parent theme handle (check parent theme's functions.php if different)
		get_template_directory_uri() . '/style.css',
		array(),
		wp_get_theme()->parent()->get( 'Version' )
	);

	// Enqueue child theme stylesheet.
	// It depends on the parent theme's stylesheet.
	wp_enqueue_style(
		'eventmanager-child-style',
		get_stylesheet_directory_uri() . '/style.css',
		array( 'twentytwentyfour-style' ),
		wp_get_theme()->get( 'Version' ) // This only works if you have Version defined in the style.css
	);
}
add_action( 'wp_enqueue_scripts', 'eventmanager_child_enqueue_styles' );

/**
 * Enable menu support and register a primary menu location.
 */
function eventmanager_child_theme_setup() {
    // Enable support for menus
    add_theme_support( 'menus' );

    // Register a primary menu location
    register_nav_menus( array(
        'primary' => __( 'Primary Menu', 'eventmanager-child' ),
    ) );
}
add_action( 'after_setup_theme', 'eventmanager_child_theme_setup' );


/**
 * Helper function to display event meta data.
 * This can be used in archive-event.php and single-event.php to avoid code repetition.
 *
 * @param int|null $post_id The ID of the event post. Defaults to global $post.
 * @param bool $show_description_label Whether to show a label for the description on single event page.
 */
function eventmanager_child_display_event_meta( $post_id = null, $show_description_label = false ) {
	if ( null === $post_id ) {
		$post_id = get_the_ID();
	}

	if ( 'event' !== get_post_type( $post_id ) ) {
		return;
	}

	$event_datetime_raw = get_post_meta( $post_id, '_sem_event_datetime', true );
	$event_location     = get_post_meta( $post_id, '_sem_event_location', true );
	$output             = '';

    // Format date for display
    $formatted_datetime = '';
    if ($event_datetime_raw) {
        try {
            $date_obj = new DateTime($event_datetime_raw);
            // Using WordPress date and time format settings for consistency
            $formatted_datetime = $date_obj->format(get_option('date_format') . ' @ ' . get_option('time_format'));
        } catch (Exception $e) {
            $formatted_datetime = $event_datetime_raw; // Fallback to raw value
        }
    }

	if ( $formatted_datetime ) {
		$output .= '<p class="sem-event-datetime"><strong>' . esc_html__( 'Date & Time:', 'eventmanager-child' ) . '</strong> ' . esc_html( $formatted_datetime ) . '</p>';
	}
	if ( $event_location ) {
		$output .= '<p class="sem-event-location"><strong>' . esc_html__( 'Location:', 'eventmanager-child' ) . '</strong> ' . esc_html( $event_location ) . '</p>';
	}
    
    // Corrected check for post content
    $post_content = get_post_field( 'post_content', $post_id );
    if ( $show_description_label && ! empty( trim( $post_content ) ) ) {
        $output .= '<p class="sem-event-description-label"><strong>' . esc_html__( 'Description:', 'eventmanager-child' ) . '</strong></p>';
    }


	// Sanitize output before echoing
	echo wp_kses_post( $output ); // Use wp_kses_post if your output might contain HTML from trusted sources (like your own strings)
                                  // For simpler text, you might use more specific escaping, but wp_kses_post is safer for mixed content.
}

// Add any other custom functions for your child theme below.

?>
