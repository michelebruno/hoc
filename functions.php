<?php

    if (!defined('ABSPATH')) exit;


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

    add_theme_support('custom-logo');
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');

    if (!function_exists('pll__')) {
        function pll__($s)
        {
            return $s;
        }
    }
    if (!function_exists('pll_e')) {
        function pll_e($s)
        {
            echo $s;
        }
    }
    if (!function_exists('pll_register_string')) {
        function pll_register_string($name, $string, $context = 'polylang', $multiline = false)
        {
        }
    }

    pll_register_string("scuola", "scuola");
    pll_register_string("beni", "beni");
    pll_register_string("societa", "societa");
    pll_register_string("filtra", "Filtra per categoria:");
    pll_register_string("visit", "Vai al sito");


