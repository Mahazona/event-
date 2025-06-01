<?php
/**
 * Plugin Name:       Simple Event Manager
 * Plugin URI:        https://example.com/
 * Description:       A simple plugin to manage events, including a CPT, shortcode, and email notifications.
 * Version:           1.0.0
 * Author:            Your Name
 * Author URI:        https://example.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       simple-event-manager
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register the 'event' Custom Post Type.
 */
function sem_register_event_cpt() {
	$labels = array(
		'name'                  => _x( 'Events', 'Post type general name', 'simple-event-manager' ),
		'singular_name'         => _x( 'Event', 'Post type singular name', 'simple-event-manager' ),
		'menu_name'             => _x( 'Events', 'Admin Menu text', 'simple-event-manager' ),
		'name_admin_bar'        => _x( 'Event', 'Add New on Toolbar', 'simple-event-manager' ),
		'add_new'               => __( 'Add New', 'simple-event-manager' ),
		'add_new_item'          => __( 'Add New Event', 'simple-event-manager' ),
		'new_item'              => __( 'New Event', 'simple-event-manager' ),
		'edit_item'             => __( 'Edit Event', 'simple-event-manager' ),
		'view_item'             => __( 'View Event', 'simple-event-manager' ),
		'all_items'             => __( 'All Events', 'simple-event-manager' ),
		'search_items'          => __( 'Search Events', 'simple-event-manager' ),
		'parent_item_colon'     => __( 'Parent Events:', 'simple-event-manager' ),
		'not_found'             => __( 'No events found.', 'simple-event-manager' ),
		'not_found_in_trash'    => __( 'No events found in Trash.', 'simple-event-manager' ),
		'featured_image'        => _x( 'Event Cover Image', 'Overrides the “Featured Image” phrase for this post type. Added in 4.3', 'simple-event-manager' ),
		'set_featured_image'    => _x( 'Set cover image', 'Overrides the “Set featured image” phrase for this post type. Added in 4.3', 'simple-event-manager' ),
		'remove_featured_image' => _x( 'Remove cover image', 'Overrides the “Remove featured image” phrase for this post type. Added in 4.3', 'simple-event-manager' ),
		'use_featured_image'    => _x( 'Use as cover image', 'Overrides the “Use as featured image” phrase for this post type. Added in 4.3', 'simple-event-manager' ),
		'archives'              => _x( 'Event archives', 'The post type archive label used in nav menus. Default “Post Archives”. Added in 4.4', 'simple-event-manager' ),
		'insert_into_item'      => _x( 'Insert into event', 'Overrides the “Insert into post”/”Insert into page” phrase (used when inserting media into a post). Added in 4.4', 'simple-event-manager' ),
		'uploaded_to_this_item' => _x( 'Uploaded to this event', 'Overrides the “Uploaded to this post”/”Uploaded to this page” phrase (used when viewing media attached to a post). Added in 4.4', 'simple-event-manager' ),
		'filter_items_list'     => _x( 'Filter events list', 'Screen reader text for the filter links heading on the post type listing screen. Default “Filter posts list”/”Filter pages list”. Added in 4.4', 'simple-event-manager' ),
		'items_list_navigation' => _x( 'Events list navigation', 'Screen reader text for the pagination heading on the post type listing screen. Default “Posts list navigation”/”Pages list navigation”. Added in 4.4', 'simple-event-manager' ),
		'items_list'            => _x( 'Events list', 'Screen reader text for the items list heading on the post type listing screen. Default “Posts list”/”Pages list”. Added in 4.4', 'simple-event-manager' ),
	);

	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'events' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 20,
		'supports'           => array( 'title', 'editor', 'thumbnail', 'custom-fields' ), // Added 'thumbnail' for featured image
		'menu_icon'          => 'dashicons-calendar-alt',
		'show_in_rest'       => true, // For Gutenberg support
	);

	register_post_type( 'event', $args );
}
add_action( 'init', 'sem_register_event_cpt' );

/**
 * Register 'event_category' taxonomy for 'event' CPT.
 */
function sem_register_event_category_taxonomy() {
	$labels = array(
		'name'              => _x( 'Event Categories', 'taxonomy general name', 'simple-event-manager' ),
		'singular_name'     => _x( 'Event Category', 'taxonomy singular name', 'simple-event-manager' ),
		'search_items'      => __( 'Search Event Categories', 'simple-event-manager' ),
		'all_items'         => __( 'All Event Categories', 'simple-event-manager' ),
		'parent_item'       => __( 'Parent Event Category', 'simple-event-manager' ),
		'parent_item_colon' => __( 'Parent Event Category:', 'simple-event-manager' ),
		'edit_item'         => __( 'Edit Event Category', 'simple-event-manager' ),
		'update_item'       => __( 'Update Event Category', 'simple-event-manager' ),
		'add_new_item'      => __( 'Add New Event Category', 'simple-event-manager' ),
		'new_item_name'     => __( 'New Event Category Name', 'simple-event-manager' ),
		'menu_name'         => __( 'Event Categories', 'simple-event-manager' ),
	);
	$args = array(
		'hierarchical'      => true, // Like categories
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'event-category' ),
		'show_in_rest'      => true, // For Gutenberg support
	);
	register_taxonomy( 'event_category', array( 'event' ), $args );
}
add_action( 'init', 'sem_register_event_category_taxonomy' );


