<?php
/**
 *
 *
 * Plugin Name: TurBo Addons
 * Version:     0.1.0
 * Description: Elementi aggiuntivi per turismo.bologna.it
 * Author:      Michele Bruno
 *
 *
 */

if (!defined('ABSPATH')) exit;

/**
 * Classi
 */
//require_once plugin_dir_path(__FILE__) . 'includes/class-post.php';

/**
 * Shortcode Initializer.
 */
//require_once plugin_dir_path(__FILE__) . 'shortcodes/shortcodes.php';


/**
 * Elementor extensions Initializer.
 */
require_once plugin_dir_path(__FILE__) . 'elementor/elementor.php';

/**
 * Enqueue di script e stili.
 */
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-assets.php';
