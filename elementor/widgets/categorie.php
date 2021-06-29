<?php

namespace HOC\Elementor\Widgets;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/*
 *  Le tassonomie sono da scartare sono
 **/
$taxonomies = [
    "nav_menu",
    "link_category",
    "post_format",
    "language",
    "post_translations",
    "term_language",
    "term_translations",
    "elementor_library_type",
    "elementor_library_category",
    "elementor_font_type"
];


class Categorie extends Base

{

    public $output;

    public function get_name()
    {

        return 'turbo-categorie';
    }

    public function get_title()
    {

        return 'TurBo Categorie';
    }

    public function get_icon()
    {

        return 'fa fa-code';
    }

    public function get_categories()
    {

        return ['general', 'pro-elements'];
    }

    protected function _register_controls()
    {

        $this->start_controls_section(

            'layout_section',
            [
                'label' => __('Options'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT

            ]

        );

        $this->add_control(

            'cat',
            [
                'label' => 'Mostra categorie Esplora',
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
            ]

        );

        $this->add_control(
            'cat_label',
            [
                'label' => __('Label categorie'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Categories') . ":",
                'condition' => [
                    "cat" => "true"
                ]
            ]
        );

        $this->add_control(

            'only_children',
            [
                'label' => 'Mostra solo categorie figlie',
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'condition' => [
                    "cat" => "true"
                ]
            ]

        );

        $this->add_control(

            'bcc',
            [
                'label' => 'Mostra Bologna come al cinema',
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'before',
            ]

        );

        $this->add_control(
            'bcc_label',
            [
                'label' => __('Label BCC'),
                'description' => 'Descrizione delle categorie Bologna come al cinema.',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Bologna come al cinema') . ": ",
                'condition' => [
                    "bcc" => "true"
                ]
            ]
        );

        $this->add_control(
            'tag',
            [
                'label' => 'Mostra tag',
                'label_on' => 'Sì',
                'label_off' => 'No',
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'return_value' => 'true',
                'separator' => 'before',
            ]

        );

        $this->add_control(
            'tag_label',
            [
                'label' => __('Label tag'),
                'description' => 'Descrizione dei tag WordPress.',
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => __('Tags') . ":",
                'condition' => [
                    "tag" => "true"
                ]
            ]
        );

        $this->end_controls_section();

        /*

         * Stile

         */

        $this->controlli->sezione_tipografia();
    }

    protected function render()
    {

        global $post;

        $cat_terms = [];
        $bcc_terms = [];
        $tag_terms = [];
        $s = $this->get_settings_for_display();

        if ($s['cat'] == 'true') {

            $this->output .= "<div class=\"turbo-categorie-classiche \">";

            if (array_key_exists('cat_label', $s) && $s['cat_label'] && $s['cat_label'] !== "") {
                $this->output .= "<strong>{$s['cat_label']} </strong>";
            }

            foreach (wp_get_object_terms($post->ID, 'category') as $k => $v) {

                if ($s['only_children'] == 'true' && $v->parent) {
                    $cat_terms[] = $v->name;
                } elseif (!$s['only_children'] == 'true') {
                    $cat_terms[] = $v->name;
                }
            }

            $this->output .= join(', ', $cat_terms) . "</div>";
        }

        if ($s['bcc'] == 'true') {
            $this->output .= "<div class=\"turbo-categorie-bcc \">";

            if (array_key_exists('bcc_label', $s) && $s['bcc_label'] && $s['bcc_label'] !== "") {
                $this->output .= "<strong>{$s['bcc_label']} </strong>";
            }

            foreach (wp_get_object_terms($post->ID, 'bologna_cinema') as $k => $v) {
                $bcc_terms[] = $v->name;
            }

            $this->output .= join(', ', $bcc_terms) . "</div>";
        }

        if ($s['tag'] == 'true') {

            $this->output .= "<div class=\"turbo-categorie-tag \">";

            if (array_key_exists('tag_label', $s) && $s['tag_label'] && $s['tag_label'] !== "") {
                $this->output .= "<strong>{$s['tag_label']} </strong>";
            }

            foreach (wp_get_object_terms($post->ID, 'post_tag') as $k => $v) {
                $tag_terms[] = $v->name;
            }

            $this->output .= join(', ', $tag_terms) . "</div>";
        }

        echo $this->log_to_console(join(", ", get_taxonomies()));

        echo $this->output;
    }
}