/**
 * Add meta boxes for Event Details.
 */
function sem_add_event_details_meta_box() {
	add_meta_box(
		'sem_event_details_meta_box',                 // ID
		__( 'Event Details', 'simple-event-manager' ), // Title
		'sem_render_event_details_meta_box',          // Callback function
		'event',                                      // Post type
		'normal',                                     // Context (normal, side, advanced)
		'high'                                        // Priority (high, core, default, low)
	);
}
add_action( 'add_meta_boxes', 'sem_add_event_details_meta_box' );

/**
 * Render the Event Details meta box.
 *
 * @param WP_Post $post The post object.
 */
function sem_render_event_details_meta_box( $post ) {
	// Add a nonce field for security
	wp_nonce_field( 'sem_save_event_details', 'sem_event_details_nonce' );

	// Get existing values
	$event_datetime = get_post_meta( $post->ID, '_sem_event_datetime', true );
	$event_location = get_post_meta( $post->ID, '_sem_event_location', true );

	?>
	<p>
		<label for="sem_event_datetime"><?php _e( 'Event Date & Time:', 'simple-event-manager' ); ?></label>
		<br />
		<input type="datetime-local" id="sem_event_datetime" name="sem_event_datetime" value="<?php echo esc_attr( $event_datetime ); ?>" style="width:100%; max-width:250px;"/>
        <p class="description"><?php _e( 'Select the date and time for the event.', 'simple-event-manager' ); ?></p>
	</p>
	<p>
		<label for="sem_event_location"><?php _e( 'Event Location:', 'simple-event-manager' ); ?></label>
		<br />
		<input type="text" id="sem_event_location" name="sem_event_location" value="<?php echo esc_attr( $event_location ); ?>" style="width:100%; max-width:400px;" />
        <p class="description"><?php _e( 'Enter the location of the event.', 'simple-event-manager' ); ?></p>
	</p>
	<?php
}

/**
 * Save Event Details meta box data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function sem_save_event_details_meta_data( $post_id ) {
	// Check if our nonce is set.
	if ( ! isset( $_POST['sem_event_details_nonce'] ) ) {
		return;
	}
	// Verify that the nonce is valid.
	if ( ! wp_verify_nonce( $_POST['sem_event_details_nonce'], 'sem_save_event_details' ) ) {
		return;
	}
	// If this is an autosave, our form has not been submitted, so we don't want to do anything.
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Check the user's permissions.
	if ( isset( $_POST['post_type'] ) && 'event' == $_POST['post_type'] ) {
		if ( ! current_user_can( 'edit_post', $post_id ) ) {
			return;
		}
	}

	// Sanitize and save the Event Date & Time
	if ( isset( $_POST['sem_event_datetime'] ) ) {
        // Basic sanitization for datetime-local. For more robust validation, consider parsing and reformatting.
		update_post_meta( $post_id, '_sem_event_datetime', sanitize_text_field( $_POST['sem_event_datetime'] ) );
	}

	// Sanitize and save the Event Location
	if ( isset( $_POST['sem_event_location'] ) ) {
		update_post_meta( $post_id, '_sem_event_location', sanitize_text_field( $_POST['sem_event_location'] ) );
	}
}
add_action( 'save_post_event', 'sem_save_event_details_meta_data' ); // Hook into save_post_{cpt_name}


/**
 * Shortcode [list_events] to display upcoming events.
 *
 * Attributes:
 * - limit (int): Number of events to show. Default -1 (all).
 * - category (string): Comma-separated list of event category slugs.
 */
