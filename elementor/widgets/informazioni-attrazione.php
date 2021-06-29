<?php

namespace HOC\Elementor\Widgets;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.

}


class Informazioni_Attrazione extends Base
{
    public function get_name()
    {
        return 'turbo-informazioni attrazione';
    }

    public function get_title()
    {
        return 'TurBo informazioni attrazione';
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
        $this->controlli->sezione_tipografia();

    }

    protected function render()
    {
        global $post;

        $ha_info = false;

        $indirizzo = get_post_meta($post->ID, 'indirizzo', true);

        $output = "";

        if (!empty($indirizzo) && $indirizzo && $indirizzo !== '-') {
            $ha_info = true;
            $output .= "<p class=\"turbo-informazione-attrazione\"><b>Indirizzo:</b> $indirizzo</p>";
        }

        $orari = get_post_meta($post->ID, 'orari', true);

        if (!empty($orari) && $orari && $orari !== '-') {
            $ha_info = true;
            $output .= "<p class=\"turbo-informazione-attrazione\"><b>Orari:</b> $orari</p>";
        }

        $autore = get_post_meta($post->ID, 'autore', true);

        if (!empty($autore) && $autore && $autore !== '-') {
            $ha_info = true;
            $output .= "<p class=\"turbo-informazione-attrazione\"><b>Autore:</b> $autore</p>";
        }

        $telefono = get_post_meta($post->ID, 'telefono', true);

        if (!empty($telefono) && $telefono && $telefono !== '-') {
            $ha_info = true;
            $output .= "<p class=\"turbo-informazione-attrazione\"><b>Telefono:</b> $telefono</p>";
        }

        if ($ha_info) {
            ?>
            <div class="turbo-informazioni-attrazione">
                <? echo $output; ?>

            </div>
            <?php

        }

        return;
    }


}



