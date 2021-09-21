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

//    /* Slick slider */
//    if (file_exists(dirname(__DIR__) . '/elementor/assets/lib/slick/slick.min.js')) {
//        wp_enqueue_script('slick', plugins_url() . '/elementor/assets/lib/slick/slick.min.js', array('jquery'));
//    } else {
//        wp_enqueue_script('slick', plugin_dir_url(__DIR__) . 'assets/lib/slick/slick.min.js', array('jquery'));
//    }
//
//    wp_enqueue_script('swiper', "https://unpkg.com/swiper@7/swiper-bundle.min.js", [],null, true);
        wp_enqueue_style('swiper', "https://unpkg.com/swiper@7/swiper-bundle.min.css");


        if (!wp_script_is('swiper', 'registered')) {
            wp_register_script('swiper', "https://unpkg.com/swiper@7/swiper-bundle.min.js", [], null, true);
        }

        $frontendAssets = include dirname(__DIR__) . "/build/index.asset.php";

//    wp_enqueue_script('wp-api');

        wp_enqueue_style("hoc", get_template_directory_uri() . "/build/style-index.css", ['elementor-frontend', 'swiper'], $frontendAssets["version"]);


        wp_enqueue_script(
            "hoc",
            get_template_directory_uri(__DIR__) . "/build/index.js",
            $frontendAssets["dependencies"],
            $frontendAssets["version"],
            true);


        if (WP_DEBUG) {
//            wp_enqueue_script('livereload', 'http://localhost:35729/livereload.js?snipver=1');
        }

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

