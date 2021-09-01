<?php


namespace HOC\Elementor\Widgets;

use Elementor\Controls_Manager;

class Progetti extends Base
{
    public function get_name()
    {
        return 'hoc-progetti-slider';
    }

    public function get_title()
    {
        return 'Progetti';
    }

    public function get_icon()
    {
        return 'fa fa-math';
    }

    public function get_categories()
    {
        return ['general'];
    }


    protected function _register_controls()
    {
        $this->start_controls_section('controlli');

        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'titolo',
            [
                'type' => Controls_Manager::TEXT,
                'label' => 'Titolo',
                'default' => "titolo Progetto",
                'label_block' => true
            ]
        );
        $repeater->add_control(
            'sottotitolo',
            [
                'type' => Controls_Manager::TEXT,
                'label' => 'Sottotitolo',
                'default' => "Storytelling digitale",
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'descr',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => 'Descrizione',
                'default' => "PoliCultura è un concorso di storytelling digitale per la scuola italiana, aperto a scuole di ogni ordine e grado. È attivo non-stop dal 2006.",
                'label_block' => true
            ]
        );

        $repeater->add_control('immagine', [
            'type' => Controls_Manager::MEDIA,
            'label' => 'Immagine',

        ]);

        $this->add_control(
            'progetti',
            [
                'label' => __('Progetti'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'titolo' => __('Title #1'),
                    ],
                ],
                'title_field' => '{{{ titolo }}}',
            ]
        );


        $this->end_controls_section();

    }

    public function get_script_depends()
    {
        return ['hoc'];
    }

    public function get_style_depends()
    {
        return ['hoc'];
    }


    protected function render()
    {
        $progetti = $this->get_settings_for_display('progetti');

        $this->log_settings();
        ?>
        <div class="swiper swiper-container hoc-projects-swiper px-1 pb-6 ">
            <!-- Additional required wrapper -->
            <div class="swiper-wrapper items-stretch h-144">
                <?php
                foreach ($progetti

                         as $progetto) {
                    ?>
                    <div class="swiper-slide
                    rounded overflow-hidden
                    flex flex-col
                    my-6 h-auto
                    bg-white">
                    <div class="h-1/2 w-full">
                        <?php echo wp_get_attachment_image($progetto['immagine']['id'], 'large', false, [
                            "class" => "w-full h-full object-cover"
                        ]) ?>
                    </div>


                    <div class="p-4">
                        <h3 class="my-4"><?php echo $progetto['titolo']; ?></h3>
                        <p class="text-sm"><?php echo $progetto['descr']; ?></p>
                    </div>

                    </div><?php
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
        <?php
    }


}
