<?php

namespace HOC\Elementor;

use Elementor\Plugin;
use Elementor\Widget_Base;
use HOC\Elementor\Widgets;
use WP_Query;


if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}
require_once __DIR__ . '/controls.php';

/**
 * Main Elementor Test Extension Class
 *
 * The main class that initiates and runs the plugin.
 *
 * @since 0.2.0
 */
final class Extension
{
    /**
     * Plugin Version
     *
     * @since 0.2.0
     *
     * @var string The plugin version.
     */

    const VERSION = '0.2.0';

    /**
     * Minimum Elementor Version
     *
     * @since 0.2.0
     *
     * @var string Minimum Elementor version required to run the plugin.
     */

    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    /**
     * Minimum PHP Version
     *
     * @since 0.2.0
     *
     * @var string Minimum PHP version required to run the plugin.
     */

    const MINIMUM_PHP_VERSION = '7.0';

    /**
     * Instance
     *
     * @since 0.2.0
     *
     * @access private
     * @static
     *
     * @var Extension The single instance of the class.
     */

    private static $_instance = null;

    /**
     * Instance
     *
     * Ensures only one instance of the class is loaded or can be loaded.
     *
     * @return Extension An instance of the class.
     * @since 0.2.0
     *
     * @access public
     * @static
     *
     */

    public static function instance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    /**
     * Constructor
     *
     * @since 0.2.0
     *
     * @access public
     */

    public function __construct()
    {
        add_action('plugins_loaded', [$this, 'init']);
    }


    /**
     * Initialize the plugin
     *
     * Load the plugin only after Elementor (and other plugins) are loaded.
     * Checks for basic plugin requirements, if one check fail don't continue,
     * if all check have passed load the files required to run the plugin.
     *
     * Fired by `plugins_loaded` action hook.
     *
     * @since 0.2.0
     *
     * @access public
     */

    public function init()
    {
        // Check if Elementor installed and activated
        if (!did_action('elementor/loaded')) {
            return;
        }
        // Check for required Elementor version

        if (!version_compare(ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=')) {

            add_action('admin_notices', [$this, 'admin_notice_minimum_elementor_version']);

            return;
        }
        // Check for required PHP version

        if (version_compare(PHP_VERSION, self::MINIMUM_PHP_VERSION, '<')) {

            add_action('admin_notices', [$this, 'admin_notice_minimum_php_version']);

            return;
        }
        // Add Plugin actions

        add_action('elementor/widgets/widgets_registered', [$this, 'init_widgets']);

//        add_action('elementor/init', [$this, 'init_skins']);

        // Query filters

//        add_action('elementor/query/turbo_any_type', function (WP_Query $query) {
//            $query->set('post_type', 'any');
//        });
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required Elementor version.
     *
     * @since 0.2.0
     *
     * @access public
     */

    public function admin_notice_minimum_elementor_version()
    {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(

        /* translators: 1: Plugin name 2: Elementor 3: Required Elementor version */

            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension'),

            '<strong>' . esc_html__('Elementor Test Extension', 'elementor-test-extension') . '</strong>',

            '<strong>' . esc_html__('Elementor', 'elementor-test-extension') . '</strong>',

            self::MINIMUM_ELEMENTOR_VERSION

        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Admin notice
     *
     * Warning when the site doesn't have a minimum required PHP version.
     *
     * @since 0.2.0
     *
     * @access public
     */

    public function admin_notice_minimum_php_version()
    {
        if (isset($_GET['activate'])) unset($_GET['activate']);
        $message = sprintf(

        /* translators: 1: Plugin name 2: PHP 3: Required PHP version */

            esc_html__('"%1$s" requires "%2$s" version %3$s or greater.', 'elementor-test-extension'),

            '<strong>' . esc_html__('Elementor Test Extension', 'elementor-test-extension') . '</strong>',

            '<strong>' . esc_html__('PHP', 'elementor-test-extension') . '</strong>',

            self::MINIMUM_PHP_VERSION

        );
        printf('<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message);
    }

    /**
     * Init Widgets
     *
     * Include widgets files and register them
     *
     * @since 0.2.0
     *
     * @access public
     */

    public function init_widgets()
    {
        // Include Widget files

        require_once(__DIR__ . '/widgets/base.php');

        require_once(__DIR__ . '/widgets/Link.php');
        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Link());
//
//        require_once(__DIR__ . '/widgets/scroll-icon.php');
//        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Scroll_Icon());
//
//        require_once(__DIR__ . '/widgets/informazioni-attrazione.php');
//        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Informazioni_Attrazione());
//
//        require_once(__DIR__ . '/widgets/CustomFields.php');
//        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\CustomFields());
//
//        require_once(__DIR__ . '/widgets/categorie.php');
//        Plugin::instance()->widgets_manager->register_widget_type(new Widgets\Categorie());

        // Register widget

    }

    public function init_skins()
    {

        require_once(__DIR__ . '/skins/base.php');

        require_once(__DIR__ . '/skins/BaseLoop.php');

        require_once(__DIR__ . '/skins/prodotto.php');

        require_once(__DIR__ . '/skins/square.php');

        require_once(__DIR__ . '/skins/Deal.php');

        # Aggiunge la skin al widget Post di ElementorPro

        add_action('elementor/widget/posts/skins_init', function (Widget_Base $widget) {
            $widget->add_skin(new Skins\Prodotto($widget));
            $widget->add_skin(new Skins\Square($widget));
            $widget->add_skin(new Skins\Deal($widget));
        });
    }
}

Extension::instance();
