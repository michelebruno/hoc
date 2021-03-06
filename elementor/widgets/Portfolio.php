<?php


namespace HOC\Elementor\Widgets;

use Elementor\Controls_Manager;

class Portfolio extends Base
{
    public function get_name()
    {
        return 'hoc-portfolio';
    }

    public function get_title()
    {
        return 'Portfolio';
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
            'nome',
            [
                'type' => Controls_Manager::TEXT,
                'label' => 'Titolo',
                'default' => "titolo Progetto",
                'label_block' => true
            ]
        );
        $repeater->add_control(
            'anno',
            [
                'type' => Controls_Manager::TEXT,
                'label' => 'Sottotitolo',
                'default' => "Storytelling digitale",
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'descrizione',
            [
                'type' => Controls_Manager::TEXTAREA,
                'label' => 'Descrizione',
                'default' => "PoliCultura è un concorso di storytelling digitale per la scuola italiana, aperto a scuole di ogni ordine e grado. È attivo non-stop dal 2006.",
                'label_block' => true
            ]
        );

        $repeater->add_control(
            'url',
            [
                'type' => Controls_Manager::URL,
                'label' => 'URL',
                'placeholder' => __('https://your-link.com', 'plugin-domain'),
                'show_external' => false,
                'default' => [
                    'url' => null,
                    'is_external' => true,
                    'nofollow' => true,
                ],
            ]
        );


        $repeater->add_control(
            'category',
            [
                'label' => __('Category'),
                'type' => \Elementor\Controls_Manager::SELECT2,
                'multiple' => true,
                'options' => [
                    'scuola' => 'Scuola',
                    'beni' => 'Beni culturali',
                    'societa' => 'Società',
                ],
                'default' => ['scuola'],
            ]
        );


        $defaults = require __DIR__ . "/portfolio-defaults.php";

        $this->add_control(
            'progetti',
            [
                'label' => __('Progetti'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => $defaults,
                'title_field' => '{{{ nome }}}',
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

        $cats = ["scuola", 'beni', 'societa'];
        ?>
        <div>
            <?php
            pll_e('Filtra per categoria:');
            foreach ($cats as $cat) {
                ?>
                <button type="checkbox" data-filter="<?php echo $cat ?>" class="rounded-xl inline-block text-sm  text-center !no-underline
                                            py-2 px-4 ml-2 border-primary border-2 text-primary leading-none hover:bg-primary active:bg-primary-dark hover:text-white hover:transition duration-500 "><?php pll_e($cat); ?></button>
                <?php
            }
            ?>
        </div>
        <?php
        foreach ($progetti as $progetto) {

            $area = "";

            foreach ($progetto['category'] as $cat) {
                $area .= pll__($cat) . " - ";
            }

            $area = trim($area, " \-");
            ?>
            <div class="border-l-primary border-l px-4 my-4" data-project <?php

            foreach ($progetto['category'] as $cat) {
                echo "data-" . $cat . "=\"true\" ";
            }
            ?>>
                <h2 class="!text-2xl mb-4"><?php echo $progetto['nome']; ?> <span
                            class="text-sm text-dark whitespace-nowrap">(<?php echo $area . " / " . $progetto["anno"] ?>)</span>
                </h2>
                <p class="!mb-0"><?php echo $progetto['descrizione'] ?></p>
                <?php if (key_exists('url', $progetto) && key_exists('url', $progetto['url'])) { ?>
                    <p><a class="!font-light" href="<?php echo $progetto['url']['url'] ?>" target="<?php echo $progetto['url']['is_external'] ? '_blank' : '_self' ?>"><?php echo $progetto['url']['url'] ?></a></p>
                    <?php } ?>
            </div>
            <?php
        }
    }
}
