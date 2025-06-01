# Simple Event Manager - WordPress Plugin & Theme

## Overview
A lightweight WordPress plugin and child theme for basic event management.

**Features:**
- "Event" Custom Post Type (CPT) with date, time, location, and categories.
- [list_events] shortcode with `limit` and `category` attributes.
- RSVP/registration: Visitors can RSVP to events; RSVPs are listed publicly and in the admin.
- Admin email notifications for new events.
- Minimal child theme for Twenty Twenty-Four.

## Setup

1. **Plugin:**  
   - Upload and activate the plugin via WordPress admin.
2. **Child Theme:**  
   - Upload and activate the child theme (requires Twenty Twenty-Four).

## Usage

### Creating Events
- Go to **Events > Add New**.
- Fill in event details, date/time, location, categories, and publish.

### Displaying Events

- **Archive:**  
  Events appear at `/events/` using the child theme template.

- **Single Event:**  
  Shows event details and RSVP form.

- **Shortcode:**  
  Add `[list_events]` to any page/post.

  **Attributes:**
  - `limit`: Max events to show. Example: `[list_events limit="3"]`
  - `category`: Filter by category slug(s). Example: `[list_events category="workshop,meetup"]`

### RSVP Feature
- Users RSVP with name/email on event page.
- RSVP list is shown below event details and in the admin event editor.