function sem_list_events_shortcode( $atts ) {
	$atts = shortcode_atts(
		array(
			'limit'    => -1, // Default to show all upcoming events
			'category' => '',   // Default to no category filter
		),
		$atts,
		'list_events'
	);

	$current_datetime = current_time( 'Y-m-d H:i:s' ); // Get current WordPress time

	$args = array(
		'post_type'      => 'event',
		'post_status'    => 'publish',
		'posts_per_page' => intval( $atts['limit'] ),
		'meta_key'       => '_sem_event_datetime',
		'orderby'        => 'meta_value',
		'order'          => 'ASC',
		'meta_query'     => array(
			array(
				'key'     => '_sem_event_datetime',
				'value'   => $current_datetime,
				'compare' => '>=', // Events on or after current date/time
				'type'    => 'DATETIME',
			),
		),
	);

	if ( ! empty( $atts['category'] ) ) {
		$args['tax_query'] = array(
			array(
				'taxonomy' => 'event_category',
				'field'    => 'slug',
				'terms'    => array_map( 'sanitize_text_field', explode( ',', $atts['category'] ) ),
			),
		);
	}

	$events_query = new WP_Query( $args );
	$output       = '';

	if ( $events_query->have_posts() ) {
		$output .= '<ul class="sem-event-list">';
		while ( $events_query->have_posts() ) {
			$events_query->the_post();
			$event_id        = get_the_ID();
			$event_datetime  = get_post_meta( $event_id, '_sem_event_datetime', true );
			$event_location  = get_post_meta( $event_id, '_sem_event_location', true );
			
			// Format date for display
			$formatted_datetime = '';
			if ($event_datetime) {
				try {
					$date_obj = new DateTime($event_datetime);
					$formatted_datetime = $date_obj->format(get_option('date_format') . ' ' . get_option('time_format')); // Use WordPress date/time format settings
				} catch (Exception $e) {
					$formatted_datetime = $event_datetime; // Fallback to raw value if parsing fails
				}
			}


			$output .= '<li class="sem-event-item">';
			$output .= '<h3><a href="' . esc_url( get_permalink() ) . '">' . get_the_title() . '</a></h3>';
			if ( $formatted_datetime ) {
				$output .= '<p class="sem-event-datetime"><strong>' . __( 'Date:', 'simple-event-manager' ) . '</strong> ' . esc_html( $formatted_datetime ) . '</p>';
			}
			if ( $event_location ) {
				$output .= '<p class="sem-event-location"><strong>' . __( 'Location:', 'simple-event-manager' ) . '</strong> ' . esc_html( $event_location ) . '</p>';
			}
			// Optionally, add excerpt or other details
			// $output .= '<div class="sem-event-excerpt">' . get_the_excerpt() . '</div>';
			$output .= '</li>';
		}
		$output .= '</ul>';
		wp_reset_postdata(); // Restore original Post Data
	} else {
		$output .= '<p>' . __( 'No upcoming events found.', 'simple-event-manager' ) . '</p>';
	}

	return $output;
}
add_shortcode( 'list_events', 'sem_list_events_shortcode' );


/**
 * Add a settings page for the plugin.
 */
function sem_add_admin_menu() {
	add_options_page(
		__( 'Event Manager Settings', 'simple-event-manager' ), // Page title
		__( 'Event Manager', 'simple-event-manager' ),        // Menu title
		'manage_options',                                     // Capability
		'simple_event_manager_settings',                      // Menu slug
		'sem_render_settings_page'                            // Callback function
	);
}
add_action( 'admin_menu', 'sem_add_admin_menu' );

/**
 * Register plugin settings.
 */
function sem_register_settings() {
	register_setting(
		'sem_settings_group',                 // Option group
		'sem_notification_admin_email',       // Option name
		array(
			'type'              => 'string',
			'sanitize_callback' => 'sanitize_email', // Sanitize as email
			'default'           => get_option( 'admin_email' ), // Default to site admin email
		)
	);

	add_settings_section(
		'sem_notification_settings_section',                // ID
		__( 'Notification Settings', 'simple-event-manager' ), // Title
		null,                                               // Callback (optional)
		'simple_event_manager_settings'                     // Page slug
	);

	add_settings_field(
		'sem_notification_admin_email_field',                   // ID
		__( 'Admin Email for Notifications', 'simple-event-manager' ), // Title
		'sem_render_admin_email_field',                         // Callback function to render the field
		'simple_event_manager_settings',                        // Page slug
		'sem_notification_settings_section'                     // Section ID
	);
}
add_action( 'admin_init', 'sem_register_settings' );

/**
 * Render the admin email input field.
 */
function sem_render_admin_email_field() {
	$admin_email = get_option( 'sem_notification_admin_email', get_option( 'admin_email' ) );
	?>
	<input type="email" name="sem_notification_admin_email" value="<?php echo esc_attr( $admin_email ); ?>" class="regular-text" />
	<p class="description"><?php _e( 'Enter the email address to receive notifications when new events are published.', 'simple-event-manager' ); ?></p>
	<?php
}

/**
 * Render the settings page HTML.
 */
