<?php


namespace HOC\Elementor\Skins;

use Elementor\Controls_Manager;
use HOC\Elementor\Controls;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

class Deal extends BaseLoop
{

    protected $css_prefix = "turbo-skin-deal-";
    protected $current_permalink;

    public function get_id()
    {
        return "deal";
    }

    /**
     * @inheritDoc
     */
    public function get_title()
    {
        return __("Deal");
    }


    protected function _register_controls_actions()
    {
        add_action('elementor/element/turbo_slider/section_layout/before_section_end', [$this, 'register_layout_controls']);
        add_action('elementor/element/posts/section_layout/before_section_end', [$this, 'register_layout_controls']);
        add_action('elementor/element/posts/classic_section_design_layout/after_section_end', [$this, 'register_additional_design_controls']);
    }

    public function register_additional_design_controls()
    {
        $this->controlli->sezione_tipografia("title", "{{WRAPPER}} .turbo-skin-deal-title");
        $this->controlli->sezione_tipografia("prezzo", "{{WRAPPER}} .turbo-skin-deal-prezzo-heading");
    }

    public function register_layout_controls($parent)
    {
        $this->parent = $parent;

        $this->controlli->posts_per_page();

        $this->controlli->colonne();

        $this->controlli->image_size();

        $this->controlli->image_ratio([
            'selectors' => [
                '{{WRAPPER}} .turbo-bg-img-container ' => 'padding-top: calc( {{SIZE}} * 100% );'
            ]
        ], 0.52);

        $this->controlli->posizione_background(
            [
                'selectors' => ["{{WRAPPER}} .turbo-bg-img-item" => "background-position : {{VALUE}}"],
                'separator' => 'after'
            ]
        );

        $this->controlli->tag_html_titolo();

        $this->controlli->add_control("prezzo_text", [
            'label' => "Testo del prezzo",
            "type" => Controls_Manager::TEXT,
            "default" => "A soli € %prezzo%",
            "description" => "Usa %prezzo% come variabile",
            "separator" => "before"
        ]);

        $this->controlli->tag_html_titolo("tag_prezzo", ["label" => "Tag del prezzo"], "h4");
    }

    protected function render_post()
    {
        $this->render_post_header();

        $this->render_thumbnail();

        $this->render_begin_content_wrapper();

        $this->render_title();

        $this->render_prezzo();

        // $this->render_excerpt();

        $this->render_end_content_wrapper();

        $this->render_post_footer();

        $this->displayed++;
        // 	$this->render_post_header();
        // 	$this->render_text_header();
        // 	$this->render_title();
        // 	$this->render_meta_data();
        // 	$this->render_read_more();
        // 	$this->render_text_footer();
        // 	$this->render_post_footer();

    }

    protected function render_post_header()
    {
        $col_class = $this->get_classi_colonne();
        echo "<div class=\"$col_class\" style=\" padding-bottom: 15px; \" >";
    }

    protected function render_post_footer()
    {
        echo "</div>";
    }

    protected function render_title()
    {
        $tag = $this->getSkinSetting(Controls::TAG_HTML_TITOLO);

        $link = get_permalink();
        $titolo = get_the_title();
        echo "<a href='$link'><$tag class=\"turbo-spaced-title turbo-skin-deal-title\">$titolo</$tag></a>";
    }

    protected function render_thumbnail()
    {
        echo "<div class=\"turbo-bg-img-container \" >
            <div class=\"turbo-bg-img-item\" style=\"background-image: url('" . get_the_post_thumbnail_url() . "')\" ></div>
        </div>";
    }

    protected function render_prezzo()
    {
        if (!function_exists('get_field'))
            return;

        $prezzo = get_field("prezzo");

        $tag = $this->getSkinSetting("tag_prezzo");

        if ($prezzo) {
            echo "<$tag class='turbo-skin-deal-prezzo-heading'>" .
                str_replace("%prezzo%", "<span class=\"turbo-skin-deal-prezzo\">€ " . $prezzo . "</span>", $this->getSkinSetting("prezzo_text"))
                . "</$tag>";
        }
    }

    protected function render_excerpt()
    {
        $excpept = get_the_excerpt();
        echo "<p class='{$this->css_prefix}excerpt'>$excpept</p>";
    }

    protected function render_begin_content_wrapper()
    {
        echo "<div class='{$this->css_prefix}content ' >";
    }

    protected function render_end_content_wrapper()
    {
        echo "</div><!-- .{$this->css_prefix}content -->";
    }

}
