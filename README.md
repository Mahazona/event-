# WordPress Event Management System

A lightweight, custom WordPress plugin and theme integration that creates a complete Event Management System.

## Features

### Core Features
- ✅ Custom Post Type for Events
- ✅ Event management in WordPress admin
- ✅ Date, time, and location fields
- ✅ Email notifications when events are published
- ✅ Frontend event listing with shortcode `[list_events]`
- ✅ Single event pages with custom template
- ✅ Archive page for all events
- ✅ RSVP functionality with email confirmations
- ✅ Admin RSVP management
- ✅ Responsive design
- ✅ Security best practices (nonces, sanitization, escaping)

### Shortcode Usage
```php
// Basic usage
[list_events]

// With limit
[list_events limit="5"]

// With category (if you add taxonomy)
[list_events category="workshop"]

// Combined
[list_events limit="3" category="conference"]