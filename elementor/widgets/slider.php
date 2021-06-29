<?php

namespace HOC\Elementor\Widgets;

if (!defined('ABSPATH')) {

    exit; // Exit if accessed directly.

}

/*
 *
 * @propery \Turbo\Elementor\Controls $controlli;
 *
 */

class Slider extends Base
{

    public function get_name()
    {
        return 'turbo_slider';
    }

    public function get_title()
    {
        return 'TurBo Slider';
    }

    public function get_icon()
    {
        return 'fas fa-code';
    }

    public function get_categories()
    {
        return ['general', 'pro-elements'];
    }

    protected function _register_controls()
    {


        /*
         * Inizio del pannello di controllo "Layout"
         */

        $this->start_controls_section(

            'section_layout',

            [

                'label' => __('Layout'),

                'tab' => \Elementor\Controls_Manager::TAB_CONTENT

            ]

        );

        $this->controlli->colonne();
        $this->controlli->posts_per_page();
        $this->controlli->image_size();
        $this->controlli->image_ratio([
            "selectors" => [
                "{{WRAPPER}} .turbo-bg-img-container" => "padding-top: calc( {{SIZE}} * 100% );"
            ]
        ]);
        $this->controlli->tag_html_titolo();
        $this->add_control(

            'clickable',

            [

                'label' => 'Rendi cliccabile',

                'type' => \Elementor\Controls_Manager::CHOOSE,

                'options' => [
                    'false' => [
                        'title' => 'No',
                        'icon' => 'fa fa-times'
                    ],
                    'title' => [
                        'title' => 'Solo titolo',
                        'icon' => 'fa fa-header'
                    ],
                    'slide' => [
                        'title' => 'Slide intera',
                        'icon' => 'fa fa-square-o'
                    ]

                ],

                'default' => 'slide',

                'toggle' => false

            ]

        );
        $this->end_controls_section();


        /*
         * Sezione "QUERY"
         */
        $this->controlli->query($this);
        $this->controlli->sezione_tipografia();
        $this->controlli->sezione_tipografia('title', "{{WRAPPER}} .turbo-spaced-title");

        $this->start_controls_section(
            "stile_button",
            [
                'label' => __("Button"),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'margin',
            [
                'label' => __('Padding'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .turbo-button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'padding',
            [
                'label' => __('Margin'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .turbo-button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render()
    {
        $s = $this->get_settings_for_display();

        $query = $this->query_posts();

        $data['slidesToShow'] = $s['colonne'];

        $data['dots'] = true;

        $breakpoints = \Elementor\Core\Responsive\Responsive::get_breakpoints(); // Array ( [xs] => 0 [sm] => 480 [md] => 768 [lg] => 1025 [xl] => 1440 [xxl] => 1600 )

        $data["responsive"] = [];

        if (array_key_exists('colonne_tablet', $s) && $s["colonne_tablet"]) {
            $data["responsive"][] = [
                "breakpoint" => $breakpoints["lg"],
                "settings" => [
                    "slidesToShow" => $s["colonne_tablet"],
                    "slidesToScroll" => $s["posts_per_page"],
                    "dots" => false
                ]
            ];
        }

        if (array_key_exists('colonne_mobile', $s) && $s["colonne_mobile"]) {
            $data["responsive"][] = [
                "breakpoint" => $breakpoints["md"],
                "settings" => [
                    "slidesToShow" => $s["colonne_mobile"],
                    "slidesToScroll" => $s["posts_per_page"],
                    "dots" => false
                ]
            ];
        }

        /* [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 480,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
          ] */

        $data = json_encode($data);

        $shown = 0;

        if ($query->have_posts()) {

            ?>
        <div class="turbo-slider" style="display:none;" data-slick='<?php echo $data; ?>'>

            <?php
            if (!$query->have_posts()) {
                echo 'Nessun risultato';
            }

            while ($query->have_posts() && $shown < $s['posts_per_page']) {

                $query->the_post();

                global $post;

                $post_utils = new \HOC\Post($post);

                if (has_post_thumbnail()) {
                    $shown++;
                    $post_type = get_post_type();
                    $a_tag = '<a href="' . get_permalink() . '" >';
                    ?>

                    <div>
                        <?php if ($s['clickable'] === 'slide') echo $a_tag; ?>
                        <div class="turbo-slide-container turbo-bg-img-container">
                            <div class="turbo-slide turbo-bg-img-item"
                                 style="background-image: url(<?php the_post_thumbnail_url($s['image_size']) ?>)">
                                <div class="turbo-slide-inner">
                                    <div class="turbo-slide-content">
                                        <div class="turbo-slide-categorie">

                                            <?php if ($post_utils->has_categories()) echo join('', $post_utils->get_categories(function ($cat) {
                                                return "<span class=\"badge badge-pill badge-primary font-weight-normal text-uppercase \">" . $cat->name . " </span>";
                                            })); ?>
                                        </div>
                                        <?php if ($s['clickable'] === 'title') echo $a_tag; ?>
                                        <<?php echo $s['tag_html_titolo']; ?>
                                        class="turbo-spaced-title"><?php the_title(); ?>
                                    </<?php echo $s['tag_html_titolo']; ?>>
                                    <?php if ($s['clickable'] === 'title') echo '</a>'; ?>
                                </div>
                                <div class="turbo-slide-read-more">
                                    <a href="<?php the_permalink(); ?>">
                                        <button class="turbo-button">Scopri di più...</button>
                                    </a>
                                </div>
                                <?php if (($post_type == 'esperienza' || $post_type == 'deals') && $prezzo = get_post_meta(get_the_ID(), 'prezzo', true)) {
                                    ?>
                                    <div class="turbo-slide-buy-now">
                                    <h4>€ <?php echo $prezzo ?> </h4>
                                    <button class="elementor-button turbo-button">Compra ora!</button>
                                    </div><?php
                                } ?>

                            </div>
                        </div>
                    </div>
                    <?php if ($s['clickable'] === 'slide') echo '</a>'; ?>

                    </div>

                <?php }
            } ?>

            </div>

            <?php

        }

        // Ripristina Query & Post Data originali

        wp_reset_query();

        wp_reset_postdata();
    }
}
