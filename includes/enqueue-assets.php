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

}


add_action('wp_enqueue_scripts', 'turbo_addons_scripts');

function turbo_addons_inline_footer()
{
    echo <<<EOT
    <script>
        jQuery(document) . ready(function ($) {
            $('.turbo-slider') . slick() . show();
            $(window) . resize(function () {
                $('.turbo-slider') . not('.slick-initialized') . slick('resize');
            });
            $(window) . on('orientationchange', function () {
                $('.turbo-slider') . not('.slick-initialized') . slick('resize');
            });
        });
    </script >
EOT;
}

add_action('wp_footer', 'turbo_addons_inline_footer');

