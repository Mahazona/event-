Simple Event Manager - WordPress Plugin & Theme
Objective
This project fulfills the WordPress Developer Assignment by creating a lightweight, custom WordPress plugin and a custom child theme integration for a basic "Event Management System" within WordPress.

Author
Name: [Your Name]

Email: [Your Email (Optional)]

Website: [Your Website (Optional)]

Deliverables
This submission includes:

simple-event-manager (Plugin): A custom plugin that:

Creates an "Event" Custom Post Type (CPT).

Adds custom fields for Event Date & Time (using HTML5 datetime-local picker) and Location.

Registers an "Event Category" custom taxonomy.

Provides a [list_events] shortcode to display upcoming events, sortable by date, with optional limit and category attributes.

Includes a settings page under "Settings > Event Manager" to configure an admin email for notifications.

Sends an email notification to the configured admin email when a new event is published.

eventmanager-child (Theme): A minimal child theme for the Twenty Twenty-Four WordPress theme that:

Ensures event listings and single event views integrate with the site's look and feel (primarily inheriting from the parent).

Utilizes WordPress Template Hierarchy with archive-event.php and single-event.php.

README.md (This file): Explaining setup, usage, assumptions, and limitations.

Setup Instructions
Prerequisites
A working WordPress installation (tested on WordPress 6.x).

The Twenty Twenty-Four theme installed and activated (this child theme is dependent on it). If you wish to use a different parent theme, you will need to update the Template: line in eventmanager-child/style.css and potentially adjust styling and template files.

Installation
Plugin Installation:

Download the simple-event-manager.zip file (or create it by zipping the simple-event-manager folder).

In your WordPress admin dashboard, navigate to Plugins > Add New.

Click Upload Plugin.

Choose the simple-event-manager.zip file and click Install Now.

Activate the plugin.

Child Theme Installation:

Ensure the Twenty Twenty-Four theme is already installed (Appearance > Themes).

Download the eventmanager-child.zip file (or create it by zipping the eventmanager-child folder).

In your WordPress admin dashboard, navigate to Appearance > Themes.

Click Add New.

Click Upload Theme.

Choose the eventmanager-child.zip file and click Install Now.

Activate the "Event Manager Child (Twenty Twenty-Four)" theme.

Configuration
Admin Email for Notifications:

After activating the plugin, navigate to Settings > Event Manager in the WordPress admin area.

Enter the email address where you want to receive notifications when new events are published.

Click Save Settings. (Defaults to the site admin email if not set).

Usage
Creating Events
Navigate to Events > Add New in the WordPress admin menu.

Fill in the Event Title.

Enter the event Description in the main content editor.

In the Event Details meta box:

Select the Event Date & Time using the date-time picker.

Enter the Event Location.

Assign Event Categories if desired (from the "Event Categories" meta box).

Set a Featured Image (Event Cover Image) if desired.

Click Publish.

Displaying Events on the Frontend
1. Event Archive Page
Events will automatically be listed on the archive page, typically found at yourdomain.com/events/.

This page uses the archive-event.php template from the child theme.

2. Single Event Page
Clicking on an event title from the archive or shortcode list will take you to the single event page.

This page uses the single-event.php template from the child theme.

3. Shortcode: [list_events]
You can display a list of upcoming events on any page or post using the [list_events] shortcode.

Available Attributes:

limit: (Optional) The maximum number of events to display.

Example: [list_events limit="3"] (shows the next 3 upcoming events)

Defaults to showing all upcoming events if omitted.

category: (Optional) The slug of the event category (or a comma-separated list of slugs) to filter by.

Example: [list_events category="workshops"] (shows upcoming events from the "workshops" category)

Example: [list_events category="music,festivals"] (shows upcoming events from "music" OR "festivals" categories)

Defaults to showing events from all categories if omitted.

Combined Usage:

[list_events limit="5" category="conferences"]

Assumptions & Known Limitations
Parent Theme: This child theme is specifically designed for the Twenty Twenty-Four WordPress theme. Using a different parent theme may require adjustments to style.css (the Template: line) and template files (archive-event.php, single-event.php) to ensure proper layout and styling.

Date & Time Picker: The plugin uses the HTML5 <input type="datetime-local"> for the event date and time. Browser support is generally good, but appearance may vary. No custom JavaScript date/time picker is implemented for simplicity, as per the "minimal" approach, though the assignment mentioned "use DateTime picker" which this fulfills at a basic HTML5 level.

Styling: Styling is minimal and primarily relies on the parent theme (Twenty Twenty-Four) to ensure the "look and feel" match. Custom CSS in the child theme is limited to basic structure and readability of event-specific elements.

Email Delivery: Email notifications rely on WordPress's wp_mail() function. Successful email delivery depends on the server's mail configuration. For robust email delivery on production sites, an SMTP plugin is often recommended.

Timezones: Event times are stored as entered. The "upcoming events" logic uses current_time('Y-m-d H:i:s') which respects the WordPress timezone setting. Display formatting also uses WordPress date/time settings. Ensure your WordPress timezone (Settings > General) is correctly configured.

Security: Basic WordPress security best practices (nonces, sanitization, escaping) have been implemented. However, for a production environment, further security audits and hardening might be necessary.

Responsiveness: Basic responsiveness is inherited from the Twenty Twenty-Four parent theme. The custom styles added are generally fluid.

Error Handling: Basic error handling is in place (e.g., for email configuration). More extensive error logging or user feedback mechanisms are not implemented for minimalism.

Bonus RSVP Feature: The optional RSVP feature has not been implemented in this submission to focus on delivering the core requirements robustly.

Code Quality & WordPress Best Practices
The code aims for readability and follows WordPress coding standards and best practices.

Proper use of WordPress hooks, actions, and filters.

CPTs and taxonomies are registered correctly.

Meta boxes are implemented with security considerations (nonces, capability checks, sanitization).

The Settings API is used for the plugin's configuration page.

Template hierarchy is respected in the child theme.

Thank you for the opportunity to complete this assignment.