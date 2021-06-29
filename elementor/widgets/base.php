<?php

namespace HOC\Elementor\Widgets;

use \Elementor\Widget_Base as Elementor_Widget_Base;

use HOC\Elementor\Controls;
use WP_Query;
use WP_Term;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/**
 * @property Controls $controlli
 */
abstract class Base extends Elementor_Widget_Base
{

    public $settings;

    public $controlli;

    /**
     * __construct
     *
     * @param mixed $data
     * @param mixed $args
     *
     * @return void
     *
     * @inheritDoc
     */
    public function __construct($data = [], $args = null)
    {
        parent::__construct($data, $args);

        $this->controlli = new Controls($this);
    }

    /**
     * For debugging purpose only.
     */
    public function log_settings()
    {
        echo '<script>console.log(JSON.parse(\'' . json_encode($this->get_settings_for_display()) . '\'))</script>';
    }

    public function log_to_console($content, $type = 'string')
    {
        if ($type == "json")
            echo '<script>console.log(JSON.parse(\'' . json_encode($this->get_settings_for_display()) . '\'))</script>';


        if ($type == "string")
            echo "<script>console.log('$content')</script>";
    }


    public function query_posts(array $query_args = [])
    {
        if (!$s = $this->settings) {
            $s = $this->get_settings_for_display();
        }

        if (function_exists('pll_current_language')) $q_args['lang'] = pll_current_language();

        if (!empty($s['query_string']) && $s['query_string'] !== '' && $s['query_string']) {
            return new WP_Query($s['query_string']);
        }

        $q_args['nopaging'] = true;

        $q_args['post_type'] = $s['post_types'];

        if ($s['tags_and'] === 'true' && $s['tags']) {
            $q_args['tag__in'] = $s['tags'];
        } elseif ($s['tags']) {
            $q_args['tag__in'] = $s['tags'];
        }

        if ($s['categories_and'] === 'true' && $s['categories']) {
            $q_args['category__and'] = $s['categories'];
        } elseif ($s['categories']) {

            $categories_in = $s['categories'];

            foreach ($s["categories"] as $category) {
                $cats = get_categories(["child_of" => $category]);
                $cats = array_map(function (WP_Term $item) {
                    return $item->term_id;
                }, $cats);
                $categories_in = array_merge($categories_in, $cats);
            }

            $q_args['category__in'] = $categories_in;
        }

        if ($s['bologna_cinema']) {
            foreach ($s['bologna_cinema'] as $bcc) {

                $arr['taxonomy'] = 'bologna_cinema';

                $arr['field'] = 'id';

                $arr['terms'] = $bcc;

                $q_args['tax_query'][] = $arr;
            }

            $q_args['tax_query']['operator'] = ($s['bologna_and'] === 'true') ? 'AND' : 'IN';
        }

        $q_args['category__not_in'] = $s['categories_not'];

        $q_args['tag__not_in'] = $s['tags_not'];

        return new WP_Query($q_args);
    }
}