function sem_render_settings_page() {
	if ( ! current_user_can( 'manage_options' ) ) {
		return;
	}
	?>
	<div class="wrap">
		<h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
		<form action="options.php" method="post">
			<?php
			settings_fields( 'sem_settings_group' ); // Output nonce, action, and option_page fields for a settings page.
			do_settings_sections( 'simple_event_manager_settings' ); // Print out all settings sections added to a particular settings page.
			submit_button( __( 'Save Settings', 'simple-event-manager' ) );
			?>
		</form>
	</div>
	<?php
}


/**
 * Send an email notification when an event is published.
 *
 * @param int     $post_ID Post ID.
 * @param WP_Post $post    Post object.
 */
function sem_event_published_notification( $post_ID, $post ) {
    // Check if this is the 'event' post type and if it's a real publish action (not an update to an already published post)
    // The 'publish_event' hook fires on initial publish and also on updates if the status remains 'publish'.
    // To send only on initial publish, you might need to check the previous post status if available, or rely on the user flow.
    // For simplicity, this will fire if an event is saved with 'publish' status.

	$admin_email = get_option( 'sem_notification_admin_email' );
	if ( ! is_email( $admin_email ) ) {
		// If no valid email is configured, try the site admin's email as a fallback or just return.
        $admin_email = get_option('admin_email');
        if (!is_email($admin_email)) {
		    return; 
        }
	}

	$title          = $post->post_title;
	$event_datetime_raw = get_post_meta( $post_ID, '_sem_event_datetime', true );
	$location       = get_post_meta( $post_ID, '_sem_event_location', true );
	$permalink      = get_permalink( $post_ID );

    // Format date for email
    $formatted_datetime_email = $event_datetime_raw; // Fallback
    if ($event_datetime_raw) {
        try {
            $date_obj_email = new DateTime($event_datetime_raw);
            $formatted_datetime_email = $date_obj_email->format('F j, Y, g:i a'); // Example: March 10, 2024, 5:30 pm
        } catch (Exception $e) {
            // Keep $event_datetime_raw as is
        }
    }


	$subject = sprintf( __( 'New Event Published: %s', 'simple-event-manager' ), $title );

	$message  = sprintf( __( 'A new event has been published on %s:', 'simple-event-manager' ), get_bloginfo( 'name' ) ) . "\n\n";
	$message .= sprintf( __( 'Title: %s', 'simple-event-manager' ), $title ) . "\n";
	if ($formatted_datetime_email) {
        $message .= sprintf( __( 'Date & Time: %s', 'simple-event-manager' ), $formatted_datetime_email ) . "\n";
    }
    if ($location) {
	    $message .= sprintf( __( 'Location: %s', 'simple-event-manager' ), $location ) . "\n";
    }
	$message .= sprintf( __( 'View Event: %s', 'simple-event-manager' ), $permalink ) . "\n\n";
	$message .= sprintf( __( 'Edit Event: %s', 'simple-event-manager' ), get_edit_post_link( $post_ID ) ) . "\n";


	$headers = array('Content-Type: text/plain; charset=UTF-8');

	wp_mail( $admin_email, $subject, $message, $headers );
}
// Use 'publish_event' which is publish_{post_type}
add_action( 'publish_event', 'sem_event_published_notification', 10, 2 );

/**
 * Plugin activation hook.
 * Can be used to flush rewrite rules if CPTs or taxonomies are registered.
 */
function sem_activate_plugin() {
    // Ensure CPTs and taxonomies are registered before flushing
    sem_register_event_cpt();
    sem_register_event_category_taxonomy();
    flush_rewrite_rules();

    // Set default admin email if not already set
    if ( false === get_option( 'sem_notification_admin_email' ) ) {
        update_option( 'sem_notification_admin_email', get_option( 'admin_email' ) );
    }
}
register_activation_hook( __FILE__, 'sem_activate_plugin' );

/**
 * Plugin deactivation hook.
 * Can be used to flush rewrite rules.
 */
function sem_deactivate_plugin() {
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'sem_deactivate_plugin' );


// Add RSVP meta box to Event post type in admin
add_action('add_meta_boxes', function() {
    add_meta_box(
        'event_rsvp_list',
        __('Event RSVPs', 'simple-event-manager'),
        function($post) {
            $rsvps = get_post_meta($post->ID, '_event_rsvps', true);
            if (is_array($rsvps) && count($rsvps)) {
                echo '<ul>';
                foreach ($rsvps as $rsvp) {
                    echo '<li><strong>' . esc_html($rsvp['name']) . '</strong> (' . esc_html($rsvp['email']) . ')<br><small>' . esc_html($rsvp['date']) . '</small></li>';
                }
                echo '</ul>';
            } else {
                echo '<em>No RSVPs yet.</em>';
            }
        },
        'event', // post type
        'normal',
        'default'
    );
});


?>
