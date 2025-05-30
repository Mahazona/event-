<?php
// Theme setup
function simple_event_theme_setup() {
    // Add theme support
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array('search-form', 'comment-form', 'comment-list', 'gallery', 'caption'));
    
    // Register navigation menu
    register_nav_menus(array(
        'primary' => 'Primary Menu'
    ));
}
add_action('after_setup_theme', 'simple_event_theme_setup');

// Enqueue styles and scripts
function simple_event_theme_scripts() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'simple_event_theme_scripts');

// Widget areas
function simple_event_theme_widgets_init() {
    register_sidebar(array(
        'name' => 'Sidebar',
        'id' => 'sidebar-1',
        'before_widget' => '<div class="widget">',
        'after_widget' => '</div>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ));
    
    register_sidebar(array(
        'name' => 'Footer',
        'id' => 'footer-1',
        'before_widget' => '<div class="footer-widget">',
        'after_widget' => '</div>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ));
}
add_action('widgets_init', 'simple_event_theme_widgets_init');

// Custom excerpt length
function simple_event_theme_excerpt_length($length) {
    return 30;
}
add_filter('excerpt_length', 'simple_event_theme_excerpt_length');

// Custom excerpt more
function simple_event_theme_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'simple_event_theme_excerpt_more');
?>