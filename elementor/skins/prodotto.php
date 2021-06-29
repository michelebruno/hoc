<?php

namespace HOC\Elementor\Skins;

use Elementor\Controls_Manager;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Class Prodotto
 * @package Turbo\Elementor\Skins
 * @inheritDoc
 * @deprecated
 */
class Prodotto extends Base
{

    public function get_id()
    {
        return "prodotto";
    }

    public function get_title()
    {
        return "OLD Prodotto";
    }


    protected function _register_controls_actions()
    {
        add_action('elementor/element/turbo_slider/section_layout/before_section_end', [$this, 'register_layout_controls']);

        add_action('elementor/element/posts/section_layout/before_section_end', [$this, 'register_layout_controls']);
        add_action('elementor/element/posts/classic_section_design_layout/after_section_end', [$this, 'register_additional_design_controls']);
    }

    public function register_additional_design_controls($element)
    {
        $this->parent = $element;

        $this->controlli->sezione_tipografia();

        $this->controlli->sezione_tipografia('title', '{{WRAPPER}} .turbo-spaced-title');

        $this->controlli->sezione_tipografia('prezzo', '{{WRAPPER}} .turbo-skin-prodotto-prezzo');

        $this->start_controls_section(
            'image_style_section',
            [
                'label' => __('Image'),
                'tab' => Controls_Manager::TAB_STYLE
            ]
        );

        $this->controlli->position('image');

        $this->controlli->color(
            'image_overlay',
            [
                'label' => __('Overlay'),
                'selectors' => [
                    '{{WRAPPER}} .turbo-bg-img-overlay' => 'background-color: {{VALUE}}'
                ]
            ]
        );

        $this->end_controls_section();
    }

    public function register_layout_controls($element)
    {
        # Senza questa riga, si blocca tutto. L'element deve essere associato almeno una volta.
        $this->parent = $element;

        $this->controlli->posts_per_page();

        $this->controlli->colonne();

        $this->controlli->image_size();

        $this->controlli->image_ratio([
            'selectors' => [
                '{{WRAPPER}} .turbo-skin-prodotto-loop .turbo-bg-img-container ' => 'padding-top: calc( {{SIZE}} * 100% );'
            ]
        ]);

        $this->controlli->posizione_background(
            [
                'selectors' => ["{{WRAPPER}} .turbo-bg-img-item" => "background-position : {{VALUE}}"],
                'separator' => 'after'
            ]
        );

        $this->controlli->tag_html_titolo();
    }

    public function render()
    {
        $query = $this->query_posts();

        $this->query = $query;

        if (!$query->found_posts) {
            return;
        }

        if (!$this->settings) {
            $this->settings = $this->parent->get_settings_for_display();
        }

        $settings = $this->settings;

        $this->render_loop_header();
        // It's the global `wp_query` it self. and the loop was started from the theme.
        if ($query->in_the_loop) {
            echo "in the loop";
            $this->current_permalink = get_permalink();
            $this->render_post();
        } else {
            while ($query->have_posts() && $this->displayed < $settings['prodotto_posts_per_page']) {
                $query->the_post();
                $this->render_post();
            }
        }
        wp_reset_postdata();

        $this->render_loop_footer();
    }

    protected function render_loop_header()
    {
        #var_dump($breakpoints = \Elementor\Core\Responsive\Responsive::get_breakpoints());
        //  array(6) { ["xs"]=> int(0) ["sm"]=> int(480) ["md"]=> int(576) ["lg"]=> int(769) ["xl"]=> int(1440) ["xxl"]=> int(1600) }

        ?><div class="turbo-skin-prodotto-loop row">
        <?php
        #echo $style;

    }

    protected function render_loop_footer()
    {
        ?> </div><!-- .turbo-skin-prodotto-loop.row -->
        <?php

    }

    protected function render_post()
    {
        $this->render_post_header();

        $this->render_title();

        $this->render_post_footer();

        $this->displayed++;

    }

    protected function render_post_header()
    {
        $col_class = $this->get_classi_colonne();

        echo "
        <div class=\"$col_class\" style=\" padding-bottom: 15px; \" >
            <a href=\"" . get_permalink() . "\" >
                <div class=\"turbo-skin-prodotto turbo-bg-img-container \" >
                    <div class=\"turbo-bg-img-item\" style=\"background-image: url('" . get_the_post_thumbnail_url() . "')\" >
                        <div class=\"turbo-bg-img-overlay\"></div>
                            <div class=\"turbo-skin-prodotto-inner\">";
    }

    protected function render_post_footer()
    {
        echo "          </div>
                    </div>
                </div>
            </a>
        </div>";
    }

    protected function render_title()
    {
        $tag_titolo = $this->get_settings_for_display()['prodotto_tag_html_titolo'];
        echo "<div class=\"position-relative turbo-skin-prodotto-entry\">
                                <{$tag_titolo} class=\"turbo-spaced-title\">";
        the_title();
        echo "	</$tag_titolo> ";
        if ($prezzo = get_post_meta(get_the_ID(), 'prezzo', true)) {
            echo "<div class=\"turbo-skin-prodotto-prezzo d-inline-block\">€$prezzo</div>";
        }
        echo "</div>	";
    }

}
