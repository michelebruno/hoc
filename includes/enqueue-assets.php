<?php

if (!defined('ABSPATH')) {
    exit();
}

/**
 * Registra gli script per TurBo Addons
 *
 * @return void
 *
 *
 * @todo controllare che WP non carichi a sua volta il proprio bootstrap
 */
function turbo_addons_scripts()
{

    /* Slick slider */
    if (file_exists(dirname(__DIR__) . '/elementor/assets/lib/slick/slick.min.js')) {
        wp_enqueue_script('slick', plugins_url() . '/elementor/assets/lib/slick/slick.min.js', array('jquery'));
    } else {
        wp_enqueue_script('slick', plugin_dir_url(__DIR__) . 'assets/lib/slick/slick.min.js', array('jquery'));
    }

    wp_enqueue_style('slick', plugin_dir_url(__DIR__) . 'assets/lib/slick/slick.css');
    wp_enqueue_style('slick-theme', plugin_dir_url(__DIR__) . 'assets/lib/slick/slick-theme.css');

    wp_enqueue_style('hoc', plugin_dir_url(__DIR__) . 'assets/style.css');

}


add_action('wp_enqueue_scripts', 'turbo_addons_scripts', 999);

function turbo_addons_inline_footer()
{
    echo <<<EOT
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
EOT;
}

add_action('wp_footer', 'turbo_addons_inline_footer');

