<?php


namespace HOC\Elementor\Widgets;


use Elementor\Controls_Manager;

class Link extends Base
{
    public function get_name()
    {
        return 'hoc-link';
    }

    public function get_title()
    {
        return 'Icone Homepage';
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
        $this->start_controls_section('controlli');
        $this->add_control(
            'image',
            [
                'label' => __('Choose Image'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'default' => [
                    'url' => \Elementor\Utils::get_placeholder_image_src(),
                ]
            ]
        );

        $this->add_control(
            'testo',
            [
                'type' => Controls_Manager::TEXT,
                'label' => 'Testo'
            ]
        );
        $this->add_control(
            'website_link',
            [
                'label' => __('Link'),
                'type' => \Elementor\Controls_Manager::URL,
                'placeholder' => __('https://your-link.com', 'plugin-domain'),
                'show_external' => false,
                'default' => [
                    'url' => '',
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );
        $this->end_controls_section();

    }

    protected function render()
    {
        $testo = $this->get_settings_for_display('testo');
        $image = $this->get_settings_for_display('image');
        ?>
        <div class="campidiscipinari">
            <a href=""  >
                <?php echo wp_get_attachment_image($image['id']); ?>

                <div class="label"><?php echo $testo; ?>
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>
            </a>
        </div>

        <?php

    }


}
