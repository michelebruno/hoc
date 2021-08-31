<?php


namespace HOC\Elementor\Widgets;


use Elementor\Controls_Manager;

class CampoDisciplinare extends Base
{
    public function get_name()
    {
        return 'hoc-campo-disciplinare';
    }

    public function get_title()
    {
        return 'Campo disciplinare';
    }

    public function get_icon()
    {
        return 'fa fa-math';
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
                'label' => __('CampoDisciplinare'),
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
        <div class="campidiscipinari
        transition group
        shadow
        m-auto
        lg:w-4/5
        bg-primary hover:bg-primary-dark
        p-4 pt-6 rounded-lg">
            <a href="" class="block w-full h-full no-underline group-hover:no-underline">
                <?php echo wp_get_attachment_image($image['id'], 'large', false, [
                        'class' => "w-4/5 block m-auto"
                ]); ?>

                <div class="text-center text-white pt-6 font-bold m-0 leading-none"><?php echo $testo; ?>
                    <ion-icon name="arrow-forward-outline"></ion-icon>
                </div>
            </a>
        </div>

        <?php

    }


}
