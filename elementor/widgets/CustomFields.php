<?php


namespace HOC\Elementor\Widgets;


use Elementor\Controls_Manager;

class Team extends Base
{
    protected $css_prefix = "turbo-custom-field";

    protected $output;

    /**
     * @var array[] $data
     * @todo aggiungere logo
     */
    protected $campi = [
        "indirizzo" => [
            "src" => "acf"
        ],
        "telefono" => [
            "src" => "acf"
        ],
        "autore" => [
            "src" => "acf"
        ],
        "orari" => [
            "src" => "acf"
        ],
        "cucina" => [
            "src" => "acf"
        ],
        "logo" => [
            "src" => "acf",
            "type" => "image"
        ]
    ];

    public function get_name()
    {
        return "hoc-team-member";
    }

    public function get_title()
    {
        return __("HOC team member");
    }

    public function get_categories()
    {
        return ["theme-elements-single"];
    }


    protected function _register_controls()
    {

        $this->start_controls_section(

            'layout_section',
            [
                'label' => __('Options'),
                'tab' => Controls_Manager::TAB_CONTENT

            ]

        );

        foreach ($this->campi as $campo => $opt) {
            $this->controlli->showCustomField($campo);
        }

        $this->end_controls_section();

        $this->controlli->sezione_tipografia("label", "{{WRAPPER}} .info-partner-field-label");
        $this->controlli->sezione_tipografia("text", "{{WRAPPER}} .info-partner-field");
    }

    protected function render()
    {
        foreach ($this->campi as $campo => $args) {
            if (array_key_exists("src", $args) && $args["src"] === "acf")
                $this->render_custom_field($campo);
        }

        if ($this->output) {


            echo "<div class='{$this->css_prefix}s-container'>
                {$this->output}
            </div>";
        }
    }

    protected function render_custom_field($campo)
    {

        $settings = $this->get_settings_for_display();

        if ($this->get_settings_for_display("show_$campo") && ($meta = get_post_meta(get_the_ID(), $campo, true)) && $meta !== "-")

            $this->output .= "<div class='{$this->css_prefix}-outer {$this->css_prefix}-$campo-outer'>
                <strong class='{$this->css_prefix}-label {$this->css_prefix}-$campo-label'>{$settings["{$campo}_label"]}</strong><span class='{$this->css_prefix} {$this->css_prefix}-$campo'>$meta</span>
            </div>";
    }

}
