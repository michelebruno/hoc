<?php

namespace HOC\Elementor\Widgets;


if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}


class Scroll_Icon extends \Elementor\Widget_Base
{

    public function get_name()
    {
        return 'turbo-scroll-icon';
    }

    public function get_title()
    {
        return 'TurBo Scroll Icon';
    }

    public function get_icon()
    {
        return 'fa fa-code';
    }

    public function get_categories()
    {
        return ['general', 'pro-elements'];
    }

    public function render()
    {
        echo '
    <div class="turbo-scroll-icon">
        <div class="container">
            <div class="chevron"></div>
            <div class="chevron"></div>
            <div class="chevron"></div>
        </div>
    </div>';
}


}
