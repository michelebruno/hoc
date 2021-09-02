<?php

    if (!defined('ABSPATH')) exit;

    /**
     * Classi
     */
//require_once get_template_directory(__FILE__) . '/includes/class-post.php';

    /**
     * Shortcode Initializer.
     */
//require_once get_template_directory(__FILE__) . '/shortcodes/shortcodes.php';


    /**
     * Elementor extensions Initializer.
     */
    require_once __DIR__ . '/elementor/elementor.php';

    /**
     * Enqueue di script e stili.
     */
    require_once __DIR__ . '/includes/enqueue-assets.php';


    add_action('after_setup_theme', 'register_my_menu');
    function register_my_menu()
    {
        register_nav_menu('primary', __('Primary Menu', 'hoc'));
    }
